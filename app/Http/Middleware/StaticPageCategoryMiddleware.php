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

class StaticPageCategoryMiddleware
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
        if(!$this->validateStaticPageCategory($request->route('category')))
            return redirect('/admin')->with('status', 'Выбранный пункт меню не доступен');

        return $next($request);
    }
    private function validateStaticPageCategory($category)
    {
        $type = StaticPage::getTypeIdArray();
        if(!isset($type[$category]) or !in_array($type[$category],StaticPage::validStaticPagesArray()))
            return false;
        return true;
    }
}
