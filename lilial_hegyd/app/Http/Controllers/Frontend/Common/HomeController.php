<?php

namespace App\Http\Controllers\Frontend\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hegyd\Plans\Models\Plans;
use App\Models\Common\Client;
use App\Models\Common\User;
use Hegyd\Pages\Models\Pages;
use \Hegyd\eCommerce\Models\ProductCatalog\Product;
use Hegyd\Faqs\Repositories\Contracts\FaqsCategoryRepositoryInterface;
use Hegyd\Plans\Repositories\Contracts\PlansRepositoryInterface;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Contracts\Common\UserRepositoryInterface;
use App\Services\Mail\ContactService;

class HomeController extends Controller
{
    protected $category_repo;
    protected $plans_repo;

    public function __construct(
        Request $request,
        FaqsCategoryRepositoryInterface $category_repo,
        PlansRepositoryInterface $plans_repo,
        UserRepositoryInterface $user_repo
    )
    {
        $this->category_repo = $category_repo;
        $this->plans_repo    = $plans_repo;
        $this->user_repo     = $user_repo;
    }

    /**
     * Homepage
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $faqCategories = $this->category_repo->homeCategory();
        $plans         = $this->plans_repo->getRecentPlans();

        return view('front.home.home', compact('faqCategories', 'plans'));
    }

    /**
     * Page about
     * @return [type] [description]
     */
    public function about()
    {
        $arrs = ['history', 'our-team', 'lilial-is-committed', 'coloplast'];
        $data = Pages::select('title', 'content', 'slug')->whereIn('slug', $arrs)->get();

        $about = [];
        foreach ($data as $item) {
            $about[$item->slug] = $item;
        }

        $counter['product'] = Product::where('active', true)->count();
        $counter['client']  = Client::count();
        $counter['userSup'] = User::where('active', true)->count();

        return view('front.about.about', compact('about', 'counter'));
    }

    /**
     * page contact
     * @return [type] [description]
     */
    public function contact()
    {
        return view('front.contact.contact');
    }

    public function profile()
    {
        return view('front.profile.profile');
    }

    public function sendEmail(Request $request)
    {
        $messages = [
	        'required' => __('contacts.messages.required'),
	        'email'    => __('contacts.messages.email')
        ];

        $validator = Validator::make($request->all(), [
            'nom'     => 'required',
            'prenom'  => 'required',
            'email'   => 'required|email',
            'comment' => 'required',
            'g-recaptcha-response' => 'required|captcha'
	    ], $messages);

        if ($validator->fails()) { 
            return redirect('/contact')
	                ->withErrors($validator)
	                ->withInput();
        } 
        else {

            $result = app(ContactService::class)->sendContact($request->all());

            if ($result) {
                //Session::flash('message_success', __('contacts.messages.thanks'));

                return view('front.contact.thanks');
            }
        }

        Session::flash('message_error', __('contacts.messages.error'));
        return redirect('/contact');
    }
}
