<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Smartphones', 'slug' => 'smartphones', 'description' => 'Gadgeturi mobile premium.'],
            ['name' => 'Audio', 'slug' => 'audio', 'description' => 'Boxe, căști și soluții audio.'],
            ['name' => 'Gaming', 'slug' => 'gaming', 'description' => 'Accesorii și echipamente pentru gaming.'],
        ];

        foreach ($categories as $data) {
            Category::updateOrCreate(['slug' => $data['slug']], $data);
        }

        $pages = [
            ['title' => 'Despre noi', 'slug' => 'despre-noi', 'content' => '<p>Acesta este un CMS modern pentru electronice.</p>'],
            ['title' => 'Contact', 'slug' => 'contact', 'content' => '<p>Contactează-ne pentru o ofertă personalizată.</p>'],
        ];

        foreach ($pages as $data) {
            Page::updateOrCreate(['slug' => $data['slug']], $data);
        }

        $products = [
            ['category_id' => 1, 'name' => 'iPhone 15', 'slug' => 'iphone-15', 'description' => 'Telefon premium cu cameră excelentă.', 'price' => 4999, 'remote_image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=1200&q=80', 'is_featured' => true],
            ['category_id' => 2, 'name' => 'Căști Bose', 'slug' => 'casti-bose', 'description' => 'Sunet clar și confort maxim.', 'price' => 1499, 'remote_image' => 'https://images.unsplash.com/photo-1512314889357-e157c22f938d?auto=format&fit=crop&w=1200&q=80', 'is_featured' => true],
            ['category_id' => 3, 'name' => 'Mouse Logitech G Pro', 'slug' => 'mouse-logitech-g-pro', 'description' => 'Precizie ridicată pentru gaming.', 'price' => 899, 'remote_image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=1200&q=80', 'is_featured' => true],
        ];

        // Ensure local images directory exists
        $imagesDir = public_path('images/products');
        if (! is_dir($imagesDir)) {
            mkdir($imagesDir, 0755, true);
        }

        foreach ($products as $data) {
            // download remote image if provided and save to public/images/products/{slug}.jpg
            if (! empty($data['remote_image'])) {
                $localName = $data['slug'] . '.jpg';
                $localPath = $imagesDir . DIRECTORY_SEPARATOR . $localName;

                if (! file_exists($localPath)) {
                    try {
                        $contents = @file_get_contents($data['remote_image']);
                        if ($contents !== false) {
                            file_put_contents($localPath, $contents);
                        }
                    } catch (\Throwable $e) {
                        // ignore download errors; fallback to remote URL
                    }
                }

                if (file_exists($localPath)) {
                    $data['image'] = 'images/products/' . $localName;
                } else {
                    $data['image'] = $data['remote_image'];
                }

                unset($data['remote_image']);
            }

            Product::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
