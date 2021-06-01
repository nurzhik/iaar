<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

/**
 * --------------------------------------------------------------------------
 *  CheckPermission
 * --------------------------------------------------------------------------
 *
 *  Проверка прав доступа
 *
 */

class AdminMiddleware
{
    /**
     * Перехват входящего запроса.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Auth::user()){
            return redirect('/login')->with('auth_required',true);
        }

        if (Auth::user()->type_id!==1) {
            return redirect('/login')->with('status', 'У вас недостаточно прав для доступа к выбранному разделу');
        }

        return $next($request);
    }
}
