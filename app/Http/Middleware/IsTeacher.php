<?php

namespace App\Http\Middleware;

use Closure;

class IsTeacher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $user = session('user');
        if ($user){
            if ($user['role'] !== 'TEACHER') {
                $request->session()->flash('message', 'Unauthorized');
                return redirect('/');
            }
        }

        return $next($request);
    }
}
