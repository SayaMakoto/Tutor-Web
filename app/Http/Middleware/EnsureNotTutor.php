<?php

namespace App\Http\Middleware;

use Closure;

class EnsureNotTutor
{
    public function handle($request, Closure $next)
    {
        if (in_array(auth()->user()->role, ['tutor', 'both'])) {
            return redirect()->route('home')
                ->with('error', 'Bạn đã là gia sư rồi.');
        }

        return $next($request);
    }
}