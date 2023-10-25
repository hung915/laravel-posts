<?php

namespace App\Http\Libs;

use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Carbon\Carbon;

trait Helpers
{
    protected function isUserLogin(Request $request): bool
    {
        $plainTextToken = $request->session()->get('user_access_token');
        if ($plainTextToken) {
            $token = PersonalAccessToken::findToken($plainTextToken);
            if ($token && $token->name === 'user-api-token') {
                $expirationDate = $token->expires_at;
                if (!Carbon::now()->greaterThan($expirationDate)) {
                    return true;
                }
            }
        }
        return false;
    }

    protected function isAdminLogin(Request $request): bool
    {
        $plainTextToken = $request->session()->get('admin_access_token');
        if ($plainTextToken) {
            $token = PersonalAccessToken::findToken($plainTextToken);
            if ($token && $token->name === 'admin-api-token') {
                $expirationDate = $token->expires_at;
                if (!Carbon::now()->greaterThan($expirationDate)) {
                    return true;
                }
            }
        }
        return false;
    }
}
