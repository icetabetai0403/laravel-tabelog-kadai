<nav class="navbar navbar-expand-md navbar-light shadow-sm nagoyameshi-header-container sticky-top-mobile">
    <div class="container-fluid px-0 px-md-4">
        <a class="navbar-brand ms-2 ms-md-0" href="{{ url('/') }}">
            <img src="{{ asset('img/logo.jpg') }}" alt="Nagoyameshi Logo">
        </a>
        
        <form action="{{ route('stores.index') }}" method="GET" class="d-none d-md-flex me-auto">
            <input class="form-control me-2" type="search" name="keyword" placeholder="店舗名から探す" aria-label="Search">
            <button class="btn nagoyameshi-header-search-button" type="submit"><i class="fas fa-search nagoyameshi-header-search-icon"></i></button>
        </form>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item d-md-none">
                    <form action="{{ route('stores.index') }}" method="GET" class="d-flex mt-3">
                        <input class="form-control me-2" type="search" name="keyword" placeholder="店舗名から探す" aria-label="Search">
                        <button class="btn nagoyameshi-header-search-button" type="submit"><i class="fas fa-search nagoyameshi-header-search-icon"></i></button>
                    </form>
                </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">登録</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">ログイン</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('mypage') }}">
                            <i class="fas fa-user mr-1"></i>マイページ
                        </a>
                    </li>
                    @if (Auth::user()->paid_membership_flag == true)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('mypage.favorite') }}">
                                <i class="far fa-heart"></i>お気に入り
                            </a>
                        </li>
                    @endif
                @endguest

                <hr>
                
                <li class="nav-item d-md-none">
                    <div class="humberger-categories mt-3">
                        <h3 class="sidebar-title">カテゴリーから探す</h3>
                        <ul class="category-list">
                            @foreach ($categories as $category)
                                <li class="category-item">
                                    <a href="{{ route('stores.index', ['category' => $category->id]) }}" class="category-link">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>