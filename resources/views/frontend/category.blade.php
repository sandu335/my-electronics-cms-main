<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $category->name }} | ElectroHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--bg:#060816;--surface:#0e172c;--text:#f5f7ff;--muted:#94a3b8;--accent:#34d399;--accent-2:#4f7cff;--border:rgba(255,255,255,.12)}*{box-sizing:border-box;margin:0;padding:0}body{font-family:'Inter',sans-serif;background:linear-gradient(135deg,var(--bg),#091221 60%,#0c1327);color:var(--text);line-height:1.6}a{text-decoration:none;color:inherit}.container{width:min(1120px,calc(100% - 2rem));margin:0 auto;padding:2rem 0}.card{padding:1.2rem;border:1px solid var(--border);border-radius:1.2rem;background:linear-gradient(145deg,rgba(255,255,255,.06),rgba(255,255,255,.02));box-shadow:0 14px 34px rgba(0,0,0,.2)}.grid{display:grid;gap:1rem;grid-template-columns:repeat(3,minmax(0,1fr))}.muted{color:var(--muted)}.accent{color:var(--accent)}.btn{display:inline-flex;justify-content:center;align-items:center;padding:.8rem 1rem;border-radius:999px;font-weight:600;border:1px solid transparent;margin-top:.8rem}.btn-primary{background:linear-gradient(135deg,var(--accent),var(--accent-2));color:#fff}.btn-outline{border-color:var(--border);background:rgba(255,255,255,.04)}@media (max-width:860px){.grid{grid-template-columns:1fr}}
    </style>
</head>
<body>
<div class="container">
    <a href="{{ route('home') }}" class="accent">? Înapoi acasa</a>
    <h1 style="font-size:clamp(1.8rem,4vw,2.6rem);margin:.7rem 0 .6rem">{{ $category->name }}</h1>
    <p class="muted">{{ $category->description }}</p>
    <div class="grid" style="margin-top:1.5rem">
        @foreach($products as $product)
            <article class="card">
                <h3>{{ $product->name }}</h3>
                <p class="muted" style="margin:.4rem 0 .6rem">{{ $product->description }}</p>
                <p style="font-weight:700">{{ number_format($product->price, 2, ',', '.') }} Lei</p>
                <a href="{{ route('contact') }}" class="btn btn-primary">Cere oferta</a>
            </article>
        @endforeach
    </div>
</div>
</body>
</html>
