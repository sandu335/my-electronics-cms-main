<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PageController extends AdminController
{
    public function index(): View
    {
        $pages = Page::withCount('sections')->latest()->get();

        return view('admin.pages.index', compact('pages'));
    }

    public function create(): View
    {
        return view('admin.pages.form', ['page' => new Page(), 'sections' => []]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:pages,slug'],
            'content' => ['nullable', 'string'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);
        $validated['is_published'] = (bool) ($validated['is_published'] ?? true);

        $page = Page::create($validated);
        $this->syncSections($page, $request->input('sections', []));

        return redirect()->route('admin.pages.index')->with('success', 'Pagina a fost salvata cu succes.');
    }

    public function edit(Page $page): View
    {
        $sections = $page->sections()->orderBy('sort_order')->get();

        return view('admin.pages.form', compact('page', 'sections'));
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:pages,slug,' . $page->id],
            'content' => ['nullable', 'string'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);
        $validated['is_published'] = (bool) ($validated['is_published'] ?? true);

        $page->update($validated);
        $this->syncSections($page, $request->input('sections', []));

        return redirect()->route('admin.pages.index')->with('success', 'Pagina a fost actualizata.');
    }

    public function destroy(Page $page): RedirectResponse
    {
        $page->delete();

        return redirect()->route('admin.pages.index')->with('success', 'Pagina a fost eliminata.');
    }

    protected function syncSections(Page $page, array $sections): void
    {
        $sectionIds = [];
        $sortOrder = 1;

        foreach ($sections as $sectionData) {
            $type = $sectionData['type'] ?? 'content';
            $payload = [
                'heading' => $sectionData['heading'] ?? null,
                'subheading' => $sectionData['subheading'] ?? null,
                'content' => $sectionData['content'] ?? null,
                'button_label' => $sectionData['button_label'] ?? null,
                'button_link' => $sectionData['button_link'] ?? null,
            ];

            $payload = array_filter($payload, fn ($value) => $value !== null && $value !== '');

            if (!empty($sectionData['id'])) {
                $section = $page->sections()->find($sectionData['id']);
                if ($section) {
                    $section->update([
                        'type' => $type,
                        'data' => $payload,
                        'sort_order' => $sortOrder,
                    ]);
                    $sectionIds[] = $section->id;
                }
            } else {
                $section = $page->sections()->create([
                    'type' => $type,
                    'data' => $payload,
                    'sort_order' => $sortOrder,
                ]);
                $sectionIds[] = $section->id;
            }

            $sortOrder++;
        }

        if (!empty($sectionIds)) {
            $page->sections()->whereNotIn('id', $sectionIds)->delete();
        } else {
            $page->sections()->delete();
        }
    }
}
