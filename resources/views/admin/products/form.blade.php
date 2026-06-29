@extends('admin.layout')

@section('content')
<div class="card" style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;">
    <div>
        <h1 style="font-size:1.5rem;margin-bottom:.3rem">Produs</h1>
        <p class="muted">Completeaza c�mpurile pentru a publica un produs.</p>
    </div>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline">�napoi</a>
</div>
<div class="card" style="margin-top:1rem">
    <form action="{{ isset($product->id) ? route('admin.products.update', $product) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($product->id))
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
                <span style="display:block;margin-bottom:.4rem">Categorie</span>
                <select name="category_id" style="width:100%;padding:.8rem;border-radius:.7rem;border:1px solid var(--border);background:rgba(255,255,255,.04);color:var(--text)">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            <label>
                <span style="display:block;margin-bottom:.4rem">Imagine (upload)</span>
                <input type="file" name="image" accept="image/*" style="width:100%;padding:.4rem;border-radius:.7rem;border:1px solid var(--border);background:rgba(255,255,255,.02);color:var(--text)">
                @if(!empty($product->image))
                    <div style="margin-top:.6rem">
                        <img src="{{ asset($product->image) }}" alt="preview" style="max-width:180px;border-radius:.6rem;border:1px solid rgba(255,255,255,.04)">
                    </div>
                @endif
            </label>
            </label>
            <label>
                <span style="display:block;margin-bottom:.4rem">Slug</span>
                <input type="text" name="slug" value="{{ old('slug', $product->slug ?? '') }}" style="width:100%;padding:.8rem;border-radius:.7rem;border:1px solid var(--border);background:rgba(255,255,255,.04);color:var(--text)">
            </label>
            <label>
                <span style="display:block;margin-bottom:.4rem">Descriere</span>
                <textarea name="description" rows="4" style="width:100%;padding:.8rem;border-radius:.7rem;border:1px solid var(--border);background:rgba(255,255,255,.04);color:var(--text)">{{ old('description', $product->description ?? '') }}</textarea>
            </label>
            <label>
                <span style="display:block;margin-bottom:.4rem">Pre?</span>
                <input type="number" step="0.01" name="price" value="{{ old('price', $product->price ?? '') }}" style="width:100%;padding:.8rem;border-radius:.7rem;border:1px solid var(--border);background:rgba(255,255,255,.04);color:var(--text)">
            </label>
            <label>
                <span style="display:block;margin-bottom:.4rem">Imagine (URL sau cale locală)</span>
                <input type="text" name="image" value="{{ old('image', $product->image ?? '') }}" style="width:100%;padding:.8rem;border-radius:.7rem;border:1px solid var(--border);background:rgba(255,255,255,.04);color:var(--text)">
            </label>
            <label style="display:flex;align-items:center;gap:.6rem">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
                <span>Recomandat</span>
            </label>
            <label style="display:flex;align-items:center;gap:.6rem">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                <span>Activ �n frontend</span>
            </label>
        </div>
        <div style="margin-top:1rem">
            <button type="submit" class="btn btn-primary">Salveaza</button>
        </div>
    </form>
</div>
@endsection
