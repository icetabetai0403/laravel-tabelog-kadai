@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8"> <!-- col-md-6 から col-md-8 に変更 -->
            <div class="card mt-3">
                <div class="card-header">
                    <h2 class="mb-0">新規予約</h2>
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

                    <form action="{{ route('reservations.store', ['store_id' => $store->id]) }}" method="POST">
                        @csrf

                        <div class="form-group row mb-4 justify-content-center"> <!-- justify-content-center を追加 -->
                            <label for="reservation_date" class="col-sm-3 col-form-label text-right"><strong>予約日:</strong></label>
                            <div class="col-sm-4"> <!-- col-sm-8 から col-sm-4 に変更 -->
                                <select name="reservation_date" id="reservation_date" class="form-control">
                                @foreach ($dates as $date)
                                    <option value="{{ $date }}">{{ $date }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-4 justify-content-center"> <!-- justify-content-center を追加 -->
                            <label for="reservation_time" class="col-sm-3 col-form-label text-right"><strong>予約時間:</strong></label>
                            <div class="col-sm-4"> <!-- col-sm-8 から col-sm-4 に変更 -->
                                <select name="reservation_time" id="reservation_time" class="form-control">
                                @foreach ($times as $time)
                                    <option value="{{ $time }}">{{ $time }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-4 justify-content-center"> <!-- justify-content-center を追加 -->
                            <label for="reservation_people_number" class="col-sm-3 col-form-label text-right"><strong>予約人数:</strong></label>
                            <div class="col-sm-4"> <!-- col-sm-8 から col-sm-4 に変更 -->
                                <select name="reservation_people_number" id="reservation_people_number" class="form-control">
                                @foreach ($peopleNumbers as $number)
                                    <option value="{{ $number }}">{{ $number }}名</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="store_id" value="{{ $store->id }}">
                        <div class="text-center mt-5">
                            <button type="submit" class="btn nagoyameshi-submit-button me-3">予約</button>
                            <a href="{{ route('reservations.index') }}" class="btn nagoyameshi-btn-danger">戻る</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection