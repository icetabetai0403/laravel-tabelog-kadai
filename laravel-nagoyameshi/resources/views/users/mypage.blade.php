@extends('layouts.app')

@section('content')
<div class="container-fluid d-flex justify-content-center mt-3">
    <div class="col-12 col-md-8 col-lg-6">

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <h1>マイページ</h1>

        <hr>

        <div class="container user-info">
            <h2>{{ $user->name }}様</h2>
            <p>会員タイプ：
                @if(Auth::user()->paid_membership_flag == true)
                <span>有料会員</span>
                @else
                <span>無料会員</span>
                @endif
            </p>
        </div>

        <hr>

        <!-- 全員に表示するメニュー -->
        <div class="container menu-item">
            <a href="{{ route('mypage.edit') }}" class="menu-link">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon-wrapper">
                            <i class="fas fa-user fa-3x"></i>
                        </div>
                        <div class="menu-content ms-3">
                            <label for="user-name">会員情報の編集</label>
                            <p>アカウント情報の編集</p>
                        </div>
                    </div>
                    <div class="arrow-wrapper">
                        <i class="fa fa-angle-double-right fa-2x"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="container menu-item">
            <a href="{{ route('mypage.edit_password') }}" class="menu-link">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon-wrapper">
                            <i class="fas fa-lock fa-3x"></i>
                        </div>
                        <div class="menu-content ms-3">
                            <label for="user-name">パスワード変更</label>
                            <p>パスワードを変更します</p>
                        </div>
                    </div>
                    <div class="arrow-wrapper">
                        <i class="fa fa-angle-double-right fa-2x"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- 無料会員のみ表示するメニュー -->
        @if(Auth::user()->paid_membership_flag == false)
        <div class="container menu-item">
            <form action="{{ route('checkout.session') }}" method="GET" id="stripe-form">
            @csrf
                <a href="{{ route('checkout.session') }}" class="menu-link" onclick="event.preventDefault(); document.getElementById('stripe-form').submit();">           
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper">
                                <i class="fas fa-archive fa-3x"></i>
                            </div>
                            <div class="menu-content ms-3">
                                <label for="user-name">有料会員登録</label>
                                <p>有料会員の登録ができます</p>
                            </div>
                        </div>
                        <div class="arrow-wrapper">
                            <i class="fa fa-angle-double-right fa-2x"></i>
                        </div>
                    </div>
                </a>
            </form>
        </div>
        @endif

        <!-- 有料会員のみ表示するメニュー -->
        @if(Auth::user()->paid_membership_flag == true)
        <div class="container menu-item">
            <form action="{{ route('change.card') }}" method="GET" id="stripe-change-form">
            @csrf
                <a href="{{ route('change.card') }}" class="menu-link" onclick="event.preventDefault(); document.getElementById('stripe-change-form').submit();">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper">
                                <i class="fa fa-credit-card fa-3x"></i>
                            </div>
                            <div class="menu-content ms-3">
                                <label for="user-name">クレジットカード変更</label>
                                <p>クレジットカードの変更ができます</p>
                            </div>
                        </div>
                        <div class="arrow-wrapper">
                            <i class="fa fa-angle-double-right fa-2x"></i>
                        </div>
                    </div>
                </a>
            </form>
        </div>

        <div class="container menu-item">
            <a href="{{ route('reservations.index') }}" class="menu-link">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon-wrapper">
                            <i class="fas fa-store fa-3x"></i>
                        </div>
                        <div class="menu-content ms-3">
                            <label for="user-name">予約一覧</label>
                            <p>予約一覧を確認できます</p>
                        </div>
                    </div>
                    <div class="arrow-wrapper">
                        <i class="fa fa-angle-double-right fa-2x"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="container menu-item">
            <a href="{{ route('reviews.index') }}" class="menu-link">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon-wrapper">
                            <i class="fas fa-commenting fa-3x"></i>
                        </div>
                        <div class="menu-content ms-3">
                            <label for="user-name">レビュー一覧</label>
                            <p>投稿したレビュー一覧を確認できます</p>
                        </div>
                    </div>
                    <div class="arrow-wrapper">
                        <i class="fa fa-angle-double-right fa-2x"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="container menu-item">
            <a href="{{ route('cancel.subscription') }}" class="menu-link">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon-wrapper">
                            <i class="fas fa-times-circle fa-3x"></i>
                        </div>
                        <div class="menu-content ms-3">
                            <label for="user-name">有料会員解約</label>
                            <p>有料会員の解約ができます</p>
                        </div>
                    </div>
                    <div class="arrow-wrapper">
                        <i class="fa fa-angle-double-right fa-2x"></i>
                    </div>
                </div>
            </a>
        </div>
        @endif

        <!-- 全員に表示するログアウトメニュー -->
        <div class="container menu-item">
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
                <a href="{{ route('logout') }}" class="menu-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper">
                                <i class="fas fa-sign-out-alt fa-3x"></i>
                            </div>
                            <div class="menu-content ms-3">
                                <label for="user-name">ログアウト</label>
                                <p>ログアウトします</p>
                            </div>
                        </div>
                        <div class="arrow-wrapper">
                            <i class="fa fa-angle-double-right fa-2x"></i>
                        </div>
                    </div>
                </a>
            </form>
        </div>

        <!-- 無料会員のみ表示する退会メニュー -->

        <hr>

        @if(Auth::user()->paid_membership_flag == false)
        <div class="d-flex justify-content-center">
            <div class="btn nagoyameshi-btn-danger" data-bs-toggle="modal" data-bs-target="#delete-user-confirm-modal">
                退会する
            </div>
        </div>

        <div class="modal fade" id="delete-user-confirm-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><label>本当に退会しますか？</label></h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="閉じる">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-center">一度退会するとデータはすべて削除され復旧はできません。</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn nagoyameshi-btn-danger" data-bs-dismiss="modal">キャンセル</button>
                        <form method="POST" action="{{ route('mypage.destroy') }}">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn nagoyameshi-submit-button">退会する</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
