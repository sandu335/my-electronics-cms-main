<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class UpdateProductImagesSeeder extends Seeder
{
    public function run(): void
    {
        Product::where('slug', 'iphone-15')->update(['image' => 'images/products/iphone-15.jpg']);
        Product::where('slug', 'casti-bose')->update(['image' => 'images/products/casti-bose.webp']);
        Product::where('slug', 'mouse-logitech-g-pro')->update(['image' => 'images/products/mouse-logitech-g-pro.jpg']);
    }
}
