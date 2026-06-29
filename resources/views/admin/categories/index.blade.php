@extends('admin.layout')

@section('content')
<div class="card" style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;">
    <div>
        <h1 style="font-size:1.5rem;margin-bottom:.3rem">Categorii</h1>
        <p class="muted">Administreaza gruparile de produse pentru frontend.</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Adauga categorie</a>
</div>
<div class="card" style="margin-top:1rem">
    <table style="width:100%;border-collapse:collapse">
        <thead>
            <tr style="text-align:left;border-bottom:1px solid var(--border)">
                <th style="padding:.7rem 0">Nume</th>
                <th style="padding:.7rem 0">Produse</th>
                <th style="padding:.7rem 0">Status</th>
                <th style="padding:.7rem 0">Acțiuni</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr style="border-bottom:1px solid var(--border)">
                    <td style="padding:.8rem 0">{{ $category->name }}</td>
                    <td style="padding:.8rem 0">{{ $category->products_count }}</td>
                    <td style="padding:.8rem 0">
                        <span style="display:inline-flex;padding:.3rem .8rem;border-radius:999px;background:{{ $category->is_active ? 'rgba(52,211,153,.14)' : 'rgba(248,113,113,.14)'}};color:{{ $category->is_active ? '#86efac' : '#fb7185' }}">{{ $category->is_active ? 'Activă' : 'Inactivă' }}</span>
                    </td>
                    <td style="padding:.8rem 0">
                        <a href="{{ route('admin.categories.edit', $category) }}">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline;margin-left:.5rem" onsubmit="return confirm('Ești sigur?')">
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
