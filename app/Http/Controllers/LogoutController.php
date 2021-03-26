<?php

namespace App\Http\Controllers;

use App\Models\ServiceStation;
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

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $items = ServiceStation::wherenotnull('description')->orderBy('created_at','desc')->take(4)->get();

        return view('welcome', compact('items'));
    }
}
