<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function store($store_id)
    {
        Auth::user()->favorite_stores()->attach($store_id);

        return back();
    }

    public function destroy($store_id)
    {
        Auth::user()->favorite_stores()->detach($store_id);

        return back();
    }
}
