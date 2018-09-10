<?php namespace App\Services\Common;


use App\Facades\AppTools;
use App\Models\Common\Shop;
use App\Services\Content\SettingService;
use Hegyd\Permissions\Models\Role;

class ExtranetService
{

    const CURRENT_ROLE_KEY      = 'user.role_id';
    const CURRENT_SHOP_KEY      = 'user.shop_id';
    const CURRENT_COMPANY_KEY   = 'company.id';

    const CURRENT_ROLE_VAR = 'current_role';
    const CURRENT_SHOP_VAR = 'current_shop';

    /**
     * Share current user's vars
     * -> Role
     * -> Shop
     */
    public function shareUserVars()
    {
        if (auth()->check())
        {
            $user = auth()->user();

            if ( ! session(ExtranetService::CURRENT_ROLE_KEY))
            {
                $role = $user->roles()->first();
                $this->setRole($role);
            }

            if ( ! session(ExtranetService::CURRENT_SHOP_KEY))
            {
                $shop = $user->shops()->first();
                $this->setShop($shop);
            }

            // Set de la company par defaut si rien de spécifié (pour l’instant on prend celle rattachée au domain)
            if ( ! session(ExtranetService::CURRENT_COMPANY_KEY))
            {
                $company = AppTools::currentCompany();
                session()->put(self::CURRENT_COMPANY_KEY, $company->id);
            }
        }
    }

    public function forgetUserVars()
    {
        session()->forget(ExtranetService::CURRENT_ROLE_KEY);
        session()->forget(ExtranetService::CURRENT_SHOP_KEY);
        session()->forget(ExtranetService::CURRENT_COMPANY_KEY);
    }

    public function renewUserVars()
    {
        $this->forgetUserVars();
        $this->shareUserVars();
    }

    /**
     * TODO: en attente de l'architecture
     * @param $shop
     */
    public function setShop($shop)
    {

        $this->_handleShop($shop);
        if ($shop)
        {
            session()->put(self::CURRENT_SHOP_KEY, $shop->id);
        }
    }

    /**
     * @return mixed
     */
    public function getShop()
    {
        $shop_id = session(self::CURRENT_SHOP_KEY);
        $shop = Shop::find($shop_id);

        $this->_handleShop($shop);

        return $shop;
    }

    /**
     * @param $role
     */
    public function setRole($role)
    {
        $this->_handleRole($role);
        session()->put(self::CURRENT_ROLE_KEY, $role->id);
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        $role_id = session(self::CURRENT_ROLE_KEY);
        $role = Role::find($role_id);
        $this->_handleRole($role);

        return $role;
    }

    /**
     * @param ShopUser $shop_user
     */
    public function setByShopUser(ShopUser $shop_user)
    {
        $this->setShop($shop_user->shop);
        $this->setRole($shop_user->role);
    }

    /**
     * @param $role
     */
    private function _handleRole($role)
    {
        if ( ! $role)
            abort(500, 'Aucun rôle associé à votre compte.');
    }

    /**
     * @param $shop
     */
    private function _handleShop($shop)
    {
        if ( ! $shop && $this->getRole()->name != 'candidate')
            abort(500, 'Aucune agence associée à votre compte.');
    }
}