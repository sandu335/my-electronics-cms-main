<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Mesaj contact</title>
</head>
<body>
    <h2>Mesaj nou de la {{ $lead->name }}</h2>
    <p><strong>Email:</strong> {{ $lead->email }}</p>
    @if($lead->phone)
        <p><strong>Telefon:</strong> {{ $lead->phone }}</p>
    @endif
    <p><strong>Mesaj:</strong></p>
    <p>{{ nl2br(e($lead->message)) }}</p>
    <p>Trimis la: {{ $lead->created_at }}</p>
</body>
</html>
