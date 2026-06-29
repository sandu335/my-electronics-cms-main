<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | ElectroHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--bg:#060816;--surface:#0e172c;--text:#f5f7ff;--muted:#94a3b8;--accent:#34d399;--accent-2:#4f7cff;--border:rgba(255,255,255,.12)}
        *{box-sizing:border-box;margin:0;padding:0} body{font-family:'Inter',sans-serif;background:linear-gradient(135deg,var(--bg),#091221 60%,#0c1327);color:var(--text);min-height:100vh} a{text-decoration:none;color:inherit}
        .container{width:min(1280px,calc(100% - 2rem));margin:0 auto;padding:1.5rem 0 2.5rem} .card{padding:1.1rem;border:1px solid var(--border);border-radius:1.2rem;background:linear-gradient(145deg,rgba(255,255,255,.06),rgba(255,255,255,.02));box-shadow:0 14px 34px rgba(0,0,0,.2)} .sidebar{display:grid;gap:.8rem;padding:1rem;border:1px solid var(--border);border-radius:1.2rem;background:rgba(255,255,255,.03)} .layout{display:grid;grid-template-columns:260px 1fr;gap:1rem} .btn{display:inline-flex;justify-content:center;align-items:center;padding:.8rem 1rem;border-radius:999px;font-weight:600;border:1px solid transparent} .btn-primary{background:linear-gradient(135deg,var(--accent),var(--accent-2));color:#fff} .btn-outline{border-color:var(--border);background:rgba(255,255,255,.04)} .mute{color:var(--muted)} .card-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:1rem} .eyebrow{text-transform:uppercase;letter-spacing:.24em;font-size:.8rem;color:var(--accent);font-weight:700;margin-bottom:.6rem} input,textarea,select{width:100%;padding:.8rem;border-radius:.7rem;border:1px solid var(--border);background:rgba(255,255,255,.04);color:var(--text)} label{display:block;margin-bottom:.8rem} @media (max-width:920px){.layout{grid-template-columns:1fr}.card-grid{grid-template-columns:1fr}}
    </style>
</head>
<body>
<div class="container">
    <div class="layout">
        <aside class="sidebar">
            <h2 style="font-size:1.2rem">ElectroHub Admin</h2>
            <p class="mute">Un panou avansat pentru managementul public ?i intern.</p>
            @auth
                <div style="margin-bottom:1rem;padding:.8rem;border:1px solid var(--border);border-radius:.9rem;background:rgba(255,255,255,.04);">
                    <strong>Bun venit,</strong>
                    <div>{{ Auth::user()->name }}</div>
                </div>
            @endauth
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline" style="justify-content:flex-start">Dashboard</a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline" style="justify-content:flex-start">Categorii</a>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline" style="justify-content:flex-start">Produse</a>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-outline" style="justify-content:flex-start">Pagini</a>
            @auth
                <form action="{{ route('logout') }}" method="POST" style="margin-top:1rem">
                    @csrf
                    <button type="submit" class="btn btn-outline" style="width:100%;justify-content:flex-start">Ieșire</button>
                </form>
            @endauth
            <a href="{{ route('home') }}" class="btn btn-primary" style="justify-content:flex-start">Vizualizeaza site-ul</a>
        </aside>
        <main>
            @if(session('success'))
                <div class="card" style="margin-bottom:1rem;background:rgba(52,211,153,.12)">{{ session('success') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
