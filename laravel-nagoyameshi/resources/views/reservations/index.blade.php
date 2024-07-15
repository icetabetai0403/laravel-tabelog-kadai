@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="w-75">
        <span>
            <a class="text-decoration-none" style="color: #C44646;" href="{{ route('mypage') }}">マイページ</a> > 予約一覧
        </span>
        <h1 class="mt-3">予約一覧</h1>
        <hr>
        @foreach ($reservations as $reservation)
        @php
            $reservationTime = \Carbon\Carbon::parse($reservation->reservation_date . ' ' . $reservation->reservation_time);
            $now = \Carbon\Carbon::now();
            $isFutureReservation = $reservationTime > $now;
        @endphp
        <div class="reservation-container row mb-3 align-items-center"> <!-- reservation-container クラスを追加 -->
            <div class="col-12 col-md-2 mb-3 mb-md-0">
                <div class="reservation-store-image-wrapper">
                    <a href="{{ route('stores.show', $reservation->store->id) }}">
                        @if ($reservation->store->image)
                            <img src="{{ asset($reservation->store->image) }}" class="favorite-store-image" alt="{{ $reservation->store->name }}">
                        @else
                            <img src="{{ asset('img/dummy.png') }}" class="favorite-store-image" alt="dummy image">
                        @endif
                    </a>
                </div>
            </div>
            <div class="col-12 col-md-3 mb-3 mb-md-0">
                <a href="{{ route('stores.show', $reservation->store->id) }}" class="nagoyameshi-favorite-item-text h6 text-decoration-none font-weight-bold">{{ $reservation->store->name }}</a>
            </div>
            <div class="col-12 col-md-3 mb-3 mb-md-0">
                <p class="mb-1">{{ $reservation->reservation_date }}<br>{{ $reservation->formatted_reservation_time }}</p>
                <p class="mb-0">{{ $reservation->reservation_people_number }}名</p>
            </div>
            <div class="col-12 col-md-4 d-flex justify-content-start align-items-center">
                <a href="{{ route('reservations.show', $reservation->id) }}" class="btn nagoyameshi-submit-button btn-sm mr-1">予約詳細</a>
                @if ($isFutureReservation)
                <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn btn-change btn-sm mr-1">予約変更</a>
                <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn nagoyameshi-btn-danger btn-sm">キャンセル</button>
                </form>
                @endif
            </div>
        </div>
        @endforeach
        <hr>
        <div class="d-flex justify-content-center">
            {{ $reservations->links() }}
        </div>
    </div>
</div>
@endsection
