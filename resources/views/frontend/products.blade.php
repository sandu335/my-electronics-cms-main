<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produse | ElectroHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{
            --bg:#060816;
            --surface:#0e172c;
            --text:#f5f7ff;
            --muted:#94a3b8;
            --accent:#34d399;
            --accent-2:#4f7cff;
            --border:rgba(255,255,255,.12);
        }

        *{box-sizing:border-box;margin:0;padding:0}

        body{
            font-family:'Inter',sans-serif;
            background:linear-gradient(135deg,var(--bg),#091221 60%,#0c1327);
            color:var(--text);
            line-height:1.6;
        }

        a{text-decoration:none;color:inherit}

        .container{width:min(1180px,calc(100% - 2rem));margin:0 auto;padding:2rem 0}

        .site-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem}
        .site-header a{color:var(--accent)}

        .section{margin-bottom:2rem}
        .section h2{font-size:clamp(2rem,3vw,2.6rem);margin-bottom:.5rem}
        .section p{color:var(--muted);max-width:680px}

        .category-card{margin-bottom:2rem}
        .category-title{display:flex;justify-content:space-between;align-items:center;gap:1rem}
        .category-title h3{margin:0;font-size:1.5rem}

        .product-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:1rem;margin-top:1rem}
        @media(max-width:980px){.product-grid{grid-template-columns:1fr 1fr}}
        @media(max-width:680px){.product-grid{grid-template-columns:1fr}}

        .product-card{
            padding:1.25rem;
            border:1px solid var(--border);
            border-radius:1.2rem;
            background:linear-gradient(145deg,rgba(255,255,255,.06),rgba(255,255,255,.02));
            box-shadow:0 20px 45px rgba(0,0,0,.18);
        }

        .product-card img{
            width:100%;
            border-radius:.9rem;
            object-fit:contain;
            height:260px;
            margin-bottom:1rem;
            background:#0f1724;
            padding:6px;
        }

        .product-card h4{margin:0 0 .6rem}
        .product-card p{color:var(--muted);margin:0 0 1rem}
        .price{font-weight:700;color:#fff}

        .btn{display:inline-flex;align-items:center;justify-content:center;padding:.85rem 1rem;border-radius:999px;font-weight:600;border:1px solid transparent;transition:transform .2s}
        .btn-primary{background:linear-gradient(135deg,var(--accent),var(--accent-2));color:#fff}
        .btn-primary:hover{transform:translateY(-1px)}

        .fallback{padding:1.4rem;border:1px solid var(--border);border-radius:1.2rem;background:rgba(255,255,255,.04);color:var(--muted)}
    </style>
</head>
<body>
    <div class="container">
    <main id="main-content" role="main" aria-label="Lista produse">
    <header class="site-header">
        <div>
            <a href="{{ route('home') }}">← Înapoi la acasă</a>
            <h1 style="font-size:clamp(2rem,4vw,3rem);margin:.8rem 0 .4rem">Produse pe categorii</h1>
            <p>Vezi catalogul complet, organizat după categorie. Fiecare produs include imagine și preț.</p>
        </div>
        <a href="{{ route('contact') }}" class="btn btn-primary">Cere ofertă</a>
    </header>

    <div style="display:flex;gap:1.5rem;align-items:flex-start">
        <aside style="width:260px;">
            <form method="GET" action="{{ route('products') }}" style="margin-bottom:1rem">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Caută produse..." style="width:100%;padding:.6rem;border-radius:.6rem;border:1px solid var(--border);background:transparent;color:var(--text)">
            </form>

            <div style="margin-bottom:1rem">
                <h3 style="margin:0 0 .6rem">Categorii</h3>
                <ul style="list-style:none;padding:0;margin:0;">
                    <li style="margin-bottom:.4rem"><a href="{{ route('products') }}" class="muted">Toate</a></li>
                    @foreach($categories as $cat)
                        <li style="margin-bottom:.4rem"><a href="{{ route('products') }}?category={{ $cat->slug }}" class="muted">{{ $cat->name }} ({{ $cat->products()->where('is_active',true)->count() }})</a></li>
                    @endforeach
                </ul>
            </div>
        </aside>

        <main style="flex:1">
            @if($products->isEmpty())
                <div class="fallback">Nu am găsit produse care să corespundă căutării sau filtrului.</div>
            @else
                <div class="product-grid">
                    @foreach($products as $product)
                        <article class="product-card">
                            @if($product->image)
                                @php
                                    $isRemote = preg_match('/^https?:\/\//', $product->image);
                                    $full = $isRemote ? $product->image : asset($product->image);
                                    $thumb = $isRemote ? null : asset(str_replace('.jpg', '_thumb.jpg', $product->image));
                                    $webp = $isRemote ? null : asset('images/products/' . $product->slug . '.webp');
                                    $webpThumb = $isRemote ? null : asset('images/products/' . $product->slug . '_thumb.webp');
                                @endphp
                                <a href="{{ route('product.show', $product->slug) }}">
                                    <picture>
                                        @if($webpThumb)
                                            <source data-srcset="{{ $webpThumb }}" type="image/webp">
                                        @endif
                                        @if($webp)
                                            <source data-srcset="{{ $webp }}" type="image/webp" media="(min-width:800px)">
                                        @endif
                                        <img src="{{ $thumb ?? $full }}" data-src="{{ $full }}" alt="{{ $product->name }}" loading="lazy" decoding="async" onerror="this.src='{{ $full }}'">
                                    </picture>
                                </a>
                            @else
                                <img src="https://via.placeholder.com/500x300?text={{ urlencode($product->name) }}" alt="{{ $product->name }}" loading="lazy">
                            @endif
                            <h4>{{ $product->name }}</h4>
                            <p>{{ Str::limit($product->description, 110) }}</p>
                            <p class="price">{{ number_format($product->price, 2, ',', '.') }} Lei</p>
                            <a href="{{ route('product.show', $product->slug) }}" class="btn btn-primary">Vezi detalii</a>
                        </article>
                    @endforeach
                </div>

                <div style="margin-top:1rem;text-align:center;color:var(--muted)">
                    {{ $products->withQueryString()->links() }}
                </div>
            @endif
        </main>
    </main>
    </div>
</div>
</body>
</html>
<script>
// Simple lazy load: replace src with data-src when in viewport
document.addEventListener('DOMContentLoaded', function(){
    if('IntersectionObserver' in window){
        let io = new IntersectionObserver((entries)=>{
            entries.forEach(e=>{if(e.isIntersecting){let img=e.target; if(img.dataset && img.dataset.src){img.src=img.dataset.src; img.removeAttribute('data-src');} io.unobserve(img)}});
        },{rootMargin:'200px'});
        document.querySelectorAll('img[data-src]').forEach(img=>io.observe(img));
    } else {
        document.querySelectorAll('img[data-src]').forEach(img=>{img.src=img.dataset.src; img.removeAttribute('data-src');});
    }
});
</script>
@include('partials.analytics')
