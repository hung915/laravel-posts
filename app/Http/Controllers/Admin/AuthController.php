<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Http\Libs\Helpers;

class AuthController
{
    use Helpers;

    public function viewLogin(Request $request)
    {
        $isLogin = $this->isAdminLogin($request);
        if ($isLogin) {
            return redirect()->route('admin-dashboard');
        } else {
            return view('admin.login');
        }
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $req = Request::create('/api/admin/login', 'POST', [], [], [], [], json_encode($data));
        $req->headers->add([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]);
        $homeUrl = route('admin-dashboard');

        $res = app()->handle($req);

        $res_content = json_decode($res->getContent());

        if ($res->getStatusCode() == 200) {
            session(['admin_access_token' => $res_content->token]);
            return redirect($homeUrl);
        } else {
            return back()->withErrors([
                'input' => $res_content->message,
            ]);
        }
    }

    public function logout(Request $request)
    {
        $authToken = session( 'admin_access_token');
        $req = Request::create('/api/admin/logout', 'POST');
        $home_url = route('admin-dashboard');
        $req->headers->add([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $authToken,
        ]);

        $res = app()->handle($req);

        if ($res->getStatusCode() == 200) {
            $request->session()->forget('admin_access_token');
            return redirect($home_url);
        } else {
            return [];
        }
    }
}
