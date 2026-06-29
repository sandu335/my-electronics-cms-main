<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Autentificare - Cod 2FA</title>
    <style>body{font-family:Inter,system-ui;display:flex;align-items:center;justify-content:center;height:100vh;background:#060816;color:#fff}.card{width:360px;padding:1.6rem;border-radius:.8rem;border:1px solid rgba(255,255,255,.06);background:linear-gradient(145deg,rgba(255,255,255,.02),rgba(255,255,255,.01))}.field{margin-top:.8rem}.btn{margin-top:1rem;padding:.6rem 1rem;border-radius:.6rem;background:#34d399;color:#042;border:none}</style>
</head>
<body>
<div class="card">
    <h3>Introdu codul primit pe email</h3>
    @if(session('success'))<div style="color:#34d399">{{ session('success') }}</div>@endif
    @if($errors->any())<div style="color:#ff7b7b">{{ $errors->first() }}</div>@endif
    <form method="POST" action="{{ route('2fa.verify') }}">
        @csrf
        <label class="field">
            <input name="code" autofocus placeholder="Cod (ex: 123456)" style="width:100%;padding:.7rem;border-radius:.6rem;border:1px solid rgba(255,255,255,.06);background:transparent;color:#fff">
        </label>
        <button class="btn">Verifică</button>
    </form>
    <form method="POST" action="{{ route('2fa.resend') }}" style="margin-top:.6rem">
        @csrf
        <button class="btn" type="submit">Retrimite cod</button>
    </form>
</div>
</body>
</html>
