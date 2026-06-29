<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends AdminController
{
    public function index(): View
    {
        $stats = [
            'categories' => Category::count(),
            'products' => Product::count(),
            'pages' => Page::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
