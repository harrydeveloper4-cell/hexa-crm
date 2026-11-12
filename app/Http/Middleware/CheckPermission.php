<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Allow the request when the logged in admin has any of the
     * given permissions. Super Admin always passes.
     *
     * Usage: ->middleware('permission:brand_view')
     *        ->middleware('permission:view_all_orders,view_own_orders')
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$permissions
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        $user = auth_staff();

        if (empty($user)) {
            return redirect()->route('admin.login');
        }

        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        foreach ($permissions as $permission) {
            if ($user->has_permission(trim($permission))) {
                return $next($request);
            }
        }

        abort(403, 'You do not have permission to access this page.');
    }
}
