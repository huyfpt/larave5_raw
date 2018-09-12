<?php namespace App\Repositories\Contracts\Content;


interface SettingRepositoryInterface
{
    public function getAllByTabs();

    public function getAllSetting();
}