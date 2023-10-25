<?php


namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Http\Libs\Helpers;

class AuthController extends Controller
{
    use Helpers;

    public function viewLogin(Request $request)
    {
        $isLogin = $this->isUserLogin($request);
        if ($isLogin) {
            return redirect()->route('homepage');
        } else {
            return view('user.login');
        }
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $req = Request::create('/api/login', 'POST', [], [], [], [], json_encode($data));
        $req->headers->add([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]);
        $homeUrl = route('homepage');

        $res = app()->handle($req);

        $res_content = json_decode($res->getContent());

        if ($res->getStatusCode() == 200) {
            session(['user_access_token' => $res_content->token]);
            return redirect($homeUrl);
        } else {
            return back()->withErrors([
                'input' => $res_content->message,
            ]);
        }
    }

    public function logout(Request $request)
    {
        $authToken = session( 'user_access_token');
        $req = Request::create('/api/logout', 'POST');
        $home_url = route('homepage');
        $req->headers->add([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $authToken,
        ]);

        $res = app()->handle($req);

        if ($res->getStatusCode() == 200) {
            $request->session()->forget('user_access_token');
            return redirect($home_url);
        } else {
            return [];
        }
    }

    public function viewRegister(Request $request)
    {
        return view('user.register');
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $req = Request::create('/api/register', 'POST', [], [], [], [], json_encode($data));
        $req->headers->add([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]);
        $homeUrl = route('homepage');

        $res = app()->handle($req);

        $res_content = json_decode($res->getContent());
        if ($res->getStatusCode() == 200) {
            return redirect($homeUrl)->with('success', $res_content->message);
        } else {
            return back()->withErrors([
                'input' => $res_content->message,
            ]);
        }
    }
}
