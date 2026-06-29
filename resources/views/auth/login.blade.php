<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autentificare | ElectroHub</title>
    <style>
        body{margin:0;font-family:system-ui, sans-serif;background:#0d1223;color:#f8fafc;display:flex;align-items:center;justify-content:center;min-height:100vh}
        .card{width:min(420px,calc(100% - 2rem));padding:2rem;border-radius:1rem;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);box-shadow:0 24px 80px rgba(0,0,0,.35)}
        h1{margin:0 0 1rem;font-size:1.6rem;color:#fff}
        p{color:#cbd5e1;margin:.2rem 0 1.5rem}
        label{display:block;margin-top:1rem;font-size:.95rem;color:#e2e8f0}
        input{width:100%;padding:.9rem 1rem;margin-top:.4rem;border:1px solid rgba(255,255,255,.14);border-radius:.8rem;background:rgba(255,255,255,.05);color:#f8fafc}
        button{width:100%;margin-top:1.5rem;padding:.95rem 1rem;border:none;border-radius:.9rem;font-weight:700;color:#0f172a;background:#34d399;cursor:pointer}
        .error{margin:0 0 1rem;padding:1rem;border-radius:.75rem;background:rgba(248,113,113,.12);color:#fee2e2}
        .link{display:block;margin-top:1rem;text-align:center;color:#a5b4fc;text-decoration:none}
    </style>
</head>
<body>
    <div class="card">
        <h1>Autentificare Admin</h1>
        <p>Introduceți datele contului pentru a accesa panoul de administrare.</p>

        @if($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>

            <label for="password">Parolă</label>
            <input id="password" type="password" name="password" required>

            <label style="font-size:.85rem;margin-top:1rem;display:flex;align-items:center;gap:.5rem">
                <input type="checkbox" name="remember" style="width:1rem;height:1rem"> Ține-mă autentificat
            </label>

            <button type="submit">Autentifică-te</button>
        </form>

        <a class="link" href="{{ route('home') }}">Înapoi la site</a>
    </div>
</body>
</html>
