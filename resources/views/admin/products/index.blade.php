@extends('admin.layout')

@section('content')
<div class="card" style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;">
    <div>
        <h1 style="font-size:1.5rem;margin-bottom:.3rem">Produse</h1>
        <p class="muted">Adauga sau editeaza produse ?i leaga-le de o categorie.</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Adauga produs</a>
</div>
<div class="card" style="margin-top:1rem">
    <table style="width:100%;border-collapse:collapse">
        <thead>
            <tr style="text-align:left;border-bottom:1px solid var(--border)">
                <th style="padding:.7rem 0">Nume</th>
                <th style="padding:.7rem 0">Categorie</th>
                <th style="padding:.7rem 0">Pre?</th>
                <th style="padding:.7rem 0">Ac?iuni</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr style="border-bottom:1px solid var(--border)">
                    <td style="padding:.8rem 0">{{ $product->name }}</td>
                    <td style="padding:.8rem 0">{{ $product->category->name ?? '-' }}</td>
                    <td style="padding:.8rem 0">{{ number_format($product->price, 2, ',', '.') }} Lei</td>
                    <td style="padding:.8rem 0">
                        <span style="display:inline-flex;padding:.3rem .8rem;border-radius:999px;background:{{ $product->is_active ? 'rgba(52,211,153,.14)' : 'rgba(248,113,113,.14)'}};color:{{ $product->is_active ? '#86efac' : '#fb7185' }}">{{ $product->is_active ? 'Activ' : 'Inactiv' }}</span>
                        @if($product->is_featured)
                            <span style="display:inline-flex;margin-left:.4rem;padding:.3rem .8rem;border-radius:999px;background:rgba(79,124,255,.14);color:#93c5fd">Recomandat</span>
                        @endif
                    </td>
                    <td style="padding:.8rem 0">
                        <a href="{{ route('admin.products.edit', $product) }}">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline;margin-left:.5rem" onsubmit="return confirm('Ești sigur?')">
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
