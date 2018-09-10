<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hegyd\Plans\Models\Plans;
use App\Models\Common\Client;
use App\Models\Common\User;
use Hegyd\Pages\Models\Pages;
use \Hegyd\eCommerce\Models\ProductCatalog\Product;
use Hegyd\Faqs\Repositories\Contracts\FaqsCategoryRepositoryInterface;
use Hegyd\Plans\Repositories\Contracts\PlansRepositoryInterface;

class HomeController extends Controller
{
    protected $category_repo;
    protected $plans_repo;

    public function __construct(
        Request $request,
        FaqsCategoryRepositoryInterface $category_repo,
        PlansRepositoryInterface $plans_repo
    )
    {
        $this->category_repo = $category_repo;
        $this->plans_repo    = $plans_repo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->has('category')) {
            // TODO: get search result of category
        } else {
            $faqCategories = $this->category_repo->active();
            $plans         = $this->plans_repo->getRecentPlans();
        }

        return view('front.home.home', compact('faqCategories', 'plans'));
    }

    public function about($slug)
    {
        $slugAbout = Pages::where('slug', $slug)->first();
        if ($slugAbout) {
            $arrs = ['history', 'our-team','lilial-is-committed','coloplast'];
            foreach ($arrs as $key=> $arr) {
                $about[$key] = Pages::select('title','content')->where('slug', $arr)->first();
            }
            $product = Product::select('id')->get()->count();
            $client = Client::select('id')->get()->count();
            $userSup = User::select('id')->get()->count();
    
            return view('front.about.about', 
            compact('about', 'product', 'client','userSup', 'slugAbout'));

        } else {
            abort(404);
        }
    }

    public function contact()
    {
        return view('front.contact.contact');
    }

    public function product()
    {
        return view('front.product.product');
    }

    public function productShow()
    {
        return view('front.product.product-show');
    }

    public function productDetail()
    {
        return view('front.product-detail.product-detail');
    }

    public function profile()
    {
        return view('front.profile.profile');
    }
}
