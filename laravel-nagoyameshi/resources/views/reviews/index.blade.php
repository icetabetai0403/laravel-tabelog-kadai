@extends('layouts.app')

@section('content')
<div class="container">
    <span>
        <a class="text-decoration-none" style="color: #C44646;" href="{{ route('mypage') }}">マイページ</a> > レビュー一覧
    </span>
    <h1 class="mt-3">レビュー一覧</h1>
    <hr>
    <div class="row">
        @foreach ($reviews as $review)
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <a href="{{ route('stores.show', $review->store->id) }}">
                            @if ($review->store->image)
                            <img src="{{ asset($review->store->image) }}" class="card-img review-image" alt="{{ $review->store->name }}">
                            @else
                            <img src="{{ asset('img/dummy.png') }}" class="card-img review-image" alt="ダミー画像">
                            @endif
                        </a>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{ $review->store->name }}</h5>
                            <h3 class="review-score-color">{{ str_repeat('★', $review->score) }}</h3>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $review->title }}</h6>
                            <p class="card-text review-content">{{ $review->content }}</p>
                            <p class="card-text"><small class="text-muted">{{ $review->created_at->format('Y/m/d') }} by {{ $review->user->name }}</small></p>
                            <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="d-inline">
                                <a href="{{ route('reviews.edit',$review->id) }}" class="btn nagoyameshi-submit-button btn-sm">編集</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn nagoyameshi-btn-danger btn-sm">削除</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <hr>
        <div class="d-flex justify-content-center">
            {{ $reviews->links() }}
        </div>
    </div>
</div>
@endsection