<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cere ofertă | ElectroHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--bg:#060816;--surface:#0e172c;--text:#f5f7ff;--muted:#94a3b8;--accent:#34d399;--accent-2:#4f7cff;--border:rgba(255,255,255,.12)}
        *{box-sizing:border-box;margin:0;padding:0} body{font-family:'Inter',sans-serif;background:linear-gradient(135deg,var(--bg),#091221 60%,#0c1327);color:var(--text);line-height:1.6}
        a{text-decoration:none;color:inherit}.container{width:min(1080px,calc(100% - 2rem));margin:0 auto;padding:3rem 0}.card{padding:1.4rem;border:1px solid var(--border);border-radius:1.2rem;background:linear-gradient(145deg,rgba(255,255,255,.06),rgba(255,255,255,.02));box-shadow:0 16px 38px rgba(0,0,0,.2)}.muted{color:var(--muted)}.accent{color:var(--accent)}.field{display:block;margin-top:.8rem}.field input,.field textarea,.field select{width:100%;padding:.8rem 1rem;border-radius:.9rem;border:1px solid var(--border);background:rgba(255,255,255,.04);color:var(--text);margin-top:.45rem}.btn{display:inline-flex;justify-content:center;align-items:center;padding:.85rem 1rem;border-radius:999px;font-weight:600;border:1px solid transparent;margin-top:1rem;background:linear-gradient(135deg,var(--accent),var(--accent-2));color:#fff}
    </style>
</head>
<body>
<div class="container">
    <a href="{{ route('home') }}" class="accent">← Înapoi acasă</a>
    <div class="card" style="margin-top:1rem">
        <p class="accent" style="text-transform:uppercase;letter-spacing:.24em;font-size:.8rem;font-weight:700">Cere ofertă</p>
        <h1 style="font-size:clamp(1.8rem,4vw,2.6rem);margin:.5rem 0 .8rem">Solicită o ofertă personalizată pentru produsul dorit</h1>
        <p class="muted">Completează formularul și îți răspundem cu cel mai bun preț și condiții potrivite pentru nevoile tale.</p>
        <form style="margin-top:1rem">
            <label class="field">
                <span>Nume</span>
                <input type="text" placeholder="Numele tău">
            </label>
            <label class="field">
                <span>Email</span>
                <input type="email" placeholder="exemplu@email.com">
            </label>
            <label class="field">
                <span>Produs interesat</span>
                <select>
                    <option value="">Alege un produs</option>
                    <option>Smartphone</option>
                    <option>Audio</option>
                    <option>Gaming</option>
                </select>
            </label>
            <label class="field">
                <span>Detalii</span>
                <textarea rows="5" placeholder="Spune-ne câte bucăți ai nevoie și ce cerințe ai"></textarea>
            </label>
            <button type="submit" class="btn">Trimite cererea</button>
        </form>
    </div>
</div>
</body>
</html>
