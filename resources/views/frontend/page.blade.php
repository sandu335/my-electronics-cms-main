<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->title }} | ElectroHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--bg:#060816;--text:#f5f7ff;--muted:#94a3b8;--accent:#34d399;--accent-2:#4f7cff;--border:rgba(255,255,255,.12)}*{box-sizing:border-box;margin:0;padding:0}body{font-family:'Inter',sans-serif;background:linear-gradient(135deg,var(--bg),#091221 60%,#0c1327);color:var(--text);line-height:1.6}.container{width:min(1000px,calc(100% - 2rem));margin:0 auto;padding:3rem 0}.card{padding:1.4rem;border:1px solid var(--border);border-radius:1.2rem;background:linear-gradient(145deg,rgba(255,255,255,.06),rgba(255,255,255,.02));box-shadow:0 16px 38px rgba(0,0,0,.2)}.muted{color:var(--muted)}.accent{color:var(--accent)}.section{margin-top:1rem;padding:1rem;border:1px solid var(--border);border-radius:1rem;background:rgba(255,255,255,.03)}
    </style>
</head>
<body>
<div class="container">
    <a href="{{ route('home') }}" class="accent">? Înapoi acasa</a>
    <div class="card" style="margin-top:1rem">
        <p class="accent" style="text-transform:uppercase;letter-spacing:.24em;font-size:.8rem;font-weight:700">{{ $page->title }}</p>
        <h1 style="font-size:clamp(1.8rem,4vw,2.6rem);margin:.5rem 0 1rem">{{ $page->title }}</h1>
        <div class="muted">
            {!! $page->content !!}
        </div>
        @foreach($page->sections()->orderBy('sort_order')->get() as $section)
            <div class="section">
                @if($section->type === 'hero')
                    <h2>{{ $section->data['heading'] ?? '' }}</h2>
                    <p class="muted">{{ $section->data['subheading'] ?? '' }}</p>
                    @if(!empty($section->data['button_label']))
                        <a href="{{ $section->data['button_link'] ?? route('contact') }}" class="accent" style="font-weight:700">{{ $section->data['button_label'] }}</a>
                    @endif
                @elseif($section->type === 'cta')
                    <h3>{{ $section->data['heading'] ?? 'Solicita oferta' }}</h3>
                    <p class="muted">{{ $section->data['content'] ?? '' }}</p>
                    @if(!empty($section->data['button_label']))
                        <a href="{{ $section->data['button_link'] ?? route('contact') }}" class="accent" style="font-weight:700">{{ $section->data['button_label'] }}</a>
                    @endif
                @else
                    <h3>{{ $section->data['heading'] ?? '' }}</h3>
                    <p class="muted">{{ $section->data['content'] ?? '' }}</p>
                @endif
            </div>
        @endforeach
    </div>
</div>
</body>
</html>
