<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Closure;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // inline middleware to ensure user is admin
        $this->middleware(function ($request, Closure $next) {
            $user = $request->user();
            if (! $user || ! ($user->is_admin ?? false)) {
                abort(403);
            }
            return $next($request);
        });
    }
}
