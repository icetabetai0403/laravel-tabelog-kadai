<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Store;

class WebController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        $recently_stores = Store::orderBy('created_at', 'desc')->take(4)->get();

        $recommend_stores = Store::where('recommend_flag', true)->take(6)->get();

        return view('web.index', compact('categories', 'recently_stores', 'recommend_stores'));
    }
}
