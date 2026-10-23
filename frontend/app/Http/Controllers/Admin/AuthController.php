<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiClient;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session('api_token')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request, ApiClient $api)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $response = $api->post('auth/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if (!$response->successful() || !$response->json('success')) {
            $msg = $response->json('message') ?? 'Login gagal. Periksa kembali email dan password Anda.';
            return back()->withErrors(['email' => $msg])->withInput($request->only('email'));
        }

        $data = $response->json();
        session([
            'api_token' => $data['token'],
            'admin_user' => $data['user'],
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Selamat datang kembali, ' . $data['user']['name']);
    }

    public function logout()
    {
        session()->forget(['api_token', 'admin_user']);
        session()->flush();
        return redirect()->route('admin.login')->with('info', 'Anda telah berhasil keluar.');
    }
}
