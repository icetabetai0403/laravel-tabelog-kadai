@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-5 col-sm-8 col-10">
        <span>
            <a class="text-decoration-none" style="color: #C44646;" href="{{ route('mypage') }}">マイページ</a> > パスワード変更
        </span>
            <div class="login-container mt-4">
                <h1 class="mt-4 mb-4 text-center">パスワード変更</h1>

                <hr>

                <form method="post" action="{{route('mypage.update_password')}}">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">

                    <div class="form-group row mb-4">
                        <label for="password" class="col-md-4 col-form-label text-md-right">新しいパスワード</label>
                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">新しいパスワード<br>（確認用）</label>
                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <hr>

                    <div class="form-group d-flex justify-content-center mt-4">
                        <button type="submit" class="btn nagoyameshi-submit-button w-50">
                            更新
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
