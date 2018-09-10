<?php namespace App\Repositories\Eloquent\Content;

use App\Models\Content\Setting;
use App\Models\Content\SettingCategory;
use App\Repositories\Contracts\Content\SettingCategoryRepositoryInterface;
use App\Repositories\Contracts\Content\SettingRepositoryInterface;
use App\Repositories\Eloquent\Repository;

class SettingCategoryRepository extends Repository implements SettingCategoryRepositoryInterface
{

    public function model()
    {
        return SettingCategory::class;
    }

}