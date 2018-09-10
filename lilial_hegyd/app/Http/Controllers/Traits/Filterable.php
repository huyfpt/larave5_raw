<?php namespace App\Http\Controllers\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{

    protected $paginate = 12;

    protected static $TEMPLATE_PRODUCTS = 'products';
    protected static $TEMPLATE_PROVIDERS = 'providers';
    protected static $TEMPLATE_CATEGORIES = 'categories';

    protected static $ORDER_NAME_ASC = 1;
    protected static $ORDER_NAME_DESC = 2;

    protected static $orderName = [];
    protected static $orderField = [];
    protected static $orderSort = [];

    /**
     * Return Http/Illuminate/Request
     * @return mixed
     */
    abstract function getRequest();

    public function initFiltersVars()
    {
        self::$orderName[self::$ORDER_NAME_ASC] = 'filters.fields.name_asc';
        self::$orderName[self::$ORDER_NAME_DESC] = 'filters.fields.name_desc';

        self::$orderField[self::$ORDER_NAME_ASC] = 'name';
        self::$orderField[self::$ORDER_NAME_DESC] = 'name';

        self::$orderSort[self::$ORDER_NAME_ASC] = 'ASC';
        self::$orderSort[self::$ORDER_NAME_DESC] = 'DESC';
    }

    public function generateTemplate($templates, $datas)
    {
        $this->initFiltersVars();

        $return = [];

        /*
         * Products template
         */
        if (in_array(self::$TEMPLATE_PRODUCTS, $templates) && isset($datas[self::$TEMPLATE_PRODUCTS]))
        {
            $this->getTemplateView($datas[self::$TEMPLATE_PRODUCTS], self::$TEMPLATE_PRODUCTS, 'q', 't', 'p', $return);
        }
        /*
         * Providers template
         */
        if (in_array(self::$TEMPLATE_PROVIDERS, $templates) && isset($datas[self::$TEMPLATE_PROVIDERS]))
        {
            $this->getTemplateView($datas[self::$TEMPLATE_PROVIDERS], self::$TEMPLATE_PROVIDERS, 'qf', 'tf', 'pf', $return);
        }
        /*
         * Categories template
         */
        if (in_array(self::$TEMPLATE_CATEGORIES, $templates) && isset($datas[self::$TEMPLATE_CATEGORIES]))
        {
            $this->getTemplateView($datas[self::$TEMPLATE_CATEGORIES], self::$TEMPLATE_CATEGORIES, 'qc', 'tc', 'pc', $return);
        }

        return $return;
    }

    protected function getTemplateView(Builder $datas, $type, $paginateParam, $orderByParam, $pageParam, &$return)
    {

        $paginate = $this->getRequest()->get($paginateParam, $this->paginate);
        $orderBy = $this->getRequest()->get($orderByParam, self::$ORDER_NAME_ASC);
        $page = $this->getRequest()->get($pageParam, 1);


        if (isset(self::$orderField[$orderBy]) && isset(self::$orderSort[$orderBy]))
        {
            $datas = $datas->orderBy(self::$orderField[$orderBy], self::$orderSort[$orderBy]);
        }

        $datas = $datas->paginate($paginate, ['*'], 'page', $page);

        $return['templates'][$type] = $this->getTemplate($type)
            ->with('filters', self::$orderName)
            ->with('entities', $datas)
            ->with('type', $type)
            ->with('orderBy', $orderBy)
            ->with('quantity', $paginate)
            ->render();
    }

    /**
     * @param $template
     * @return mixed
     */
    public function getTemplate($template)
    {
        return $this->getView('common.filters.' . $template);
    }
}