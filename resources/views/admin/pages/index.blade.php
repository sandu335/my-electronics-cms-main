@extends('admin.layout')

@section('content')
<div class="card" style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;">
    <div>
        <h1 style="font-size:1.5rem;margin-bottom:.3rem">Pagini</h1>
        <p class="muted">Construie?te pagini publice ?i adauga sec?iuni printr-un builder simplu.</p>
    </div>
    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">Adauga pagina</a>
</div>
<div class="card" style="margin-top:1rem">
    <table style="width:100%;border-collapse:collapse">
        <thead>
            <tr style="text-align:left;border-bottom:1px solid var(--border)">
                <th style="padding:.7rem 0">Titlu</th>
                <th style="padding:.7rem 0">Secțiuni</th>
                <th style="padding:.7rem 0">Status</th>
                <th style="padding:.7rem 0">Acțiuni</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pages as $page)
                <tr style="border-bottom:1px solid var(--border)">
                    <td style="padding:.8rem 0">{{ $page->title }}</td>
                    <td style="padding:.8rem 0">{{ $page->sections_count }}</td>
                    <td style="padding:.8rem 0">
                        <span style="display:inline-flex;padding:.3rem .8rem;border-radius:999px;background:{{ $page->is_published ? 'rgba(52,211,153,.14)' : 'rgba(248,113,113,.14)'}};color:{{ $page->is_published ? '#86efac' : '#fb7185' }}">{{ $page->is_published ? 'Publicată' : 'Draft' }}</span>
                    </td>
                    <td style="padding:.8rem 0">
                        <a href="{{ route('admin.pages.edit', $page) }}">Edit</a>
                        <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" style="display:inline;margin-left:.5rem" onsubmit="return confirm('Ești sigur?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:none;border:0;color:#f87171;cursor:pointer">Șterge</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
