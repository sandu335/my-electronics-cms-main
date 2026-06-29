<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/categorii/{slug}', [FrontendController::class, 'category'])->name('category.show');
Route::get('/pagini/{slug}', [FrontendController::class, 'page'])->name('page.show');
Route::get('/produse/{slug}', [FrontendController::class, 'product'])->name('product.show');
Route::get('/despre-noi', [FrontendController::class, 'about'])->name('about');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('/contact', [FrontendController::class, 'submitContact'])->name('contact.submit');
Route::get('/cere-oferta', [FrontendController::class, 'quote'])->name('quote');
Route::get('/produse', [FrontendController::class, 'products'])->name('products');

Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index']);

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('throttle:6,1');
});

// two-factor verification routes
Route::get('/2fa', function () {
    return view('auth.2fa');
})->name('2fa.index');

Route::post('/2fa', [\App\Http\Controllers\Auth\TwoFactorController::class, 'verify'])->name('2fa.verify');
Route::post('/2fa/resend', [\App\Http\Controllers\Auth\TwoFactorController::class, 'resend'])->name('2fa.resend');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('pages', PageController::class);
});
