<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Lead;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactLeadReceived;

class FrontendController extends Controller
{
    public function index(): View
    {
        $categories = Category::withCount('products')->where('is_active', true)->latest()->get();
        $products = Product::where('is_active', true)->latest()->take(6)->get();
        $pages = Page::where('is_published', true)
            ->whereNotIn('slug', ['despre-noi', 'contact'])
            ->get();

        return view('frontend.home', compact('categories', 'products', 'pages'));
    }

    public function category(string $slug): View
    {
        $category = Category::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $products = $category->products()->where('is_active', true)->get();
        $pages = Page::where('is_published', true)
            ->whereNotIn('slug', ['despre-noi', 'contact'])
            ->get();

        return view('frontend.category', compact('category', 'products', 'pages'));
    }

    public function page(string $slug): View
    {
        $page = Page::where('slug', $slug)->where('is_published', true)->firstOrFail();
        $pages = Page::where('is_published', true)
            ->whereNotIn('slug', ['despre-noi', 'contact'])
            ->get();

        return view('frontend.page', compact('page', 'pages'));
    }

    public function product(string $slug): View
    {
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $pages = Page::where('is_published', true)
            ->whereNotIn('slug', ['despre-noi', 'contact'])
            ->get();

        return view('frontend.product', compact('product', 'pages'));
    }

    public function about(): View
    {
        $pages = Page::where('is_published', true)
            ->whereNotIn('slug', ['despre-noi', 'contact'])
            ->get();

        return view('frontend.about', compact('pages'));
    }

    public function products(Request $request): View
    {
        $categories = Category::where('is_active', true)->latest()->get();

        $query = Product::where('is_active', true);

        // filter by category slug
        if ($request->filled('category')) {
            $cat = Category::where('slug', $request->query('category'))->first();
            if ($cat) {
                $query->where('category_id', $cat->id);
            }
        }

        // search by name or description
        if ($request->filled('q')) {
            $q = $request->query('q');
            $query->where(function ($qbuilder) use ($q) {
                $qbuilder->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        // NOTE: do not cache the LengthAwarePaginator instance directly — serialize issues can occur.
        $products = $query->latest()->paginate(9);

        $pages = Page::where('is_published', true)
            ->whereNotIn('slug', ['despre-noi', 'contact'])
            ->get();

        return view('frontend.products', compact('categories', 'products', 'pages'));
    }

    public function contact(): View
    {
        $page = Page::where('slug', 'contact')->where('is_published', true)->firstOrFail();
        $pages = Page::where('is_published', true)
            ->whereNotIn('slug', ['despre-noi', 'contact'])
            ->get();

        return view('frontend.contact', compact('page', 'pages'));
    }

    public function quote(): View
    {
        $pages = Page::where('is_published', true)
            ->whereNotIn('slug', ['despre-noi', 'contact'])
            ->get();

        return view('frontend.quote', compact('pages'));
    }

    public function submitContact(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'message' => 'required|string|max:5000',
        ]);

        $lead = Lead::create($data);

        // attempt to send mail to site owner (falls back to env MAIL_FROM_ADDRESS)
        try {
            $to = config('mail.from.address') ?? env('MAIL_FROM_ADDRESS', 'office@electrohub.ro');
            Mail::to($to)->send(new ContactLeadReceived($lead));
        } catch (\Throwable $e) {
            // swallow mail errors but continue
        }

        return redirect()->route('contact')->with('success', 'Mesajul a fost trimis. Vom reveni în scurt timp.');
    }
}
