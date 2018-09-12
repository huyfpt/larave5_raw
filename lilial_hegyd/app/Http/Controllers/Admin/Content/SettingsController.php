<?php namespace App\Http\Controllers\Admin\Content;

use App\Events\Logs\Generic\GenericEvent;
use App\Facades\AppCacheManager;
use App\Facades\AppTools;
use App\Http\Controllers\AbstractAppController;
use App\Http\Controllers\Traits\Apiable;
#use App\Http\Controllers\Traits\Uploadable;
use App\Models\Common\Company;
#use App\Models\EDM\Upload;
use App\Repositories\Contracts\Content\SettingCategoryRepositoryInterface;
use App\Repositories\Contracts\Content\SettingRepositoryInterface;
use Hegyd\Logs\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\Content\Setting;
use Illuminate\Support\Facades\Cache;

use Hegyd\Uploads\Controllers\Traits\Uploadable;
use Hegyd\Uploads\Models\Upload;

class SettingsController extends AbstractAppController
{

    protected $settingCategoryRepository;

    use Apiable, Uploadable;

    public function __construct(Request $request, SettingRepositoryInterface $repository, SettingCategoryRepositoryInterface $settingCategoryRepository)
    {
        parent::__construct($request);
        $this->repository = $repository;
        $this->settingCategoryRepository = $settingCategoryRepository;

    }

    public function configureUploads()
    {
        return [
            'file' => [
                'type'        => 'image',
                'relation'    => Upload::RELATION_UNIQUE,
                'visibility'  => Upload::VISIBILITY_PUBLIC,
                'upload_type' => Upload::TYPE_MAIN_VISUAL,
            ],
        ];
    }

    public function index()
    {
        if ( ! \Entrust::can('admin.settings.index'))
        {
            abort(401);
        }

        $categories = $this->settingCategoryRepository->all();
        $settings = $this->repository->getAllByTabs();

        $title = trans('settings.title.management');

        $this->breadcrumbs->addCrumb(trans('app.dashboard'), route('index'));
        $breadcrumb = $this->breadcrumbs->addCrumb($title);

        return view(
            'app.contents.admin.settings.index',
            compact('categories', 'settings', 'breadcrumb', 'title')
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        if ( ! \Entrust::can('admin.settings.edit'))
        {
            abort(401);
        }

        $form_settings = $this->getRequest()->get('settings');
        $updated_settings = [];

        // On parcours chaque settings
        foreach ($form_settings as $id => $value)
        {
            // Récupération en base des settings
            $db_setting = $this->repository->find($id);

            if ($db_setting && $db_setting->value != $value){

                // Si les settings ne sont pas associé spécifiquement à la Company en cours
                if($db_setting->is_reference == 1){

                    // On duplique les settings
                    // $new_setting = $db_setting->replicate();
                    $new_setting = $db_setting;

                    // On set les values
                    $new_setting->is_reference = false;
                    $new_setting->value = $value;

                    // Save avec le rattachement vers les settings
                    AppTools::currentCompany()->settings()->save($new_setting);

                    $updated_settings[] = $new_setting->name;
                }else{
                    // Update et save de la modification
                    $db_setting->value = $value;
                    $db_setting->save();

                    $updated_settings[] = $db_setting->name;
                }

            }
        }

        $this->_manageFiles($updated_settings);

        if (count($updated_settings) > 0)
        {
            $message = trans('settings.message.values_saved') . implode(', ', $updated_settings);

            event(new GenericEvent("settings.update", 'L\'utilisateur ' . auth()->user()->fullname() . ' a modifié les paramètres ' . implode(', ', $updated_settings) . '.'));

            AppCacheManager::clearAll();
            Cache::forget('settings');

        } else
        {
            $message = trans('settings.message.nothing_to_save');
        }

        return redirect()->route('admin.settings.index')->with('message', $message);
    }

    /**
     * Hook pour gérer les uploads dans les settings
     * @param $updated_settings
     */
    private function _manageFiles(&$updated_settings)
    {
        $datas = $this->getRequest()->all();
        $files = [];

        foreach ($datas as $key => $data)
        {
            if ($preg = preg_match("/^file_([0-9]*)(.*)$/", $key, $match))
            {
                if (count($match) >= 3)
                {
                    $files[$match[1]]['file' . $match[2]] = $data;
                }
            }
        }

        foreach ($files as $id => $file)
        {
            $setting = $this->repository->find($id);
            if ($setting)
            {
                $updated_settings[] = $setting->name;
                $this->saveFiles($file, $setting);
            }
        }
    }
}