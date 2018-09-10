<?php

namespace App\Http\Controllers\Traits;

use Config;
use Hegyd\Uploads\Models\Upload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Validator;
use Symfony\Component\HttpFoundation\File\File;

/**
 * A trait to automatically handle uploaded files
 */
trait Uploadable
{

    protected abstract function configureUploads();

    protected abstract function getRepository();

//    protected $errors = [];

    protected $filesToDelete = [];

    /**
     *
     * @var array content of config/uploads.php::types
     */
    protected $uploadConfigurations;

    /**
     * the path of the folder containing generated thumbnails
     * @var string
     */
    private static $THUMBNAILS_PATH = 'thumbnail';

    /**
     * save files
     * @param array $datas
     * @param Model $model
     * @return array $datas transformed
     */
    protected function saveFiles(array $datas, Model $model = null)
    {
        $fileToUploads = $this->configureUploads();

        if (empty($fileToUploads) || empty($datas) || $model == null)
        {
            return $datas;
        }

        $this->getFilesUploadsConfiguration();

        /**
         * TODO: refactor
         */
        foreach ($fileToUploads as $key => $config)
        {
            if ( ! isset($datas[$key]) && ! isset($datas[$key . '-removed']))
            {
                continue;
            }

            if (isset($datas[$key]) && is_array($datas[$key]))
            {
                foreach ($datas[$key] as $fileKey => $file)
                {
                    if ( ! $file) continue;

                    $upload = new Upload();
                    $upload->creator()->associate(Auth::user());
                    $upload->position = $fileKey;
                    $datas[$key][$fileKey] = $this->convertFileToUpload($file, $upload, $model, $key, $this->getRepository()->storagePath(), $config);
                }
            } else
            {
                if ($model != null && count($model->{$key}))
                {
                    $this->addFilesToDelete($model, $key, $config);
                }

                if (isset($datas[$key]) && $datas[$key])
                {
                    $upload = $model->{$key} ?: new Upload();
                    $file = $datas[$key];

                    if ( ! $upload->exists)
                    {
                        $upload->creator()->associate(Auth::user());
                    }
// dd($this->getRepository());
                    $datas[$key] = $this->convertFileToUpload($file, $upload, $model, $key, $this->getRepository()->storagePath(), $config);
                    // dump($datas[$key]);die();
                } else if (isset($datas[$key . '-removed']) && $model->{$key})
                {
                    $relation = $this->getRelationFromConfig($config);

                    if ($relation == Upload::RELATION_UNIQUE)
                    {
                        $upload = $model->{$key};
                        $upload->delete();
                        $this->addFileToDelete($upload);

                        $upload->delete();
                    }
                }
            }
        }

        $this->runDeleteFiles();

        return $model;
    }

    /**
     * Save thumbnail
     * @param string $storage_path
     * @param string $filename
     * @param array $size
     */
    protected function saveThumbnail($storage_path, $filename, $size)
    {
        $manager = new ImageManager(['driver' => 'gd']);
        $thumbs_folder = $storage_path . 'thumbnail';
        if ( ! file_exists($thumbs_folder))
        {
            mkdir($thumbs_folder);
        }
        $manager->make($storage_path . $filename)->resize($size['height'], $size['width'],
            function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumbs_folder . DIRECTORY_SEPARATOR . $filename);
    }


    /**
     * Handle uploaded file
     * @param File $file
     * @param string $storage_path
     * @param string|array $config file upload configuration
     * @return string
     */
    protected function convertFileToUpload(File $file, Upload $upload, Model $model, $field, $storage_path, $config)
    {
        $extension = $file->getClientOriginalExtension();
        $configuration = $this->uploadConfigurations[is_array($config) ? $config['type'] : $config];
        if ( ! in_array('*', $configuration['exts']) && ! in_array(strtolower($extension), $configuration['exts']))
        {
            return null;
        }
        do
        {
            $filename = uniqid() . '.' . $extension;
        } while (file_exists($storage_path . $filename));


//        if ( ! empty($configuration['resizeSize']) && ! empty($config['resize']) && $config['resize'] === true)
//        {
//            $this->saveThumbnail($storage_path, $filename, $configuration['resizeSize']);
//        }

        $upload->visibility = isset($config['visibility']) ? $config['visibility'] : Upload::VISIBILITY_PUBLIC;
        $upload->type = isset($config['upload_type']) ? $config['upload_type'] : Upload::TYPE_OTHER;
        $upload->filename = strip_tags(html_entity_decode($file->getClientOriginalName()));
        $upload->extension = $extension;
        $upload->size = $file->getSize();
        $upload->mime_type = $file->getMimeType();
        $upload->path = $storage_path . $filename;
        $upload->updator()->associate(\Auth::user());

        if (isset($config['edm']))
        {
            $edmConfig = $config['edm'];
            $edmRelation = $edmConfig['relation'];
            $edmType = $edmConfig['type'];

            $folder = $model->{$edmRelation}()->where('type', $edmType)->first();

            if ($folder)
            {
                $upload->folder_id = $folder->id;
            }
        }

        switch ($this->getRelationFromConfig($config))
        {
            case Upload::RELATION_UNIQUE:
                $model->{$field}()->save($upload);
                break;

            case Upload::RELATION_MULTIPLE:
                $model->{$field}()->save($upload);
                break;
        }

        $file->move($storage_path, $filename);

        return $upload;
    }

    /**
     * Files validation
     * @param Validator $validator
     * @param array $datas
     * @return Validator
     */
    public function validateFiles(Validator $validator, array $datas)
    {
        $options = $this->configureUploads();

        $this->getFilesUploadsConfiguration();
        foreach ($options as $fieldName => $fieldConfig)
        {
            if ( ! empty($datas[$fieldName]) && ! is_array($datas[$fieldName]))
            {
                $validator = $this->validateFile($validator, $datas[$fieldName],
                    $this->uploadConfigurations[$fieldConfig['type']], $fieldName);
            } elseif ( ! empty($datas[$fieldName]) && is_array($datas[$fieldName]))
            {
                foreach ($datas[$fieldName] as $file)
                {
                    if ($file)
                    {
                        $validator = $this->validateFile($validator, $file,
                            $this->uploadConfigurations[$fieldConfig['type']], $fieldName);
                    }
                }
            }

        }

        return $validator;
    }

    /**
     * File validation
     * @param Validator $validator
     * @param File $file
     * @param array $typeConfig contains the configuration of the file type
     * @param string $field
     * @return Validator
     */
    protected function validateFile(Validator $validator, File $file, array $typeConfig, $field)
    {
        $validator->after(function ($validator) use ($file, $typeConfig, $field) {
            //validate file extensions
            if ( ! in_array('*', $typeConfig['exts']) && ! in_array(strtolower($file->getClientOriginalExtension()), $typeConfig['exts']))
            {
                $validator->errors()->add($field,
                    trans('validation.file_extension_error', ['exts' => implode(', ', $typeConfig['exts'])]));
            }
            //validate file size
            if ( ! $file->getSize() || $file->getSize() > $typeConfig['maxSizeInBytes'])
            {
                $validator->errors()->add($field,
                    trans('validation.file_maxsize_exceeded', ['max' => $typeConfig['maxSize']]));
            }
        });

        return $validator;
    }

    /**
     * get the uploads.types configuration from config/uploads.php::types
     *  - fills the maxSizeInBytes attributes from the maxSize defined in configuration
     * @return array
     */
    protected function getFilesUploadsConfiguration()
    {
        if ($this->uploadConfigurations == null)
        {
            $this->uploadConfigurations = config('hegyd-uploads.types');
            foreach ($this->uploadConfigurations as $typeName => $typeConfig)
            {
                if (isset($typeConfig['maxSize']))
                {
                    $this->uploadConfigurations[$typeName]['maxSizeInBytes'] = $this->calculateSizeInBytes($typeConfig['maxSize']);
                }
            }
        }

        return $this->uploadConfigurations;
    }

    /**
     * Calculate a size in bytes from an human readable date (containings O, K, M, G)
     * @param string $humanReadableSize
     * @return integer
     */
    protected function calculateSizeInBytes($humanReadableSize)
    {
        return str_replace(['G', 'M', 'K', 'O'], ['000000000', '000000', '000', ''], $humanReadableSize);
    }

    /**
     * @param Model $model
     * @param $field
     * @param $relation
     */
    protected function removeUploads(Model $model, $field, $relation)
    {

    }

    /**
     * @param Model $model
     * @param $field
     * @param $config
     */
    public function addFilesToDelete(Model $model, $field, $config)
    {
        if (count($model->{$field}) == 0) return;

        $relation = $this->getRelationFromConfig($config);
        if ($relation == Upload::RELATION_UNIQUE)
        {
            $upload = $model->{$field};
            $this->addFileToDelete($upload);

        } else if ($relation == Upload::RELATION_MULTIPLE)
        {
            foreach ($model->{$field} as $upload)
            {
                $this->addFileToDelete($upload);
            }

        }
    }

    /**
     * @param $upload
     */
    protected function addFileToDelete($upload)
    {
        if ($upload && $upload instanceof Upload)
        {
            $this->filesToDelete[] = $upload->path;
        }
    }

    /**
     * @param array $config
     * @return string
     */
    protected function getRelationFromConfig(array $config)
    {
        $relation = Upload::RELATION_UNIQUE;
        if (isset($config['relation']) && $config['relation'])
        {
            $relation = $config['relation'];
        }

        return $relation;
    }

    /**
     * @param $filepath
     */
    protected function removeFile($filepath)
    {
        if (Storage::exists($filepath))
        {
            Storage::delete($filepath);
        }
    }

    public function runDeleteFiles()
    {
        foreach ($this->filesToDelete as $path)
        {
            if (file_exists($path))
            {
                unlink($path);
            }
        }
    }
}
