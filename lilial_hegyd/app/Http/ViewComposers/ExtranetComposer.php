<?php namespace App\Http\ViewComposers;


use App\Facades\AppTools;
use App\Services\Common\ExtranetService;
use App\Services\Content\SettingService;
use App\Support\AppCacheManager;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class ExtranetComposer
{


    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $this->subdomain = AppTools::extractSubDomain();
        //$this->shareUserVars($view);
        $this->shareColorsVars($view);
        $this->shareVisualsVars($view);
    }

    /**
     * Share current user's vars
     * -> Role
     * -> Shop
     */
    public function shareUserVars(View $view)
    {
        if (auth()->check())
        {
            $extranet_service = app(ExtranetService::class);

            $role = $extranet_service->getRole();
            $shop = $extranet_service->getShop();

            $view->with(ExtranetService::CURRENT_ROLE_VAR, $role);
            $view->with(ExtranetService::CURRENT_SHOP_VAR, $shop);
        }
    }

    /**
     * Retrieve database colors or use defaults
     */
    public function shareColorsVars(View $view)
    {
        // Retrieve colors
        $view->with('colorMain', $this->_getCacheEntry(AppCacheManager::EXTRANET_COLOR_MAIN));
        $view->with('colorBodyBackground', $this->_getCacheEntry(AppCacheManager::EXTRANET_COLOR_BODY_BACKGROUND));
        $view->with('colorHeaderBackground', $this->_getCacheEntry(AppCacheManager::EXTRANET_COLOR_HEADER_BACKGROUND));
        $view->with('colorHeaderLinks', $this->_getCacheEntry(AppCacheManager::EXTRANET_COLOR_HEADER_LINKS));
        $view->with('colorSidebarBackground', $this->_getCacheEntry(AppCacheManager::EXTRANET_COLOR_SIDEBAR_BACKGROUND));
        $view->with('colorSidebarLinks', $this->_getCacheEntry(AppCacheManager::EXTRANET_COLOR_SIDEBAR_LINKS));
    }

    /**
     * Retrieve database visuals or use defaults
     */
    public function shareVisualsVars(View $view)
    {
        // Forward to layouts
        $view->with('visualLogo', $this->_getCacheEntry(AppCacheManager::EXTRANET_VISUAL_LOGO));
        $view->with('visualLogoLarge', $this->_getCacheEntry(AppCacheManager::EXTRANET_VISUAL_LOGO_LARGE));
        $view->with('visualLoginBackground', $this->_getCacheEntry(AppCacheManager::EXTRANET_VISUAL_AUTH_BACKGROUND));
        $view->with('visualFavicon', $this->_getCacheEntry(AppCacheManager::EXTRANET_VISUAL_FAVICON));

    }

    private function _getCacheEntry($key){
        return cache($this->subdomain."|".$key);
    }
}