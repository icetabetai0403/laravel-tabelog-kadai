@extends('layouts.app')

@section('content')

@section('scripts')
<script>
    document.getElementById('price-sort').addEventListener('change', function() {
        document.getElementById('sort-form').submit();
    });
    document.getElementById('rating-sort').addEventListener('change', function() {
        document.getElementById('sort-form').submit();
    });
</script>
@endsection

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 sidebar-wrapper d-none d-md-block">
            <div class="sidebar-container" id="sidebar">
                @component('components.sidebar', ['categories' => $categories])
                @endcomponent
            </div>
        </div>
        <div class="col-md-9 col-lg-10 main-content" id="main-content">
            <div class="container">
                @if ($category !== null)
                    <a class="text-decoration-none" style="color: #C44646;" href="{{ route('top') }}">トップ</a> > {{ $category->name }}
                    <h1 class="mt-3">{{ $category->name }}の店舗一覧 {{$total_count}}件</h1>
                @elseif ($keyword !== null)
                    <a class="text-decoration-none" style="color: #C44646;" href="{{ route('top') }}">トップ</a> > 店舗一覧
                    <h1 class="mt-3">"{{ $keyword }}"の検索結果 {{ $total_count }}件</h1>
                @elseif ($prefecture !== null)
                    <a class="text-decoration-none" style="color: #C44646;" href="{{ route('top') }}">トップ</a> > {{ $prefecture }}
                    <h1 class="mt-3">{{ $prefecture }}の店舗一覧 {{ $total_count }}件</h1>
                @else
                    <a class="text-decoration-none" style="color: #C44646;" href="{{ route('top') }}">トップ</a> > 店舗一覧
                    <h1 class="mt-3">店舗一覧</h1>
                @endif
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <form action="{{ route('stores.index') }}" method="GET" id="sort-form">
                        @if($category)
                            <input type="hidden" name="category" value="{{ $category->id }}">
                        @endif
                        @if($keyword)
                            <input type="hidden" name="keyword" value="{{ $keyword }}">
                        @endif
                        @if($prefecture)
                            <input type="hidden" name="prefecture" value="{{ $prefecture }}">
                        @endif
                        
                        <div class="d-flex store-sort">
                            <div class="me-3">                            
                                <label for="price-sort">価格:</label>
                                <select name="price_sort" id="price-sort" class="form-control d-inline-block w-auto">
                                    <option value="">選択してください</option>
                                    <option value="high_to_low" {{ request('price_sort') == 'high_to_low' ? 'selected' : '' }}>高い順</option>
                                    <option value="low_to_high" {{ request('price_sort') == 'low_to_high' ? 'selected' : '' }}>安い順</option>
                                </select>
                            </div>

                            <div>
                                <label for="rating-sort" class="ml-3">評価:</label>
                                <select name="rating_sort" id="rating-sort" class="form-control d-inline-block w-auto">
                                    <option value="">選択してください</option>
                                    <option value="high_to_low" {{ request('rating_sort') == 'high_to_low' ? 'selected' : '' }}>高い順</option>
                                    <option value="low_to_high" {{ request('rating_sort') == 'low_to_high' ? 'selected' : '' }}>低い順</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="container mt-4">
                <div class="row">
                    @foreach($stores as $store)
                    <div class="col-md-3 mb-4">
                        <a href="{{route('stores.show', $store)}}" class="store-link">
                            @if ($store->image !== "")
                                <img src="{{ asset($store->image) }}" class="img-thumbnail store-image" alt="{{ $store->name }}">
                            @else
                                <img src="{{ asset('img/dummy.png')}}" class="img-thumbnail store-image" alt="{{ $store->name }}">
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
            <div class="d-flex justify-content-center mt-4">
                {{ $stores->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

