<a class="skip-link" href="#main-content" style="position:absolute;left:-999px;top:auto;">
    Salt la conținut
</a>
<header class="site-header" role="banner">
    <div class="container nav-wrap">
        <a class="brand" href="{{ route('home') }}">Electro<span>Hub</span></a>
        <nav class="site-nav" role="navigation" aria-label="Meniul principal">
            <a href="{{ route('home') }}">Acasă</a>
            @foreach($pages as $page)
                <a href="{{ route('page.show', $page->slug) }}">{{ $page->title }}</a>
            @endforeach
            <a href="{{ route('quote') }}">Cere ofertă</a>
        </nav>
    </div>
</header>
