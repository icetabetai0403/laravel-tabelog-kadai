<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Store::query();
        $keyword = $request->keyword;
        $categoryId = $request->category;
        $prefecture = $request->prefecture;

        // カテゴリーによるフィルタリング
        if ($categoryId) {
            $query->where('category_id', $categoryId);
            $category = Category::find($categoryId);
        } else {
            $category = null;
        }

        // キーワードによる検索
        if ($keyword) {
            $query->where('name', 'like', "%{$keyword}%");
        }

        // 都道府県によるフィルタリング
        if ($prefecture) {
            $query->where('prefecture', $prefecture);
        }

        // 価格による並び替え
        if ($request->price_sort) {
            $query->orderBy('price', $request->price_sort === 'high_to_low' ? 'desc' : 'asc');
        }

        // 評価による並び替え
        if ($request->rating_sort) {
            $query->withAvg('reviews', 'score')
                ->orderBy('reviews_avg_score', $request->rating_sort === 'high_to_low' ? 'desc' : 'asc');
        }

        // デフォルトの並び順
        if (!$request->price_sort && !$request->rating_sort) {
            $query->latest();
        }

        $stores = $query->paginate(16)->appends($request->query());
        $total_count = $stores->total();
        $categories = Category::all();

        return view('stores.index', compact('stores', 'category', 'categories', 'total_count', 'keyword', 'prefecture'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        $reviews = $store->reviews()->get();

        return view('stores.show', compact('store', 'reviews'));
    }
}
