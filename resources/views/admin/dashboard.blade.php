@extends('admin.layout')

@section('content')
<div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;margin-bottom:1rem">
        <div>
            <h1 style="font-size:1.5rem;margin-bottom:.3rem">Dashboard admin</h1>
            <p class="muted">Control central pentru categorii, produse ?i pagini publice.</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">Gestioneaza con?inutul</a>
    </div>

    <div class="card-grid three-up" style="margin-top:1rem">
        <div class="card">
            <p class="eyebrow">Categorii</p>
            <h3>{{ $stats['categories'] }}</h3>
            <a href="{{ route('admin.categories.index') }}">Vezi categorii</a>
        </div>
        <div class="card">
            <p class="eyebrow">Produse</p>
            <h3>{{ $stats['products'] }}</h3>
            <a href="{{ route('admin.products.index') }}">Vezi produse</a>
        </div>
        <div class="card">
            <p class="eyebrow">Pagini</p>
            <h3>{{ $stats['pages'] }}</h3>
            <a href="{{ route('admin.pages.index') }}">Vezi pagini</a>
        </div>
    </div>
</div>
@endsection
