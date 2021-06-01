<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\StaticPage;
use App;

/**
 * --------------------------------------------------------------------------
 *  CheckPermission
 * --------------------------------------------------------------------------
 *
 *  Проверка прав доступа
 *
 */

class LangMiddleware
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
        if(!$this->validateLang($request->route('lang')))
            return redirect('/404')->with('status', 'Недоступный язык');

        return $next($request);
    }
    private function validateLang($lang)
    {
        if($lang == '')
        {
            App::setLocale('ru');
            return true;
        }
        else
        {
            if($lang == 'kz')
            {
                App::setLocale('kz');
                return true;
            }
            if($lang == 'en')
            {
                App::setLocale('en');
                return true;
            }

        }
        return false;

    }
}
