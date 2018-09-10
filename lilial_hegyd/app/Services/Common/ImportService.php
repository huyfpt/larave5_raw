<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Excel;
use Hegyd\eCommerce\Models\ProductCatalog\Category;
use Hegyd\eCommerce\Models\ProductCatalog\Product;
use Hegyd\eCommerce\Models\ProductCatalog\Brand;
use Hegyd\eCommerce\Models\ProductCatalog\ProductRelated;
use Illuminate\Support\Facades\Schema;
use Hegyd\Uploads\Models\Upload;
use Symfony\Component\HttpFoundation\File\File;

class ImportService
{
    public $keyTableDeclension = [
        'variante_1',
        'valeur_variante',
        'variante_2',
        'valeur_variante_2',
        'variante_3',
        'valeur_variante_3',
        'raccord_support_pour_app._2_pieces',
        'embout',
        'usager',        
        'composition',
        'longueur_bande_de_colle',
        'tubulure',
        'sterile_ou_non_sterile',
        'contenance',
        'systeme_de_couplage',
        'type_de_support',
        'soin_et_hygiene',
        'famille_de_pansement'
    ];

    public function import($filename, $cli = null) {
        //check for zip
        $mimeTypesZip = array(
            'application/zip',
            'application/x-zip-compressed',
            'multipart/x-zip',
            'application/x-compressed'
        );
        
        // check for xlsx
        $typeAllowed = array(
            'xls',
            'xlsx',
        );
        $extZip = pathinfo($filename, PATHINFO_EXTENSION);
        $baseNameZip = pathinfo($filename, PATHINFO_BASENAME);

        // check valid
        $mimeTypeZip = mime_content_type($filename);
        if ($extZip != 'zip' || !in_array($mimeTypeZip, $mimeTypesZip))
            return [
                'message' => "Upload Fail: Unsupported file format!",
                'alert-type' => 'error',
            ];

        // path
        $tempFolder = uniqid();
        $realPath = Storage::disk()->getDriver()->getAdapter()->getPathPrefix();
        $extractPath = $realPath . 'public/imports/' . $tempFolder;
        $imagePath = $extractPath . '/images/' ;
        $missingImages = [];
        // create folder
        mkdir($extractPath, 0777, true);
        
        // zip
        $zip = new \ZipArchive;
        if ($zip->open($filename) === true) {
            
            if ($cli) echo __('Extracting ZIP archive..');
            $zip->extractTo($extractPath);
            $zip->close();
            if ($cli) echo __("done.\n");
            if ($cli) $cli->info(__('Processing import:'));

            //get file excel and check valid 
            $excelPath = $extractPath . '/produits.xlsx';
            if (!file_exists($excelPath))
                $excelPath = $extractPath . '/produits.xls';
            if (!file_exists($excelPath)) {
                return [
                    'message' => __('file_not_exist'),
                    'alert-type' => 'error',
                ];
            }
            $ext = pathinfo($excelPath, PATHINFO_EXTENSION);
            $fileSize = filesize($excelPath);
            if ($fileSize == 0)
                return [
                    'message' => __('file_not_empty'),
                    'alert-type' => 'error',
                ];
            
            /**  Identify the type of $excelPath  **/
            //$excelPath = $realPath .'public/imports/5b77c8025f6cb/produits.xlsx';
            //$imagePath = $realPath .'public/imports/5b77c8025f6cb/images/';
            $data = Excel::load($excelPath)->get()->toArray();

            $counter = -1;
            $updateCounter = 0;
            $countError = 0;
            $processedBytes = 0;
            $percentage = 0;
            $startTime = time();

            // reset category
            //$this->resetCategory();

            $productRelated = [];
            $productReference = [];

            foreach ($data as $row) {

                if (empty($row['nom_produit'])) {
                    continue;
                }

                if ($counter < 0) {
                    $counter++;
                    continue;
                }
                $product = [];

                $product['category_id']       = $this->getCategory($row);
                $product['brand_id']          = $this->getBrand($row['labo'], $row['logo_labo']);
                $product['name']              = trim($row['nom_produit']);
                $product['reference']         = trim($row['valeur_variante_0']);
                $product['description']       = trim($row['descriptif_produit_long']);
                $product['grip']              = trim($row['descriptif_court']);
                $product['table_declension'] = $this->updateTableDeclension($row);
                $product['active']            = 1;
                $product['meta_robots']       = 'INDEX, FOLLOW';
                $product['meta_title']        = $product['name'];
                $product['meta_description']  = $product['name'];

                if (Product::where('reference', $product['reference'])->first() == null)
                {
                    if ($model = Product::create($product)) {
                        echo "\n Create new product: ". $product['name'];
                        $counter++;

                        // build related data
                        $productRelated[$model->id] = explode(',', $row['produits_compatibles']);
                        $productReference[$product['reference']] = $model->id;

                        //upload main image
                        if (!empty($row['photo_principale'])) {
                            $return_upload = $this->uploadFile($imagePath, $row['photo_principale'], $model, 'main');

                            if (!$return_upload) {
                                $missingImages[] = $row['photo_principale'] . '.jpg';
                            }
                        }

                        //upload multi second image
                        if (!empty($row['photos_secondaires'])) {
                            $seconds_img = str_replace(';', ',', $row['photos_secondaires']);
                            $seconds_img_array = explode(',', $seconds_img);
                            foreach ($seconds_img_array as $seconds_img_name) {
                                $return_upload = $this->uploadFile($imagePath, $seconds_img_name, $model, 'second');

                                if (!$return_upload) {
                                    $missingImages[] = $seconds_img_name . '.jpg';
                                }
                                
                            }
                        }
                    }
                    else {
                        $countError++;
                    }
                }
                else {
                    $updateCounter++;
                }

                echo "\n";
            }

            // update related
            $this->updateProductRelated($productRelated, $productReference);

            echo "\n";
            if ($countError > 0)
                $message = "Ajouté avec succès " . ($counter - $countError) . " produit(s), mise à jour " . $updateCounter . " produit(s). " . $countError . " produit(s) ayant échoué";
            else
                $message = "Ajouté avec succès " . $counter . " produits, mise à jour " . $updateCounter . " produit(s).";
            // update number of product of brand
            Storage::deleteDirectory($extractPath);
            return [
                'missing_images' => $missingImages,
                'message' => $message,
                'alert-type' => 'success',
            ];
        } else {
            return [
                'message' => __("Impossible d'extraire le fichier."),
                'alert-type' => 'error',
            ];
        }
    }

    protected function getCategory($data)
    {
        // check exist category
        if (!empty($data['famille_n04'])) {

            $slug = str_slug(trim($data['famille_n04']));
            $category = Category::where('slug', $slug)->first();
            if (!empty($category)) {
                return $category->id;
            }
        }

        // new insert all category
        $category_id = 0;
        if (!empty($data['famille_n01'])) {
            $category_id = $this->getCategoryId($data['famille_n01'], 0);

            if (!empty($data['famille_n02'])) {
                $category_id = $this->getCategoryId($data['famille_n02'], $category_id);
            }

            if (!empty($data['famille_n03'])) {
                $category_id = $this->getCategoryId($data['famille_n03'], $category_id);
            }

            if (!empty($data['famille_n04'])) {
                $category_id = $this->getCategoryId($data['famille_n04'], $category_id);
            }
        }
        else {
            return false;
        }

        if (empty($category_id)) {
            echo "\n Fail category ";
            dd($data);
        }

        return $category_id;
    }

    protected function getCategoryId($cat_string, $parent_id = -1)
    {
        $parseName = $this->parseString($cat_string);

        $name = trim($parseName[0]);
        $slug = str_slug($name);
        $description = '';
        if (!empty($parseName[1])) {
            $description = $parseName[1];
        }

        $model = Category::updateOrCreate(
                        ['slug' => trim($slug), 'parent_id' => $parent_id],
                        ['active' => 1, 'name' => $name, 'description' => $description, 'ranking' => 0]
                    );

        return $model->id;
    }

    protected function parseString($string = '', $key = 'famille_n01')
    {
        $tmpArray = explode(',', $string);
        $array = explode(':', $tmpArray[0]);

        return $array;
    }

    protected function resetCategory()
    {
        $data = [
            [
                'name' => 'Urologie',
                'slug' => str_slug('Urologie'),
                'parent_id' => 0,
                'active' => 1,
            ],
            [
                'name' => 'Stomathérapie',
                'slug' => str_slug('Stomathérapie'),
                'parent_id' => 0,
                'active' => 1,
            ],
            [
                'name' => 'Cicatrisation',
                'slug' => str_slug('Cicatrisation'),
                'parent_id' => 0,
                'active' => 1,
            ],
        ];

        Schema::disableForeignKeyConstraints();
        Category::truncate();

        foreach ($data as $item) {
            if (Category::where('name', $item['name'])->first() == null)
            {
                Category::create($item);
            }
            
        }

        Schema::enableForeignKeyConstraints();
    }

    protected function getBrand($name, $logo = '')
    {
        $slug = str_slug($name);
        $model = Brand::where(['slug' => $slug])->first();

        if (empty($model) && !empty($logo)) {

            $slug = str_replace(['-','_','logo'], '', strtolower($logo));
            $slug = str_slug($slug);
            $model = Brand::where(['slug' => $slug])->first();

            if (!empty($model)) {
                return $model->id;
            }
        }

        if (!empty($model->id)) {
            //echo "\n Brand ID: ". $model->id;
            return $model->id;
        }
        else {
            //echo "\n Fail brand ". $name;
            return 0;
        }
    }

    protected function updateProductRelated($productRelated = [], $productReference)
    {
        $relatedModel = new productRelated;
        foreach ($productRelated as $product_id=>$reference)
        {
            $related_ids = [];
            foreach ($reference as $item) {
                if (!empty($productReference[$item])) {
                    $related_ids[] = $productReference[$item];
                }
            }

            $relatedModel->updateRelated($product_id, $related_ids);
        }
    }

    protected function updateTableDeclension($data)
    {
        $return = [];

        foreach ($this->keyTableDeclension as $key) {
            if (!empty($data[$key])) {
                $return[$key] = $data[$key];
            }
        }

        if (!empty($return)) {
            return json_encode($return);
        }

        return false;
    }

    protected function uploadFile($imagePath, $filename, $model, $type = 'main')
    {
        $ext = 'jpg';
        $filename .= '.'. $ext;

        // check exists
        $realPath = Storage::disk()->getDriver()->getAdapter()->getPathPrefix();
        $savePath = $realPath . 'public/product/';
        
        if (!file_exists($imagePath . $filename)) {
            return false;
        }

        $upload = new Upload();
        $file = new File($imagePath . $filename);

        $upload->visibility = Upload::VISIBILITY_PUBLIC;
        $upload->type       = ($type == 'main') ? Upload::TYPE_MAIN_VISUAL : Upload::TYPE_SECOND_VISUAL;
        $upload->filename   = strip_tags(html_entity_decode($filename));
        $upload->extension  = $ext;
        $upload->size       = $file->getSize();
        $upload->mime_type  = $file->getMimeType();
        $upload->path       = $savePath . $filename;
        $upload->updator_id = 1;
        $upload->creator_id = 1;

        switch ($type)
        {
            case 'main':
                $model->visual()->save($upload);
                break;

            case 'second':
                $model->visuals()->save($upload);
                break;
        }

        if (!file_exists($savePath . $filename)) {
            if ($file->move($savePath, $filename)) {
                echo "\n Upload success file: ". $filename;
            }
        }
        else {
            echo "\n File exists: ". $filename;
        }

        return true;

    }


}