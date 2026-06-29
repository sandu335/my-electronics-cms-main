<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $product->name }} | ElectroHub</title>
    <meta name="description" content="{{ Str::limit(strip_tags($product->description), 160) }}">
    <meta property="og:title" content="{{ $product->name }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($product->description), 160) }}">
    @if($product->image)
        <meta property="og:image" content="{{ asset($product->image) }}">
    @endif
    <style>
        body{font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto;margin:0;background:#060816;color:#fff}
        .container{width:min(980px,calc(100% - 2rem));margin:2rem auto}
        .gallery{display:grid;grid-template-columns:1fr 360px;gap:1rem}
        .gallery img{width:100%;border-radius:.8rem}
        .meta h1{margin:0 0 .5rem}
        .price{font-weight:800;font-size:1.3rem;margin-top:.6rem}
        .btn{display:inline-block;margin-top:1rem;padding:.7rem 1rem;background:#34d399;color:#042; border-radius:.6rem;text-decoration:none}
        @media(max-width:900px){.gallery{grid-template-columns:1fr}}
    </style>
</head>
<body>
<div class="container">
    <a href="{{ route('products') }}">← Înapoi la produse</a>
    <main id="main-content" role="main" aria-label="Detaliu produs">
    <div class="gallery">
        <div>
            @if($product->image)
                @php
                    $webp = asset('images/products/' . $product->slug . '.webp');
                    $webpExists = file_exists(public_path('images/products/' . $product->slug . '.webp'));
                @endphp
                <picture>
                    @if($webpExists)
                        <source srcset="{{ $webp }}" type="image/webp">
                    @endif
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" loading="lazy">
                </picture>
            @endif
        </div>
        <aside class="meta">
            <h1>{{ $product->name }}</h1>
            <p class="price">{{ number_format($product->price, 2, ',', '.') }} Lei</p>
            <p>{{ $product->description }}</p>
            <a class="btn" href="{{ route('contact') }}">Cere ofertă</a>
        </aside>
    </div>
    </main>
</div>
</body>
</html>
@include('partials.analytics')
