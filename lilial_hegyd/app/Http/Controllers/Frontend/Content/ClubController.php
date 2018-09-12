<?php

namespace App\Http\Controllers\Frontend\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hegyd\Plans\Models\Plans;
use App\Models\Common\News;
use App\Models\Common\Client;
use Carbon\Carbon;

class ClubController extends Controller
{
    public function index()
    {
        $plans = Plans::where('active', true)
                        ->where('avantage', true)
                        ->where('visibility', true)
                        /*->where('start_at', '<=', Carbon::now())
                        ->where('end_at', '>=', Carbon::now())*/
                        ->orderBy('id', 'desc')->get();
        $news = News::where('active', true)
                      /*->where('start_at', '<=', Carbon::now())
                      ->where('end_at', '>=', Carbon::now())*/
                      ->orderBy('id', 'desc')->get();
        $ambassadors = Client::where('ambassador', true)
                              ->orderBy('id', 'desc')->get();

        return view('front.club.club', compact('plans', 'news', 'ambassadors'));
    }

    public function listNews()
    {
        $news = News::where('active', true)
                      /*->where('start_at', '<=', Carbon::now())
                      ->where('end_at', '>=', Carbon::now())*/
                      ->orderBy('id', 'desc')->paginate(15);

        return view('front.club.news.index', compact('news'));
    }

    public function showNews(Request $request)
    {
        $news = News::where('slug', $request->slug)->first();

        return view('front.club.news.show', compact('news'));
    }

    public function listAmbassadors()
    {
        $ambassadors = Client::where('ambassador', true)
                              ->orderBy('id', 'desc')->paginate(15);

        return view('front.club.ambassadors.ambassadors', compact('ambassadors'));
    }
}
