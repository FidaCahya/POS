<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        // Check if the user is already logged in
        if (Auth::check()) {
            return redirect ('/');
        }
        return view ('auth.login');
    }

    public function postLogin(Request $request)
    {
        // Check if the request is an AJAX or JSON request
        if ($request->ajax() || $request->wantsJson()) {
            $credentials = $request->only('username', 'password');

            // Attempt to log in with the provided credentials
            if (Auth::attempt($credentials)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login Berhasil',
                    'redirect' => url('/')
                ]);
            }

            // If authentication fails
            return response()->json([
                'status' => false,
                'message' => 'Login Gagal'
            ]);
        }

        // Fallback for non-AJAX requests
        return redirect('login');
        
    }

    public function logout(Request $request)
    {
        // Log the user out and invalidate the session
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('login');
    }
}
