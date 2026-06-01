<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BranchScope
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->branch_id && !auth()->user()->hasRole('Super Admin')) {
            $request->merge(['branch_id' => auth()->user()->branch_id]);
            $request->attributes->set('branch_id', auth()->user()->branch_id);
        }

        return $next($request);
    }
}