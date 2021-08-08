<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login.login');
    }

    public function loginPost(Request $request)
    {
        $e = $request->only('admin', 'password');
        if (Auth::guard('admin')->attempt($e)) {
            return redirect()->route('admin.home');
        } else {
            return redirect()->route('admin.login')->with('msg', 'Login information is incorrect!');
        }
    }
}
