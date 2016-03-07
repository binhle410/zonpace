<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class BackendRouteNeedsPermission
 * @package App\Http\Middleware
 */
class BackendRouteNeedsPermission
{
    /**
     * @param          $request
     * @param callable $next
     * @param          $permission
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        if (! access()->allow($permission)) {
            return redirect()
                ->route('backend.index')
                ->withFlashDanger(trans('auth.general_error'));
        }

        return $next($request);
    }
}