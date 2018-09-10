<?php 
namespace App\Http\Controllers\Extranet;


use App\Events\Logs\Generic\GenericEvent;
use App\Http\Controllers\AbstractAppController;
use App\Models\Common\User;
use App\Models\EDM\Folder;
use App\Models\Sale\Commission;
use App\Models\Sale\RentalAgreement;
use App\Models\Sale\SaleAgreement;
use App\Repositories\Contracts\Common\ShopUserRepositoryInterface;
use App\Repositories\Contracts\Common\ShopRepositoryInterface;
use App\Repositories\Contracts\Common\UserRepositoryInterface;
use App\Repositories\Contracts\Content\CommunicationPlanRepositoryInterface;
use App\Repositories\Contracts\Content\CommunicationPlanShopRepositoryInterface;
use App\Repositories\Contracts\EDM\UploadRepositoryInterface;
use App\Repositories\Contracts\Sale\CommissionRepositoryInterface;
use App\Repositories\Contracts\Sale\RentalAgreementRepositoryInterface;
use App\Repositories\Contracts\Sale\SaleAgreementRepositoryInterface;
use App\Services\Common\ExtranetService;
use App\Services\Sale\MandateService;
use Carbon\Carbon;
use Hegyd\Logs\LogsServiceProvider;
use Hegyd\News\Repositories\Contracts\NewsRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use \Hegyd\eCommerce\Models\ProductCatalog\Product;

class IndexController extends AbstractAppController
{
    /**
     * @property mixed _logClass
     */
    private $_logClass;

    /**
     * @property mixed _userClass
     */
    private $_userClass;

    /**
     * @property mixed _newsletterClass
     */
    private $_newsletterClass;

    /**
     * @property mixed _planClass
     */
    private $_planClass;

    /**
     * @property mixed _productClass
     */
    private $_productClass;

    /**
     * @property mixed _newsClass
     */
    private $_newsClass;

    /**
     * @property mixed _faqsClass
     */
    private $_faqsClass;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->_logClass           =    config('hegyd-logs.log_model');
        $this->_userClass          =    config('auth.providers.users.model');
        $this->_newsletterClass    =    config('hegyd-faqs.models.newsletters');
        $this->_planClass          =    config('hegyd-plans.models.plans');
        $this->_productClass       =    config('hegyd-ecommerce.models.product');
        $this->_newsClass          =    config('hegyd-news.models.news');
        $this->_faqsClass          =    config('hegyd-faqs.models.faqs');
    }

    /**
     * Configure Breadcrumb
     *
     * @return array
     */
    protected function configureBreadcrumb()
    {
        $config = parent::configureBreadcrumb();
        $config['namespace'] = 'app';

        return $config;
    }

    public function index()
    {
        $title = trans('app.dashboard_index');

        $extranet_service = app(ExtranetService::class);
        $current_role = $extranet_service->getRole();

        $isAdmin = in_array($current_role->name, ["admin", "super_admin"]);

        // Récupération des logs de connexions
        $connexions = array();
        $counter = [];
        if ($isAdmin) {
            // Si l’utilisateur est admin alors on requete les 5 dernières connexions
            $class = $this->_logClass;
            $logs = $class::query();

            $connexions = $logs->where('event', "=", "user.login")->orderBy('created_at', 'desc')->take(5)->get();

            // count active customer block
            $counter['cUser'] = $this->getActiveItem($this->_userClass, 'active');

            // count active subscribers to the newsletter
            $counter['cNewsletter'] = $this->getActiveItem($this->_newsletterClass, 'active');

            // count good plans active on the site
            $counter['cPlan'] = $this->getActiveItem($this->_planClass, 'active');

            // count active products on the site
            $counter['cProduct'] = $this->getActiveItem($this->_productClass, 'active');

            // count the active news on the site.
            $counter['cNews'] = $this->getActiveItem($this->_newsClass, 'active');

            // count the active FAQS
            $counter['cFaq'] = $this->getActiveItem($this->_faqsClass, 'status');
        }

        $this->breadcrumbs->addCrumb(trans('app.dashboard'), route('index'));
        $this->breadcrumbs->addCrumb($title);

        return view(
            'app.contents.extranet.index.index',
            compact(
                'title',
                'connexions',
                'isAdmin',
                'counter'
            )
        );
    }

    protected function getActiveItem($class, $param)
    {
        if ($class) {
            $model = $class::query();
        }

        if ($param) {
            return $model->where($param, '=', 1)->count();
        } else {
            return 0;
        }
    }
}