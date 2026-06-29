@extends('admin.layout')

@section('content')
<div class="card" style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;">
    <div>
        <h1 style="font-size:1.5rem;margin-bottom:.3rem">Categorie</h1>
        <p class="muted">Completeaza toate c�mpurile pentru a publica o noua categorie.</p>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">�napoi</a>
</div>
<div class="card" style="margin-top:1rem">
    <form action="{{ isset($category->id) ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST">
        @csrf
        @if(isset($category->id))
            @method('PUT')
        @endif
        @if($errors->any())
            <div style="margin-bottom:1rem;padding:1rem;border:1px solid rgba(248,113,113,.3);border-radius:1rem;background:rgba(248,113,113,.08);color:#f87171">
                <strong>Există erori în formular:</strong>
                <ul style="margin-top:.6rem;list-style:disc inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div style="display:grid;gap:1rem">
            <label>
                <span style="display:block;margin-bottom:.4rem">Nume</span>
                <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" style="width:100%;padding:.8rem;border-radius:.7rem;border:1px solid var(--border);background:rgba(255,255,255,.04);color:var(--text)">
            </label>
            <label>
                <span style="display:block;margin-bottom:.4rem">Slug</span>
                <input type="text" name="slug" value="{{ old('slug', $category->slug ?? '') }}" style="width:100%;padding:.8rem;border-radius:.7rem;border:1px solid var(--border);background:rgba(255,255,255,.04);color:var(--text)">
            </label>
            <label>
                <span style="display:block;margin-bottom:.4rem">Descriere</span>
                <textarea name="description" rows="4" style="width:100%;padding:.8rem;border-radius:.7rem;border:1px solid var(--border);background:rgba(255,255,255,.04);color:var(--text)">{{ old('description', $category->description ?? '') }}</textarea>
            </label>
            <label style="display:flex;align-items:center;gap:.6rem">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
                <span>Activa �n frontend</span>
            </label>
        </div>
        <div style="margin-top:1rem">
            <button type="submit" class="btn btn-primary">Salveaza</button>
        </div>
    </form>
</div>
@endsection
