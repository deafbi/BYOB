<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin');
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $user = User::where('username', $username)->first();

        if ($user && Hash::check($password . env('PASSWORD_SALT'), $user->password)) {
            // Save user in session
            Session::put('admin_authenticated', true);
            return redirect()->route('admin-dashboard');
        } else {
            $response = '<p style="color: red;">Invalid username or password.</p>';
            return view('admin', ['response' => $response]);
        }
    }
}
