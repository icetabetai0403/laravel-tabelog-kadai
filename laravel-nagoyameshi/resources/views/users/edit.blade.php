@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <span>
                <a class="text-decoration-none" style="color: #C44646;" href="{{ route('mypage') }}">マイページ</a> > 会員情報の編集
            </span>

            <h1 class="mt-4 mb-4">会員情報の編集</h1>

            <hr>

            <form method="POST" action="{{ route('mypage') }}">
                @csrf
                <input type="hidden" name="_method" value="PUT">

                <div class="form-group row">
                    <label for="name" class="col-md-5 col-form-label text-md-left">氏名</label>

                    <div class="col-md-7">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror nagoyameshi-login-input" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus placeholder="侍 太郎">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>氏名を入力してください</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-5 col-form-label text-md-left">メールアドレス</label>

                    <div class="col-md-7">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror nagoyameshi-login-input" name="email" value="{{ $user->email }}" required autocomplete="email" placeholder="samurai@samurai.com">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>メールアドレスを入力してください</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="postal_code" class="col-md-5 col-form-label text-md-left">郵便番号</label>

                    <div class="col-md-7">
                        <input id="postal_code" type="text" class="form-control @error('postal_code') is-invalid @enderror nagoyameshi-login-input" name="postal_code" value="{{ $user->postal_code }}" required autocomplete="postal_code" placeholder="XXX-XXXX">
                        @error('postal_code')
                        <span class="invalid-feedback" role="alert">
                            <strong>郵便番号を入力してください</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="address" class="col-md-5 col-form-label text-md-left">住所</label>

                    <div class="col-md-7">
                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror nagoyameshi-login-input" name="address" value="{{ $user->address }}" required autocomplete="address" placeholder="東京都渋谷区道玄坂X-X-X">
                        @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>住所を入力してください</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="phone" class="col-md-5 col-form-label text-md-left">電話番号</label>

                    <div class="col-md-7">
                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror nagoyameshi-login-input" name="phone" value="{{ $user->phone }}" required autocomplete="phone" placeholder="XXX-XXXX-XXXX">
                        @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>電話番号を入力してください</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <hr>

                <div class="form-group mt-4">
                    <button type="submit" class="btn nagoyameshi-submit-button w-100">
                        保存
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
