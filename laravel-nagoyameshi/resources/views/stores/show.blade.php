@extends('layouts.app')

@section('content')
<div class="container">
    <!-- 店舗名と平均評価 -->
    <div class="row mb-4">
        <div class="col-12">
            <a class="text-decoration-none" style="color: #C44646;" href="{{ route('top') }}">トップ</a> > <a class="text-decoration-none" style="color: #C44646;" href="{{ route('stores.index', ['category' => $store->category->id]) }}">{{ $store->category->name}}</a> > {{$store->name}}
            <h1 class="mt-3">{{$store->name}}</h1>
            @if ($store->reviews()->exists())
                <div class="store-rating">
                    <span class="nagoyameshi-star-rating" data-rate="{{ round($store->reviews->avg('score') * 2) / 2 }}"></span>
                    <span class="ml-2">{{ round($store->reviews->avg('score'), 1) }}</span>
                </div>
            @endif
        </div>
    </div>

    <!-- 店舗情報 -->
    <div class="row mb-5">
        <div class="col-md-5">
            <div class="store-image mb-3">
                @if ($store->image)
                    <img src="{{ asset($store->image) }}" class="img-fluid rounded">
                @else
                    <img src="{{ asset('img/dummy.png')}}" class="img-fluid rounded">
                @endif
            </div>
        </div>
        <div class="col-md-7">
            <div class="store-description mb-4">
                <h3 class="mb-2">店舗説明</h3>
                <p>{{$store->description}}</p>
            </div>

            <div class="store-details mb-4">
                <h3 class="mb-2">店舗詳細</h3>
                <table class="table table-bordered">
                    <tr>
                        <th>価格</th>
                        <td>{{$store->price}}(税込)</td>
                    </tr>
                    <tr>
                        <th>営業時間</th>
                        <td>{{ $store->business_hours }}</td>
                    </tr>
                    <tr>
                        <th>定休日</th>
                        <td>{{ $store->regular_holiday }}</td>
                    </tr>
                    <tr>
                        <th>住所</th>
                        <td>〒{{$store->postal_code}}　{{ $store->address }}</td>
                    </tr>
                    <tr>
                        <th>電話番号</th>
                        <td>{{ $store->phone }}</td>
                    </tr>
                </table>
            </div>

            @auth
                @if (Auth::user()->paid_membership_flag == true)
                    <div class="store-actions">
                        <div class="row">
                            <div class="col-6">
                                @if(Auth::user()->favorite_stores()->where('store_id', $store->id)->exists())
                                    <form id="favorites-destroy-form" action="{{ route('favorites.destroy', $store->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn nagoyameshi-favorite-button text-favorite w-100">
                                            <i class="fa fa-heart"></i> お気に入り解除
                                        </button>
                                    </form>
                                @else
                                    <form id="favorites-store-form" action="{{ route('favorites.store', $store->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn nagoyameshi-favorite-button text-favorite w-100">
                                            <i class="fa fa-heart"></i> お気に入り
                                        </button>
                                    </form>
                                @endif
                            </div>
                            <div class="col-6">
                                <a href="{{ route('reservations.create', ['store_id' => $store->id]) }}" class="btn nagoyameshi-favorite-reservation text-reservation w-100">
                                    <i class="fas fa-store"></i> 予約
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @endauth
        </div>
    </div>

    <hr class="mb-5">

    <!-- レビュー -->
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">カスタマーレビュー</h2>
        </div>
        
        <!-- レビュー一覧 -->
        <div class="col-md-7">
            <div class="reviews">
                @foreach($reviews as $review)
                    <div class="card mb-4">
                        <div class="card-body">
                            <h4 class="review-score-color mb-2">{{ str_repeat('★', $review->score) }}</h4>
                            <h5 class="card-title">{{ $review->title }}</h5>
                            <p class="card-text">{{$review->content}}</p>
                            <small class="text-muted">{{$review->created_at->format('Y-m-d')}} {{$review->user->name}}</small>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- レビュー投稿フォーム -->
        <div class="col-md-5">
            @auth
                @if (Auth::user()->paid_membership_flag == true)
                    <div class="review-form mb-4">
                        <h4 class="mb-3">レビューを投稿</h4>
                        <form method="POST" action="{{ route('reviews.store') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="score" class="mb-2">評価</label>
                                <select name="score" id="score" class="form-control review-score-color">
                                    <option value="5">★★★★★</option>
                                    <option value="4">★★★★</option>
                                    <option value="3">★★★</option>
                                    <option value="2">★★</option>
                                    <option value="1">★</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="title" class="mb-2">タイトル</label>
                                @error('title')
                                    <span class="text-danger">タイトルを入力してください</span>
                                @enderror
                                <input type="text" name="title" id="title" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="content" class="mb-2">レビュー内容</label>
                                @error('content')
                                    <span class="text-danger">レビュー内容を入力してください</span>
                                @enderror
                                <textarea name="content" id="content" class="form-control" rows="4"></textarea>
                            </div>
                            <input type="hidden" name="store_id" value="{{$store->id}}">
                            <button type="submit" class="btn nagoyameshi-submit-button">レビューを追加</button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</div>
@endsection