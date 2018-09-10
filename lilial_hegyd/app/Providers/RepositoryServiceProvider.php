<?php namespace App\Providers;

use App\Repositories\Contracts\ACL\RoleRepositoryInterface;
use App\Repositories\Contracts\Common\AddressRepositoryInterface;
use App\Repositories\Contracts\Common\CityRepositoryInterface;
use App\Repositories\Contracts\Common\CompanyRepositoryInterface;
use App\Repositories\Contracts\Common\CountryRepositoryInterface;
use App\Repositories\Contracts\Common\ShopRepositoryInterface;
use App\Repositories\Contracts\Common\UserRepositoryInterface;
use App\Repositories\Contracts\Common\ClientRepositoryInterface;
use App\Repositories\Contracts\Content\SettingCategoryRepositoryInterface;
use App\Repositories\Contracts\Content\SettingRepositoryInterface;
use App\Repositories\Contracts\EAV\AttributeRepositoryInterface;
use App\Repositories\Contracts\EAV\AttributeValueRepositoryInterface;
use App\Repositories\Eloquent\ACL\RoleRepository;
use App\Repositories\Eloquent\Common\AddressRepository;
use App\Repositories\Eloquent\Common\CityRepository;
use App\Repositories\Eloquent\Common\CompanyRepository;
use App\Repositories\Eloquent\Common\CountryRepository;
use App\Repositories\Eloquent\Common\ShopRepository;
use App\Repositories\Eloquent\Common\UserRepository;
use App\Repositories\Eloquent\Common\ClientRepository;
use App\Repositories\Eloquent\Content\SettingCategoryRepository;
use App\Repositories\Eloquent\Content\SettingRepository;
use App\Repositories\Eloquent\EAV\AttributeRepository;
use App\Repositories\Eloquent\EAV\AttributeValueRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    public function register()
    {

        // ACL
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);

        // COMMON
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
        $this->app->bind(ShopRepositoryInterface::class, ShopRepository::class);
        $this->app->bind(CountryRepositoryInterface::class, CountryRepository::class);
        $this->app->bind(CityRepositoryInterface::class, CityRepository::class);
        $this->app->bind(AddressRepositoryInterface::class, AddressRepository::class);
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);

        // CONTENT
        $this->app->bind(SettingCategoryRepositoryInterface::class, SettingCategoryRepository::class);
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);

        // EAV
        $this->app->bind(AttributeRepositoryInterface::class, AttributeRepository::class);
        $this->app->bind(AttributeValueRepositoryInterface::class, AttributeValueRepository::class);
    }
}