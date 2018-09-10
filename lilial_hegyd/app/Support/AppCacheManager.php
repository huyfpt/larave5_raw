<?php


namespace App\Support;


use App\Services\Content\SettingService;
use Illuminate\Support\Facades\Cache;

class AppCacheManager
{

    const EXTRANET_COLOR_MAIN = 'extranet.color.main';
    const EXTRANET_COLOR_BODY_BACKGROUND = 'extranet.color.body.background';
    const EXTRANET_COLOR_HEADER_BACKGROUND = 'extranet.color.header.background';
    const EXTRANET_COLOR_HEADER_LINKS = 'extranet.color.header.links';
    const EXTRANET_COLOR_SIDEBAR_BACKGROUND = 'extranet.color.sidebar.background';
    const EXTRANET_COLOR_SIDEBAR_LINKS = 'extranet.color.sidebar.links';

    const EXTRANET_VISUAL_LOGO = 'extranet.visual.logo';
    const EXTRANET_VISUAL_LOGO_LARGE = 'extranet.visual.logo_large';
    const EXTRANET_VISUAL_AUTH_BACKGROUND = 'extranet.visual.auth_background';
    const EXTRANET_VISUAL_FAVICON = 'extranet.visual.favicon';

    protected $settings_text = [
        self::EXTRANET_COLOR_MAIN               => 'color.main',
        self::EXTRANET_COLOR_BODY_BACKGROUND    => 'color.body.background',
        self::EXTRANET_COLOR_HEADER_BACKGROUND  => 'color.header.background',
        self::EXTRANET_COLOR_HEADER_LINKS       => 'color.header.links',
        self::EXTRANET_COLOR_SIDEBAR_BACKGROUND => 'color.sidebar.background',
        self::EXTRANET_COLOR_SIDEBAR_LINKS      => 'color.sidebar.links',
    ];

    protected $settings_visual = [
        self::EXTRANET_VISUAL_LOGO            => 'visual.logo',
        self::EXTRANET_VISUAL_LOGO_LARGE      => 'visual.logo_large',
        self::EXTRANET_VISUAL_AUTH_BACKGROUND => 'visual.auth_background',
        self::EXTRANET_VISUAL_FAVICON         => 'visual.favicon',
    ];

    protected $subdomain;

    public function __construct()
    {
        $this->setting_service = app(SettingService::class);
    }

    public function handle()
    {
        $this->settingsVars();
    }

    public function clearAll()
    {
        foreach ($this->settings_text as $cache_key => $setting_key)
        {
            Cache::forget($cache_key);
        }

        foreach ($this->settings_visual as $cache_key => $setting_key)
        {
            Cache::forget($cache_key);
        }

        Cache::flush();
    }

    public function settingsVars()
    {
        $this->_checkAndPut($this->settings_text);
        $this->_checkAndPut($this->settings_visual, true);
    }

    public function settingByKey($key, $force_reset = false)
    {
        $realKey = $this->_extractRealKey($key);

        if (array_key_exists($realKey, $this->settings_text))
        {
            $setting_key = $this->settings_text[$realKey];
            $this->_checkAndPutKey($key, $setting_key, false, $force_reset);
        } elseif (array_key_exists($realKey, $this->settings_visual))
        {
            $setting_key = $this->settings_visual[$realKey];
            $this->_checkAndPutKey($key, $setting_key, true, $force_reset);
        }
    }

    private function _checkAndPut(array $keys, $visual = false)
    {
        foreach ($keys as $cache_key => $setting_key)
        {
            $this->_checkAndPutKey($cache_key, $setting_key, $visual);
        }
    }

    private function _checkAndPutKey($cache_key, $setting_key, $visual = false, $force_reset = false)
    {
        if ($force_reset || ! Cache::has($cache_key))
        {
            if ($visual)
            {
                $value = $this->setting_service->getSettingByKey($setting_key)->media();
            } else
            {
                $value = $this->setting_service->get($setting_key);
            }

            Cache::forever($cache_key, $value);
        }
    }

    /**
     * Extract the real key (without the subdomain part)
     * @param $key
     * @return mixed
     */
    private function _extractRealKey($key)
    {
        $keys = explode("|", $key);

        if (count($keys) < 2)
            return;

        return $keys[1];
    }

}