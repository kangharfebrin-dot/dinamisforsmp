<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index(Request $request, ApiClient $api)
    {
        $profile = $api->get('profile')->json('data') ?? [];
        $announcements = $api->get('announcements', ['status' => 'published'])->json('data') ?? [];

        return view('announcements.index', compact('profile', 'announcements'));
    }

    public function show($id, ApiClient $api)
    {
        $profile = $api->get('profile')->json('data') ?? [];
        $announcement = $api->get("announcements/{$id}")->json('data');

        if (!$announcement) {
            abort(404, 'Pengumuman tidak ditemukan.');
        }

        return view('announcements.show', compact('profile', 'announcement'));
    }
}
