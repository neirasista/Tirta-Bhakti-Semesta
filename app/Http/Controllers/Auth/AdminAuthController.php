<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $admin = \App\Models\Admin::where('email', $credentials['email'])->first();

        if (!$admin || !\Illuminate\Support\Facades\Hash::check($credentials['password'], $admin->password)) {
            return back()->withErrors(['email' => 'Email atau password salah'])->withInput();
        }

        // Simpan session login manual
        session(['admin_id' => $admin->id]);

        // Redirect ke dashboard
        return redirect()->route('admin.dashboard');
    }


    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login');
    }

}
