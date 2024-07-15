<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        
        $reviews = Review::where('user_id', $user_id)->orderBy('created_at', 'desc')->paginate(20);

        return view('reviews.index', compact('reviews'));
    }
        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:20',
            'content' => 'required'
        ]);

        $review = new Review();
        $review->title = $request->input('title');
        $review->content = $request->input('content');
        $review->score = $request->input('score');
        $review->store_id = $request->input('store_id');
        $review->user_id = Auth::user()->id;
        $review->save();

        return back();
    }

    public function edit(Review $review)
    {
        return view('reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        $request->validate([
            'title' => 'required|max:20',
            'content' => 'required'
        ]);

        $review->title = $request->input('title');
        $review->content = $request->input('content');
        $review->score = $request->input('score');
        $review->store_id = $request->input('store_id');
        $review->user_id = Auth::user()->id;
        $review->update();

        return to_route('reviews.index');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return to_route('reviews.index');
    } 
}
