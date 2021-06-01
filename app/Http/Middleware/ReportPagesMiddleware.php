<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\StaticPage;

/**
 * --------------------------------------------------------------------------
 *  CheckPermission
 * --------------------------------------------------------------------------
 *
 *  Проверка прав доступа
 *
 */

class ReportPagesMiddleware
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
        if(!$this->validateStaticPageCategory($request->route('type')))
            return redirect('/admin')->with('status', 'Выбранный пункт меню не доступен');

        return $next($request);
    }
    private function validateStaticPageCategory($category)
    {
        $type = array_flip(StaticPage::getTypeIdArray());
        if(!isset($type[$category]) or $category<11 or $category>17)
            return false;
        return true;
    }
}
