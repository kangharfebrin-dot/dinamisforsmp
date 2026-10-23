<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(ApiClient $api)
    {
        $profile = $api->get('profile')->json('data') ?? [];
        return view('kontak.index', compact('profile'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'subject' => 'required|string|max:200',
            'message' => 'required|string',
        ]);

        return back()->with('success', 'Pesan Anda telah berhasil terkirim ke pihak sekolah. Terima kasih telah menghubungi kami.');
    }
}
