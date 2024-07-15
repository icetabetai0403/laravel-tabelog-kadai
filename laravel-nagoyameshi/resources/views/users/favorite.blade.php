@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center mt-3">
    <div class="w-50">
        <h1>お気に入り</h1>

        <hr>

        @foreach ($favorite_stores as $favorite_store)
        <div class="favorite-container mb-3">
            <div class="row align-items-center">
                <div class="col-12 col-md-3 mb-3 mb-md-0">
                    <div class="favorite-store-image-wrapper">
                        <a href="{{ route('stores.show', $favorite_store->id) }}">
                            @if ($favorite_store->image !== "")
                                <img src="{{ asset($favorite_store->image) }}" class="favorite-store-image" alt="{{ $favorite_store->name }}">
                            @else
                                <img src="{{ asset('img/dummy.png') }}" class="favorite-store-image" alt="dummy image">
                            @endif
                        </a>
                    </div>
                </div>
                <div class="col-12 col-md-9">
                    <div class="d-flex flex-column flex-md-row justify-content-between">
                        <div>
                            <a href="{{ route('stores.show', $favorite_store->id) }}" class="nagoyameshi-favorite-item-text h6 text-decoration-none">{{ $favorite_store->name }}</a>
                            @if ($favorite_store->reviews()->exists())
                                <div class="favorite-store-rating">
                                    <span class="nagoyameshi-star-rating" data-rate="{{ round($favorite_store->reviews->avg('score') * 2) / 2 }}"></span>
                                    <span class="ml-2 small">{{ round($favorite_store->reviews->avg('score'), 1) }}</span>
                                </div>
                            @endif
                            <p class="nagoyameshi-favorite-item-text small mb-0">{{ $favorite_store->price }}</p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <a href="{{ route('reservations.create', $favorite_store->id) }}" class="btn nagoyameshi-favorite-button btn-sm mr-1">予約</a>
                        <a href="{{ route('favorites.destroy', $favorite_store->id) }}" class="btn nagoyameshi-btn-danger btn-sm" onclick="event.preventDefault(); document.getElementById('favorites-destroy-form{{$favorite_store->id}}').submit();">
                            削除
                        </a>
                        <form id="favorites-destroy-form{{$favorite_store->id}}" action="{{ route('favorites.destroy', $favorite_store->id) }}" method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <hr>
        <div class="d-flex justify-content-center">
            {{ $favorite_stores->links() }}
        </div>
    </div>
</div>
@endsection
