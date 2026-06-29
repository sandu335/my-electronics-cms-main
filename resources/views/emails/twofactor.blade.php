<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cod autentificare</title>
</head>
<body>
    <p>Bună, {{ $user->name }}.</p>
    <p>Codul tău pentru autentificare este: <strong>{{ $user->two_factor_code }}</strong></p>
    <p>Acest cod expiră în 10 minute.</p>
</body>
</html>
