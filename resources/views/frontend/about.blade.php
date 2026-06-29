<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Despre noi | ElectroHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--bg:#060816;--surface:#0e172c;--text:#f5f7ff;--muted:#94a3b8;--accent:#34d399;--accent-2:#4f7cff;--border:rgba(255,255,255,.12)}
        *{box-sizing:border-box;margin:0;padding:0} body{font-family:'Inter',sans-serif;background:linear-gradient(135deg,var(--bg),#091221 60%,#0c1327);color:var(--text);line-height:1.6}
        a{text-decoration:none;color:inherit}.container{width:min(1080px,calc(100% - 2rem));margin:0 auto;padding:3rem 0}.card{padding:1.4rem;border:1px solid var(--border);border-radius:1.2rem;background:linear-gradient(145deg,rgba(255,255,255,.06),rgba(255,255,255,.02));box-shadow:0 16px 38px rgba(0,0,0,.2)}.muted{color:var(--muted)}.accent{color:var(--accent)}.btn{display:inline-flex;justify-content:center;align-items:center;padding:.8rem 1rem;border-radius:999px;font-weight:600;border:1px solid transparent;margin-top:1rem}.btn-primary{background:linear-gradient(135deg,var(--accent),var(--accent-2));color:#fff}
    </style>
</head>
<body>
<div class="container">
    <a href="{{ route('home') }}" class="accent">← Înapoi acasă</a>
    <div class="card" style="margin-top:1rem">
        <p class="accent" style="text-transform:uppercase;letter-spacing:.24em;font-size:.8rem;font-weight:700">Despre noi</p>
        <h1 style="font-size:clamp(1.8rem,4vw,2.6rem);margin:.5rem 0 1rem">Suntem partenerul digital pentru businessul electronic modern</h1>
        <p class="muted">ElectroHub construiește experiențe digitale premium pentru companii care vor să vândă mai bine, să comunice clar și să aibă un site complet administrabil. Oferta noastră include navigație clară, pagini de prezentare, categorii de produse și un panou de administrare pentru gestionarea conținutului.</p>
        <p class="muted" style="margin-top:.8rem">Fie că ai nevoie de un website de prezentare, de o platformă de vânzări sau de un CMS clar și rapid de folosit, echipa noastră te ajută să îți construiești o prezență digitală profesională.</p>
        <a href="{{ route('quote') }}" class="btn btn-primary">Cere ofertă</a>
    </div>
</div>
</body>
</html>
