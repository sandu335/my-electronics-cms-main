<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ElectroHub | CMS Premium</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--bg:#060816;--surface:#0e172c;--text:#f5f7ff;--muted:#94a3b8;--accent:#34d399;--accent-2:#4f7cff;--border:rgba(255,255,255,.12)}
        *{box-sizing:border-box;margin:0;padding:0} body{font-family:'Inter',sans-serif;background:linear-gradient(135deg,var(--bg),#091221 60%,#0c1327);color:var(--text);line-height:1.6}
        a{text-decoration:none;color:inherit} .container{width:min(1180px,calc(100% - 2rem));margin:0 auto} .site-header{position:sticky;top:0;z-index:20;background:rgba(6,8,22,.82);backdrop-filter:blur(16px);border-bottom:1px solid var(--border)} .nav-wrap{display:flex;justify-content:space-between;align-items:center;padding:1rem 0} .brand{font-weight:800;font-size:1.2rem;letter-spacing:.04em}.brand span{color:var(--accent)} .site-nav{display:flex;gap:1rem;flex-wrap:wrap} .site-nav a{color:var(--muted)} .site-nav a:hover{color:var(--text)} .hero{padding:3.5rem 0 2.5rem} .hero-grid{display:grid;grid-template-columns:1.1fr .9fr;gap:2rem;align-items:center} .eyebrow{text-transform:uppercase;letter-spacing:.25em;font-size:.8rem;color:var(--accent);font-weight:700;margin-bottom:.8rem} .hero h1{font-size:clamp(2rem,4vw,3rem);line-height:1.08;margin-bottom:1rem} .hero p{color:var(--muted)} .hero-actions{display:flex;flex-wrap:wrap;gap:1rem;margin-top:1.4rem} .btn{display:inline-flex;justify-content:center;align-items:center;padding:.9rem 1.2rem;border-radius:999px;font-weight:600;border:1px solid transparent} .btn-primary{background:linear-gradient(135deg,var(--accent),var(--accent-2));color:white} .btn-outline{border-color:var(--border);background:rgba(255,255,255,.04)} .card{padding:1.2rem;border:1px solid var(--border);border-radius:1.2rem;background:linear-gradient(145deg,rgba(255,255,255,.06),rgba(255,255,255,.02));box-shadow:0 14px 34px rgba(0,0,0,.2)} .card-grid{display:grid;gap:1rem} .three-up{grid-template-columns:repeat(3,minmax(0,1fr))} .section{padding:1.3rem 0 1.2rem} .section-head{margin-bottom:1rem} .muted{color:var(--muted)} .site-footer{padding:2rem 0 2.5rem;border-top:1px solid var(--border);margin-top:2rem}.footer-wrap{display:flex;justify-content:space-between;align-items:center;color:var(--muted)} .chip{display:inline-block;padding:.35rem .7rem;border-radius:999px;background:rgba(52,211,153,.12);color:var(--accent);font-size:.8rem;margin-bottom:.6rem} .product-link{display:inline-block;margin-top:.8rem;color:var(--accent);font-weight:600} @media (max-width:860px){.hero-grid,.three-up{grid-template-columns:1fr}.site-nav{width:100%;justify-content:flex-start}.footer-wrap{flex-direction:column;gap:.6rem;align-items:flex-start}} 
    </style>
</head>
<body>
<header class="site-header">
    <div class="container nav-wrap">
        <a class="brand" href="{{ route('home') }}">Electro<span>Hub</span></a>
        <nav class="site-nav">
            <a href="{{ route('home') }}">Acasă</a>
            <a href="{{ route('about') }}">Despre noi</a>
            @foreach($pages as $page)
                <a href="{{ route('page.show', $page->slug) }}">{{ $page->title }}</a>
            @endforeach
            <a href="{{ route('contact') }}">Contact</a>
        </nav>
    </div>
</header>
<style>
    .category-media{height:220px;overflow:hidden;border-radius:.8rem;margin-bottom:.6rem}
    .card .category-media img{width:100%;height:100%;object-fit:cover;object-position:center center;display:block;border-radius:.6rem}
    .category-placeholder{height:220px;display:flex;align-items:center;justify-content:center;border-radius:.8rem;background:linear-gradient(180deg,#071022,#081426);margin-bottom:.6rem;color:var(--muted)}
    @media(max-width:900px){.category-media,.category-placeholder{height:160px}}
    @media(max-width:480px){.category-media,.category-placeholder{height:120px}}
</style>
<main>
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <p class="eyebrow">CMS electronic premium</p>
                <h1>Magazin online modern, cu produse clare și administrare simplă.</h1>
                <p>Un site modern cu catalog și panou admin intuitiv.</p>
                <div class="hero-actions">
                    <a href="{{ route('products') }}" class="btn btn-primary">Vezi produse</a>
                    <a href="{{ route('quote') }}" class="btn btn-outline">Cere ofertă</a>
                </div>
            </div>
            <div class="card">
                <span class="chip">Soluție completă</span>
                <h3>Tot ce ai nevoie pentru un magazin electronic</h3>
                <p class="muted">Categorii active, produse premium și pagini de prezentare conectate direct în admin.</p>
            </div>
        </div>
    </section>

    <section class="section" id="categorii">
        <div class="container">
            <main id="main-content" role="main" aria-label="Pagina principală">
            <div class="section-head">
                <p class="eyebrow">Categorii</p>
                <h2>Exploreaza toate categoriile disponibile</h2>
            </main>
            </div>
            <div class="card-grid three-up">
                @foreach($categories as $category)
                    @php
                        // try to get a representative image from the first active product
                        $rep = $category->products()->where('is_active', true)->first();
                        $repImage = $rep && $rep->image ? (preg_match('/^https?:\/\//', $rep->image) ? $rep->image : asset($rep->image)) : null;
                    @endphp
                    <a href="{{ route('products') }}?category={{ $category->slug }}" class="card" style="display:block;overflow:hidden;position:relative;">
                        @if($repImage)
                            <div class="category-media">
                                <img src="{{ $repImage }}" alt="{{ $category->name }}" loading="lazy" decoding="async">
                            </div>
                        @else
                            <div class="category-placeholder">
                                <span style="font-weight:700">{{ Str::limit($category->name, 18) }}</span>
                            </div>
                        @endif
                        <h3 style="margin:0">{{ $category->name }}</h3>
                        <p class="muted" style="margin:.5rem 0">{{ $category->description }}</p>
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-top:.6rem">
                            <span class="muted">{{ $category->products_count }} produse</span>
                            <span class="btn btn-outline" aria-hidden="true">Vezi</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-head">
                <p class="eyebrow">Produse recomandate</p>
                <h2>Găsește rapid oferta potrivită pentru fiecare nevoie</h2>
            </div>
            <div class="card-grid three-up">
                @foreach($products as $product)
                    <article class="card">
                        <h3>{{ $product->name }}</h3>
                        <p class="muted">{{ Str::limit($product->description, 120) }}</p>
                        <p style="margin-top:.6rem;font-weight:700;color:#fff">{{ number_format($product->price, 2, ',', '.') }} Lei</p>
                        <a href="{{ route('quote') }}" class="btn btn-primary" style="margin-top:1rem">Cere ofertă</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
</main>
<footer class="site-footer">
    <div class="container footer-wrap">
        <p>� {{ date('Y') }} ElectroHub. Toate drepturile rezervate.</p>
        <a href="{{ route('contact') }}">Contact</a>
    </div>
</footer>
</body>
</html>
