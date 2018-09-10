<?php

namespace App\Http\Controllers\Traits;

use Creitive\Breadcrumbs\Breadcrumbs;

trait Breadcrumbable
{
    /**

     * Renders the complete breadcrumbs and attach it to the view
     *
     * @param String $namespace The path or the dir to the views directory
     * @return void
     */
    /*
     * Breadcrumbs facade
     */
    public $breadcrumbs;

    /*
     * namespace
     */
    public $namespace;

    /*
     * Breadcrum's title
     */
    public $title;

    /**
     * Configure Breadcrumb
     *
     * @return array
     */
    protected abstract function configureBreadcrumb();

    /**
     * Include and init the Breadcrumbs
     *
     * @params string $namespace
     * @return void
     */
    public function includeBreadcrumbs()
    {
        $config            = $this->configureBreadcrumb();
        $this->namespace   = $config['namespace'];
        $this->breadcrumbs = new Breadcrumbs();
        $this->breadcrumbs->setCssClasses($config['cssClass']);
        $this->breadcrumbs->setDivider($config['divider']);
        $this->breadcrumbs->setListElement($config['listElement']);
        \View::composer((!empty($this->namespace) ? $this->namespace . '.' : '') .'includes.breadcrumb',
            function() {
                view()->share('breadcrumb', $this->breadcrumbs->render());
            });
    }

    /**
     * Add title to Breadcrumbs.
     *
     * @params string $title
     * @return void
     */
    public function addTitle($title)
    {
        $this->title = $title;
        \View::composer($this->namespace.'.includes.breadcrumb',
            function() {
                view()->share('title', $this->title);
            });
    }
}
