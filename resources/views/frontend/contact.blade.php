<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact | ElectroHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--bg:#060816;--surface:#0e172c;--text:#f5f7ff;--muted:#94a3b8;--accent:#34d399;--accent-2:#4f7cff;--border:rgba(255,255,255,.12)}
        *{box-sizing:border-box;margin:0;padding:0} body{font-family:'Inter',sans-serif;background:linear-gradient(135deg,var(--bg),#091221 60%,#0c1327);color:var(--text);line-height:1.6}
        a{text-decoration:none;color:inherit}.container{width:min(1080px,calc(100% - 2rem));margin:0 auto;padding:3rem 0}.card{padding:1.4rem;border:1px solid var(--border);border-radius:1.2rem;background:linear-gradient(145deg,rgba(255,255,255,.06),rgba(255,255,255,.02));box-shadow:0 16px 38px rgba(0,0,0,.2)}.muted{color:var(--muted)}.accent{color:var(--accent)}.grid{display:grid;grid-template-columns:1.1fr .9fr;gap:1rem}.field{display:block;margin-top:.8rem}.field input,.field textarea{width:100%;padding:.8rem 1rem;border-radius:.9rem;border:1px solid var(--border);background:rgba(255,255,255,.04);color:var(--text);margin-top:.45rem}.btn{display:inline-flex;justify-content:center;align-items:center;padding:.85rem 1rem;border-radius:999px;font-weight:600;border:1px solid transparent;margin-top:1rem;background:linear-gradient(135deg,var(--accent),var(--accent-2));color:#fff}@media (max-width:860px){.grid{grid-template-columns:1fr}}
    </style>
</head>
<body>
<div class="container">
    <a href="{{ route('home') }}" class="accent">← Înapoi acasă</a>
    <div class="grid" style="margin-top:1rem">
        <div class="card">
            <p class="accent" style="text-transform:uppercase;letter-spacing:.24em;font-size:.8rem;font-weight:700">Contact</p>
            <h1 style="font-size:clamp(1.8rem,4vw,2.6rem);margin:.5rem 0 .8rem">Suntem aici pentru orice întrebare</h1>
            <p class="muted">Trimite-ne un mesaj și vom reveni cu o soluție clară și rapidă pentru proiectul tău.</p>
            <div style="margin-top:1rem">
                <p><strong>Email:</strong> office@electrohub.ro</p>
                <p><strong>Telefon:</strong> +40 721 234 567</p>
                <p><strong>Adresă:</strong> București, România</p>
            </div>
        </div>
        <div class="card">
            @if(session('success'))
                <div style="padding:.8rem;border-radius:.6rem;background:rgba(52,211,153,.08);color:var(--accent);margin-bottom:1rem">{{ session('success') }}</div>
            @endif
            <form method="POST" action="{{ route('contact.submit') }}" aria-labelledby="contact-form-title">
                @csrf
                <h2 id="contact-form-title" class="muted" style="margin:0 0 .6rem">Trimite un mesaj</h2>
                <label class="field" for="name">
                    <span>Nume</span>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Numele tău" required aria-required="true">
                </label>
                <label class="field" for="email">
                    <span>Email</span>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="exemplu@email.com" required aria-required="true">
                </label>
                <label class="field" for="phone">
                    <span>Telefon (opțional)</span>
                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}" placeholder="Telefon">
                </label>
                <label class="field" for="message">
                    <span>Mesaj</span>
                    <textarea id="message" name="message" rows="5" placeholder="Scrie-ne ce ai nevoie" required aria-required="true">{{ old('message') }}</textarea>
                </label>
                <button type="submit" class="btn" aria-label="Trimite mesaj">Trimite mesaj</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
