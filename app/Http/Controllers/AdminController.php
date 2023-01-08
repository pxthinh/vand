<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login()
    {
        $fail = false;
        return view('login-admin', compact('fail'));
    }
    public function store(LoginRequest $request)
    {
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('list-product-admin');
        } else {
            $fail = true;
            return view('login-admin', compact('fail'));
        }
    }
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login');
    }
}
