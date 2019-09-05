<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
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
        /**
         *
         *ниже верификация с электронной почтой
         *
         */

        //$this->middleware(['auth'=>'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
\flash('info','go home');
        return view('home');
    }
}
