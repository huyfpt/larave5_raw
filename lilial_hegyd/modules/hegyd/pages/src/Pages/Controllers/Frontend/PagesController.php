<?php

namespace Hegyd\Pages\Controllers\Frontend;

use Hegyd\Pages\Models\Pages;

class PagesController
{
    // public function index()
    // {
    //     // dd(12132);
    //     $pages = Pages::where('status', true)->orderBy('id', 'desc')->take(15)->get();

    //     return view('hegyd-pages::frontend.pages.index', compact('pages'));
    // }
    public function show($slug)
    {
        
        $pages = Pages::where('slug', $slug)->first();
        if ($pages) {
            return view('hegyd-pages::frontend.pages.index', compact('pages'));
        } else {
            abort(404);
        }
    }
}