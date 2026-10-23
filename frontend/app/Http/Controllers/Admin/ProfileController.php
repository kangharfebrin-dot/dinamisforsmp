<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiClient;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit(ApiClient $api)
    {
        $token = session('api_token');
        $profile = $api->get('admin/profile', [], $token)->json('data') ?? [];
        return view('admin.profile.edit', compact('profile'));
    }

    public function update(Request $request, ApiClient $api)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'npsn' => 'required|string|max:20',
            'tagline' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'principal_name' => 'nullable|string|max:150',
            'principal_nip' => 'nullable|string|max:50',
            'principal_message' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'history' => 'nullable|string',
            'maps_url' => 'nullable|string',
            'facebook' => 'nullable|string|max:150',
            'instagram' => 'nullable|string|max:150',
            'youtube' => 'nullable|string|max:150',
            'logo' => 'nullable|image|max:2048',
            'hero_banner' => 'nullable|image|max:5120',
            'principal_photo' => 'nullable|image|max:3072',
        ]);

        $token = session('api_token');
        $hasFiles = $request->hasFile('logo') || $request->hasFile('hero_banner') || $request->hasFile('principal_photo');
        $data = $request->except(['logo', 'hero_banner', 'principal_photo']);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo');
        }
        if ($request->hasFile('hero_banner')) {
            $data['hero_banner'] = $request->file('hero_banner');
        }
        if ($request->hasFile('principal_photo')) {
            $data['principal_photo'] = $request->file('principal_photo');
        }

        $res = $api->put('admin/profile', $data, $token, $hasFiles);

        if (!$res->successful() || !$res->json('success')) {
            return back()->withInput()->with('error', $res->json('message') ?? 'Gagal memperbarui profil sekolah.');
        }

        return redirect()->route('admin.profil.edit')->with('success', 'Identitas dan profil sekolah berhasil diperbarui.');
    }
}
