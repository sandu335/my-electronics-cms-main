@extends('admin.layout')

@section('content')
<div class="card" style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;">
    <div>
        <h1 style="font-size:1.5rem;margin-bottom:.3rem">Pagina</h1>
        <p class="muted">Creeaza con?inut public ?i sec?iuni pentru pagini de tip hero, text sau CTA.</p>
    </div>
    <a href="{{ route('admin.pages.index') }}" class="btn btn-outline">�napoi</a>
</div>
<div class="card" style="margin-top:1rem">
    <form action="{{ isset($page->id) ? route('admin.pages.update', $page) : route('admin.pages.store') }}" method="POST">
        @csrf
        @if(isset($page->id))
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
                <span style="display:block;margin-bottom:.4rem">Titlu</span>
                <input type="text" name="title" value="{{ old('title', $page->title ?? '') }}" style="width:100%;padding:.8rem;border-radius:.7rem;border:1px solid var(--border);background:rgba(255,255,255,.04);color:var(--text)">
            </label>
            <label>
                <span style="display:block;margin-bottom:.4rem">Slug</span>
                <input type="text" name="slug" value="{{ old('slug', $page->slug ?? '') }}" style="width:100%;padding:.8rem;border-radius:.7rem;border:1px solid var(--border);background:rgba(255,255,255,.04);color:var(--text)">
            </label>
            <label>
                <span style="display:block;margin-bottom:.4rem">Con?inut principal</span>
                <textarea name="content" rows="5" style="width:100%;padding:.8rem;border-radius:.7rem;border:1px solid var(--border);background:rgba(255,255,255,.04);color:var(--text)">{{ old('content', $page->content ?? '') }}</textarea>
            </label>
            <label style="display:flex;align-items:center;gap:.6rem">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $page->is_published ?? true) ? 'checked' : '' }}>
                <span>Publicata</span>
            </label>
        </div>

        <div style="margin-top:1.2rem">
            <h3 style="margin-bottom:.7rem">Builder de pagina</h3>
            <div id="builder-list">
                @php $builderSections = $sections ?? []; @endphp
                @foreach($builderSections as $index => $section)
                    <div class="card" style="margin-bottom:.8rem">
                        <input type="hidden" name="sections[{{ $index }}][id]" value="{{ $section->id }}">
                        <div style="display:flex;justify-content:space-between;align-items:center;gap:1rem">
                            <strong>Sec?iune {{ $index + 1 }}</strong>
                            <span class="muted">Trage pentru a reordona</span>
                        </div>
                        <div style="display:grid;gap:.75rem;margin-top:.8rem">
                            <label>
                                <span style="display:block;margin-bottom:.4rem">Tip</span>
                                <select name="sections[{{ $index }}][type]" style="width:100%;padding:.8rem;border-radius:.7rem;border:1px solid var(--border);background:rgba(255,255,255,.04);color:var(--text)">
                                    <option value="content" {{ $section->type === 'content' ? 'selected' : '' }}>Text</option>
                                    <option value="hero" {{ $section->type === 'hero' ? 'selected' : '' }}>Hero</option>
                                    <option value="cta" {{ $section->type === 'cta' ? 'selected' : '' }}>CTA</option>
                                </select>
                            </label>
                            <label>
                                <span style="display:block;margin-bottom:.4rem">Titlu</span>
                                <input type="text" name="sections[{{ $index }}][heading]" value="{{ $section->data['heading'] ?? '' }}" style="width:100%;padding:.8rem;border-radius:.7rem;border:1px solid var(--border);background:rgba(255,255,255,.04);color:var(--text)">
                            </label>
                            <label>
                                <span style="display:block;margin-bottom:.4rem">Subtitlu</span>
                                <input type="text" name="sections[{{ $index }}][subheading]" value="{{ $section->data['subheading'] ?? '' }}" style="width:100%;padding:.8rem;border-radius:.7rem;border:1px solid var(--border);background:rgba(255,255,255,.04);color:var(--text)">
                            </label>
                            <label>
                                <span style="display:block;margin-bottom:.4rem">Con?inut</span>
                                <textarea name="sections[{{ $index }}][content]" rows="3" style="width:100%;padding:.8rem;border-radius:.7rem;border:1px solid var(--border);background:rgba(255,255,255,.04);color:var(--text)">{{ $section->data['content'] ?? '' }}</textarea>
                            </label>
                            <label>
                                <span style="display:block;margin-bottom:.4rem">Buton</span>
                                <input type="text" name="sections[{{ $index }}][button_label]" value="{{ $section->data['button_label'] ?? '' }}" style="width:100%;padding:.8rem;border-radius:.7rem;border:1px solid var(--border);background:rgba(255,255,255,.04);color:var(--text)">
                            </label>
                            <label>
                                <span style="display:block;margin-bottom:.4rem">Link buton</span>
                                <input type="text" name="sections[{{ $index }}][button_link]" value="{{ $section->data['button_link'] ?? '' }}" style="width:100%;padding:.8rem;border-radius:.7rem;border:1px solid var(--border);background:rgba(255,255,255,.04);color:var(--text)">
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-outline" id="add-section">Adauga sec?iune</button>
        </div>

        <div style="margin-top:1rem">
            <button type="submit" class="btn btn-primary">Salveaza</button>
        </div>
    </form>
</div>

<script>
    const builderList = document.getElementById('builder-list');
    const addSectionButton = document.getElementById('add-section');
    let sectionIndex = {{ count($builderSections) }};

    addSectionButton?.addEventListener('click', () => {
        const wrapper = document.createElement('div');
        wrapper.className = 'card';
        wrapper.style.marginBottom = '.8rem';
        wrapper.innerHTML = `
            <div style="display:flex;justify-content:space-between;align-items:center;gap:1rem">
                <strong>Sec?iune ${sectionIndex + 1}</strong>
                <span class="muted">Trage pentru a reordona</span>
            </div>
            <div style="display:grid;gap:.75rem;margin-top:.8rem">
                <label><span style="display:block;margin-bottom:.4rem">Tip</span><select name="sections[${sectionIndex}][type]" style="width:100%;padding:.8rem;border-radius:.7rem;border:1px solid var(--border);background:rgba(255,255,255,.04);color:var(--text)"><option value="content">Text</option><option value="hero">Hero</option><option value="cta">CTA</option></select></label>
                <label><span style="display:block;margin-bottom:.4rem">Titlu</span><input type="text" name="sections[${sectionIndex}][heading]" style="width:100%;padding:.8rem;border-radius:.7rem;border:1px solid var(--border);background:rgba(255,255,255,.04);color:var(--text)"></label>
                <label><span style="display:block;margin-bottom:.4rem">Subtitlu</span><input type="text" name="sections[${sectionIndex}][subheading]" style="width:100%;padding:.8rem;border-radius:.7rem;border:1px solid var(--border);background:rgba(255,255,255,.04);color:var(--text)"></label>
                <label><span style="display:block;margin-bottom:.4rem">Con?inut</span><textarea name="sections[${sectionIndex}][content]" rows="3" style="width:100%;padding:.8rem;border-radius:.7rem;border:1px solid var(--border);background:rgba(255,255,255,.04);color:var(--text)"></textarea></label>
                <label><span style="display:block;margin-bottom:.4rem">Buton</span><input type="text" name="sections[${sectionIndex}][button_label]" style="width:100%;padding:.8rem;border-radius:.7rem;border:1px solid var(--border);background:rgba(255,255,255,.04);color:var(--text)"></label>
                <label><span style="display:block;margin-bottom:.4rem">Link buton</span><input type="text" name="sections[${sectionIndex}][button_link]" style="width:100%;padding:.8rem;border-radius:.7rem;border:1px solid var(--border);background:rgba(255,255,255,.04);color:var(--text)"></label>
            </div>`;
        builderList.appendChild(wrapper);
        sectionIndex++;
    });
</script>
@endsection
