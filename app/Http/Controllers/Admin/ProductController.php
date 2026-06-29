<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Intervention\Image\ImageManagerStatic as Image;

class ProductController extends AdminController
{
    public function index(): View
    {
        $products = Product::with('category')->latest()->get();

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('admin.products.form', ['product' => new Product(), 'categories' => $categories]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['is_featured'] = (bool) ($validated['is_featured'] ?? false);
        $validated['is_active'] = (bool) ($validated['is_active'] ?? true);

        // handle uploaded image file
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = $validated['slug'] . '.' . ($ext ?: 'jpg');
            $imagesDir = public_path('images/products');
            if (! is_dir($imagesDir)) {
                mkdir($imagesDir, 0755, true);
            }

            $fullPath = $imagesDir . DIRECTORY_SEPARATOR . $filename;

            // save resized main image (max width 1200)
            $img = Image::make($file->getPathname())->orientate();
            $img->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($fullPath, 85);

            // save webp main
            try {
                $webpFull = $imagesDir . DIRECTORY_SEPARATOR . $validated['slug'] . '.webp';
                $img->encode('webp', 85)->save($webpFull);
            } catch (\Throwable $e) {
                // ignore if encoding unavailable
            }

            // generate thumbnail
            $thumbPath = $imagesDir . DIRECTORY_SEPARATOR . $validated['slug'] . '_thumb.' . ($ext ?: 'jpg');
            $img->fit(400, 260)->save($thumbPath, 80);

            // generate webp thumb
            try {
                $webpThumb = $imagesDir . DIRECTORY_SEPARATOR . $validated['slug'] . '_thumb.webp';
                $img->encode('webp', 80)->save($webpThumb);
            } catch (\Throwable $e) {
                // ignore
            }

            $validated['image'] = 'images/products/' . basename($fullPath);
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produsul a fost salvat cu succes.');
    }

    public function edit(Product $product): View
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('admin.products.form', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug,' . $product->id],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['is_featured'] = (bool) ($validated['is_featured'] ?? false);
        $validated['is_active'] = (bool) ($validated['is_active'] ?? true);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = $validated['slug'] . '.' . ($ext ?: 'jpg');
            $imagesDir = public_path('images/products');
            if (! is_dir($imagesDir)) {
                mkdir($imagesDir, 0755, true);
            }

            $fullPath = $imagesDir . DIRECTORY_SEPARATOR . $filename;

            $img = Image::make($file->getPathname())->orientate();
            $img->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($fullPath, 85);

            try {
                $webpFull = $imagesDir . DIRECTORY_SEPARATOR . $validated['slug'] . '.webp';
                $img->encode('webp', 85)->save($webpFull);
            } catch (\Throwable $e) {}

            $thumbPath = $imagesDir . DIRECTORY_SEPARATOR . $validated['slug'] . '_thumb.' . ($ext ?: 'jpg');
            $img->fit(400, 260)->save($thumbPath, 80);

            try {
                $webpThumb = $imagesDir . DIRECTORY_SEPARATOR . $validated['slug'] . '_thumb.webp';
                $img->encode('webp', 80)->save($webpThumb);
            } catch (\Throwable $e) {}

            $validated['image'] = 'images/products/' . basename($fullPath);
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produsul a fost actualizat.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produsul a fost eliminat.');
    }
}
