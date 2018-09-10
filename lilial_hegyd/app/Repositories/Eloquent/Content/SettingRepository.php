<?php namespace App\Repositories\Eloquent\Content;

use App\Facades\AppTools;
use App\Models\Common\Company;
use App\Models\Content\Setting;
use App\Repositories\Contracts\Content\SettingRepositoryInterface;
use App\Repositories\Eloquent\Repository;
use App\Services\Common\ExtranetService;

class SettingRepository extends Repository implements SettingRepositoryInterface
{

    public function model()
    {
        return Setting::class;
    }

    /**
     * Retrieve all settings grouped by tabs
     */
    public function getAllByTabs()
    {
        // Get des settings pour la Company actuel
        $company_settings = Company::find(session(ExtranetService::CURRENT_COMPANY_KEY))->settings;

        // Get des settings global (en ignorant les celles déjà défini)
        $settings = Setting::orderBy('category_id')->orderBy('position')->whereNotIn("key", $company_settings->pluck("key"))->get();

        // Settings organisé par catégorie
        $categories_settings = [];

        // Merge des deux collections
        $all_settings = $settings->merge($company_settings);

        // Reorder par position
        $all_settings = $all_settings->sortBy("position");

        // Regroupement par type
        foreach ($all_settings as $setting)
        {
            $categories_settings[$setting->category_id][] = $setting;
        }

        return $categories_settings;
    }
}