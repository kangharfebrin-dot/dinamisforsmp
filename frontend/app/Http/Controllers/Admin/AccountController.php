<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiClient;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index(ApiClient $api)
    {
        $token = session('api_token');
        $user = $api->get('auth/me', [], $token)->json('data') ?? session('admin_user', []);
        return view('admin.account.index', compact('user'));
    }

    public function updateProfile(Request $request, ApiClient $api)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
        ]);

        $token = session('api_token');
        $res = $api->put('auth/profile', $request->only(['name', 'email']), $token);

        if (!$res->successful() || !$res->json('success')) {
            return back()->withInput()->with('error', $res->json('message') ?? 'Gagal memperbarui profil.');
        }

        // Update session user
        $sessionUser = session('admin_user', []);
        $sessionUser['name'] = $request->name;
        $sessionUser['email'] = $request->email;
        session(['admin_user' => $sessionUser]);

        return back()->with('success', 'Profil akun admin berhasil diperbarui.');
    }

    public function changePassword(Request $request, ApiClient $api)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $token = session('api_token');
        $res = $api->put('auth/change-password', [
            'current_password' => $request->current_password,
            'new_password' => $request->new_password,
            'new_password_confirmation' => $request->new_password_confirmation,
        ], $token);

        if (!$res->successful() || !$res->json('success')) {
            return back()->with('error', $res->json('message') ?? 'Gagal mengubah kata sandi.');
        }

        return back()->with('success', 'Kata sandi akun admin berhasil diperbarui.');
    }
}
