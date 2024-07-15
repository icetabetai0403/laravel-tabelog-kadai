@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 sidebar-wrapper">
            <div class="sidebar-container" id="sidebar">
                @component('components.sidebar', ['categories' => $categories])
                @endcomponent
            </div>
        </div>
        <div class="col-md-9 col-lg-10 main-content" id="main-content">
            <h1>おすすめ店舗</h1>
            <!-- PC用のカルーセル、lgサイズ以上で表示 -->
            <div id="recommendedStoresCarousel" class="carousel slide d-none d-lg-block" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($recommend_stores->chunk(3) as $index => $chunk)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <div class="d-flex justify-content-center">
                                @foreach ($chunk as $store)
                                    <div class="col-md-4 px-2">
                                        <a href="{{ route('stores.show', $store) }}" class="store-link">
                                            @if ($store->image !== "")
                                            <img src="{{ asset($store->image) }}" class="img-fluid recommend-store-image" alt="{{ $store->name }}">
                                            @else
                                            <img src="{{ asset('img/dummy.png')}}" class="img-fluid recommend-store-image" alt="{{ $store->name }}">
                                            @endif
                                            <div class="mt-2">
                                                <p class="nagoyameshi-store-label-link">
                                                    {{ $store->name }}<br>
                                                </p>
                                            </div>
                                        </a>
                                        <div>
                                            <p class="nagoyameshi-store-label">
                                                @if ($store->reviews()->exists())
                                                    <span class="nagoyameshi-star-rating" data-rate="{{ round($store->reviews->avg('score') * 2) / 2 }}"></span>
                                                    <span>{{ round($store->reviews->avg('score'), 1) }}</span><br>
                                                @endif
                                                <label>￥{{ $store->price }}</label>
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#recommendedStoresCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#recommendedStoresCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

            <!-- スマホ用のカルーセル、lg以下で表示 -->
            <div id="recommendedStoresCarouselMobile" class="carousel slide d-lg-none" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($recommend_stores as $index => $store)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <div class="d-flex justify-content-center">
                                <div class="col-12">
                                    <a href="{{ route('stores.show', $store) }}" class="store-link">
                                        @if ($store->image !== "")
                                        <img src="{{ asset($store->image) }}" class="img-fluid recommend-store-image" alt="{{ $store->name }}">
                                        @else
                                        <img src="{{ asset('img/dummy.png')}}" class="img-fluid recommend-store-image" alt="{{ $store->name }}">
                                        @endif
                                        <div class="mt-2">
                                            <p class="nagoyameshi-store-label-link">
                                                {{ $store->name }}<br>
                                            </p>
                                        </div>
                                    </a>
                                    <div>
                                        <p class="nagoyameshi-store-label">
                                            @if ($store->reviews()->exists())
                                                <span class="nagoyameshi-star-rating" data-rate="{{ round($store->reviews->avg('score') * 2) / 2 }}"></span>
                                                <span>{{ round($store->reviews->avg('score'), 1) }}</span><br>
                                            @endif
                                            <label>￥{{ $store->price }}</label>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#recommendedStoresCarouselMobile" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#recommendedStoresCarouselMobile" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

            <div class="carousel-custom-indicators mt-3 text-center">
                <!-- PC用インジケーター -->
                <div class="d-none d-lg-block">
                    @foreach ($recommend_stores->chunk(3) as $index => $chunk)
                        <span class="dot {{ $index === 0 ? 'active' : '' }}" data-bs-target="#recommendedStoresCarousel" data-bs-slide-to="{{ $index }}"></span>
                    @endforeach
                </div>
                <!-- モバイル用インジケーター -->
                <div class="d-lg-none">
                    @foreach ($recommend_stores as $index => $store)
                        <span class="dot {{ $index === 0 ? 'active' : '' }}" data-bs-target="#recommendedStoresCarouselMobile" data-bs-slide-to="{{ $index }}"></span>
                    @endforeach
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>新着店舗</h1>
                <a href="{{ route('stores.index', ['sort' => 'id', 'direction' => 'desc']) }}" class="btn btn-link text-decoration-none" style="color: black;">もっと見る</a>
            </div>
            <div class="row">
                @foreach ($recently_stores as $recently_store)
                <div class="col-md-3 mb-4">
                    <a href="{{ route('stores.show', $recently_store) }}" class="store-link">
                        @if ($recently_store->image !== "")
                        <img src="{{ asset($recently_store->image) }}" class="img-thumbnail new-store-image" alt="{{ $recently_store->name }}">
                        @else
                        <img src="{{ asset('img/dummy.png') }}" class="img-thumbnail new-store-image" alt="{{ $recently_store->name }}">
                        @endif
                        <div class="mt-2">
                            <p class="nagoyameshi-store-label-link">
                                {{ $recently_store->name }}<br>
                            </p>
                        </div>
                    </a>
                    <div>
                        <p class="nagoyameshi-store-label">
                            @if ($recently_store->reviews()->exists())
                                <span class="nagoyameshi-star-rating" data-rate="{{ round($recently_store->reviews->avg('score') * 2) / 2 }}"></span>
                                <span>{{ round($recently_store->reviews->avg('score'), 1) }}</span><br>
                            @endif
                            <label>￥{{ $recently_store->price }}</label>
                        </p>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-between align-items-center mt-5 mb-3">
                <h1>人気エリアから探す</h1>
            </div>
            <div class="container-fluid area-cards-container">
                <!-- ここにエリア名と対象店舗数のカードを記載 -->
                <div class="row">
                    @php
                        $areas = [
                            '東京' => '東京.jpg',
                            '神奈川' => '神奈川.jpg',
                            '愛知' => '愛知.jpg',
                            '大阪' => '大阪.jpg',
                            '京都' => '京都.jpg',
                            '福岡' => '福岡.jpg'
                        ];
                    @endphp
                    @foreach ($areas as $area => $image)
                        <div class="col-md-4 mb-4">
                            <a href="{{ route('stores.index', ['prefecture' => $area]) }}" class="text-decoration-none">
                                <div class="card area-card">
                                    <div class="row g-0 h-100">
                                        <div class="col-4">
                                            <div class="area-image-wrapper">
                                                <img src="{{ asset('img/' . $image) }}" class="img-fluid area-image" alt="{{ $area }}">
                                            </div>
                                        </div>
                                        <div class="col-8 d-flex align-items-center">
                                            <div class="card-body">
                                                <h5 class="card-title mb-0">{{ $area }}</h5>
                                                <p class="card-text mb-0">
                                                    {{ App\Models\Store::where('prefecture', $area)->count() }}件
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>

@endsection