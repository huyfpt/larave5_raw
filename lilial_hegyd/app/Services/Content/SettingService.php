<?php

namespace App\Services\Content;

use App\Facades\AppTools;
use App\Models\Content\Setting;
use App\Models\Content\SettingCategory;
use Illuminate\Support\Collection;
use App\Repositories\Contracts\Content\SettingRepositoryInterface;

class SettingService
{

    protected $repository;

    public function __construct(SettingRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getSettingByKey($key)
    {
        $allSettings = $this->repository->getAllSetting();

        if (isset($allSettings[$key])) {
            return $allSettings[$key];
        }
        else {
            return false;
        }

        $current_company = AppTools::currentCompany();
        if ($current_company)
        {
            $setting = $current_company->settings->where('key', $key)->first();
        }

        if($setting){
            return $setting;
        }else{
            return Setting::where('key', $key)->first();
        }
    }

    /**
     * Simplified getter
     * @param $key
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $setting = $this->getSettingByKey($key);
        if ($setting)
        {
            if ($setting->value)
            {
                return $setting->value;
            } else if ($setting->default)
            {
                return $setting->default;
            }
        }

        return $default;
    }

    public function getSettingSocialNetwork()
    {
        $social_networks = new Collection();
        $category = SettingCategory::where('key', 'social_network')->first();

        if ($category)
        {
            $social_networks = $category->settings()->where('value', '!=', '')->get();
        }

        return $social_networks;
    }

    /**
     * Retourne un tableau trié du plus petit au plus grand palier
     * Une entrée de ce tableau contient :
     *  - une clé percent = Pourcentage du palier
     *  - une clé ca = CA max du palier
     * @return array
     */
    public function getCASteps()
    {
        $percents = [65, 70, 75, 80, 85, 90, 95];
        $steps = [];
        foreach ($percents as $percent)
        {
            $setting = $this->get("commission.$percent");
            if ($setting)
            {
                $steps[$setting] = [
                    'percent' => $percent,
                    'ca'      => $setting,
                ];
            }
        }

        ksort($steps);

        return $steps;
    }
}