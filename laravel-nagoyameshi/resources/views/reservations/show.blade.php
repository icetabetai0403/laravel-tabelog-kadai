@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <span>
                <a class="text-decoration-none" style="color: #C44646;" href="{{ route('mypage') }}">マイページ</a> > <a class="text-decoration-none" style="color: #C44646;" href="{{ route('reservations.index') }}">予約一覧</a> > 予約詳細
            </span>
            <div class="card mt-3">
                <div class="card-header">
                    <h2 class="mb-0">予約詳細</h2>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        @if ($store->image !== "")
                            <img src="{{ asset($store->image) }}" alt="{{ $store->name }}" class="img-fluid mb-3" style="max-height: 200px;">
                        @else
                            <img src="{{ asset('img/dummy.png') }}" alt="dummy image" class="img-fluid mb-3" style="max-height: 200px;">
                        @endif
                        <h3>{{ $store->name }}</h3>
                    </div>

                    <div class="form-group row mb-4 justify-content-center">
                        <label class="col-sm-3 col-form-label text-right"><strong>予約日:</strong></label>
                        <div class="col-sm-4">
                            <p class="form-control-plaintext">{{ $reservation->reservation_date }}</p>
                        </div>
                    </div>
                    <div class="form-group row mb-4 justify-content-center">
                        <label class="col-sm-3 col-form-label text-right"><strong>予約時間:</strong></label>
                        <div class="col-sm-4">
                            <p class="form-control-plaintext">{{ $reservation->formatted_reservation_time }}</p>
                        </div>
                    </div>
                    <div class="form-group row mb-4 justify-content-center">
                        <label class="col-sm-3 col-form-label text-right"><strong>予約人数:</strong></label>
                        <div class="col-sm-4">
                            <p class="form-control-plaintext">{{ $reservation->reservation_people_number }}名</p>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('reservations.index') }}" class="btn nagoyameshi-btn-danger">戻る</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection