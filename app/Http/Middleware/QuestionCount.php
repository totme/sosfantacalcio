<?php

namespace App\Http\Middleware;

use App\Enum\Role;
use Closure;
use Illuminate\Http\Request;

class QuestionCount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->credits > 0) {
            return $next($request);
        }

        return redirect()->route('dashboard')->with('generic.error', 'Non hai abbastanza crediti per creare nuove domande.');
    }
}
