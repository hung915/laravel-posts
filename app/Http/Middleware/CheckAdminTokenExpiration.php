<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class CheckAdminTokenExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $plainTextToken = $request->session()->get('admin_access_token');
        if ($plainTextToken) {
            $token = PersonalAccessToken::findToken($plainTextToken);
            if ($token && $token->name === 'admin-api-token') {
                $expirationDate = $token->expires_at;
                $isExpired = Carbon::now()->greaterThan($expirationDate);
                if (!$isExpired) {
                    return $next($request);
                }
            }
        }

        return redirect()->route('admin.login');
    }
}
