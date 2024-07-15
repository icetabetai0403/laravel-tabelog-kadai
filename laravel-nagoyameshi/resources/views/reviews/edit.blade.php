@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <span>
                <a class="text-decoration-none" style="color: #C44646;" href="{{ route('mypage') }}">マイページ</a> > <a class="text-decoration-none" style="color: #C44646;" href="{{ route('reviews.index') }}">レビュー一覧</a> > レビュー編集
            </span>
            <h2 class="mb-4 mt-3">レビュー編集</h2>

            <hr>

            <form action="{{ route('reviews.update',$review->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <h4>評価</h4>
                    <select name="score" class="form-select review-score-color">
                        <option value="5" class="review-score-color" {{ $review->score == 5 ? 'selected' : '' }}>★★★★★</option>
                        <option value="4" class="review-score-color" {{ $review->score == 4 ? 'selected' : '' }}>★★★★</option>
                        <option value="3" class="review-score-color" {{ $review->score == 3 ? 'selected' : '' }}>★★★</option>
                        <option value="2" class="review-score-color" {{ $review->score == 2 ? 'selected' : '' }}>★★</option>
                        <option value="1" class="review-score-color" {{ $review->score == 1 ? 'selected' : '' }}>★</option>
                    </select>
                </div>

                <div class="mb-4">
                    <h4>タイトル</h4>
                    @error('title')
                        <span class="text-danger">タイトルを入力してください</span>
                    @enderror
                    <input type="text" name="title" class="form-control" value="{{ old('title', $review->title) }}">
                </div>

                <div class="mb-4">
                    <h4>レビュー内容</h4>
                    @error('content')
                        <span class="text-danger">レビュー内容を入力してください</span>
                    @enderror
                    <textarea name="content" class="form-control" rows="5">{{ old('content', $review->content) }}</textarea>
                </div>

                <hr>

                <input type="hidden" name="store_id" value="{{ $review->store_id }}">
                <button type="submit" class="btn nagoyameshi-submit-button">レビューを修正</button>
                <a href="{{ route('reviews.index') }}" class="d-inline-block btn nagoyameshi-btn-danger">戻る</a>
            </form>
        </div>
    </div>
</div>
@endsection