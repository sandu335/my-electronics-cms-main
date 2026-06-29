<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $base = url('/');

        $pages = Page::where('is_published', true)->get();
        $products = Product::where('is_active', true)->get();
        $categories = Category::where('is_active', true)->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>\n';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n';

        // home
        $xml .= "<url><loc>{$base}</loc></url>\n";

        foreach ($pages as $p) {
            $xml .= "<url><loc>{$base}/pagini/{$p->slug}</loc></url>\n";
        }

        foreach ($categories as $c) {
            $xml .= "<url><loc>{$base}/categorii/{$c->slug}</loc></url>\n";
        }

        foreach ($products as $pr) {
            $xml .= "<url><loc>{$base}/produse/{$pr->slug}</loc></url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
