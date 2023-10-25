<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Libs\Helpers;

class HomeController extends Controller
{
    use Helpers;

    public function indexForUser(Request $request)
    {
        $isLogin = $this->isUserLogin($request);
        return view('user.home', ['isLogin' => $isLogin]);
    }

    public function indexForAdmin(Request $request)
    {
        $isLogin = $this->isAdminLogin($request);
        return view('admin.home', ['isLogin' => $isLogin]);
    }
}
