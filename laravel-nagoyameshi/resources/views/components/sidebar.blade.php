<div class="sidebar-container">
    <div class="container sidebar-categories">
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
</div>
