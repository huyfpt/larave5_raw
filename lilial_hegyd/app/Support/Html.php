<?php namespace App\Support;

use Collective\Html\HtmlBuilder;

/**
 * Class Html overwritten
 * @package App\Support
 */
class Html extends HtmlBuilder
{

    public function script($url, $attributes = [], $secure = null)
    {
        $attributes['src'] = $this->url->asset($url, $secure) . $this->getAssetsRev() ;

        return '<script'.$this->attributes($attributes).'></script>'.PHP_EOL;
    }

    public function style($url, $attributes = [], $secure = null)
    {
        $defaults = ['media' => 'all', 'type' => 'text/css', 'rel' => 'stylesheet'];

        $attributes = $attributes + $defaults;

        $attributes['href'] = $this->url->asset($url, $secure) . $this->getAssetsRev() ;

        return '<link'.$this->attributes($attributes).'>'.PHP_EOL;
    }

    protected function getAssetsRev()
    {
        return '?rev'.\Config::get('app.assets_rev');
    }

}