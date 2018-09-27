<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    public function about()
    {
        $name = "huy";
        // return view('page.about')->with("myname", $name)->with("...", $...);
        return view('page.about', compact('name'));
    }
    public function contact()
    {
        return view('page/contact');
    }
}
