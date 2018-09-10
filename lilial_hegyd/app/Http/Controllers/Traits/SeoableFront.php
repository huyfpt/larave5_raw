<?php namespace App\Http\Controllers\Traits;


use App\Models\Content\Seos;

trait SeosableFront
{

    protected $seos;


    /**
     * @return mixed
     */
    abstract protected function defaultSeos();


    /**
     * Include and init the Breadcrumbs
     *
     * @params string $namespace
     * @return void
     */
    public function includeSeos($namespace = null)
    {
        $this->seos = $this->defaultSeos();

        \View::composer((! empty($namespace) ? $namespace . '.' : '') . 'includes.seos',
            function ()
            {
                view()->share('seos', $this->seos);
            });
    }


}