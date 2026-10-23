<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;

class PpdbController extends Controller
{
    public function index(ApiClient $api)
    {
        $profile = $api->get('profile')->json('data') ?? [];
        $announcements = $api->get('announcements', ['status' => 'published'])->json('data') ?? [];
        $page = $api->get('pages/ppdb-info')->json('data') ?? null;

        return view('ppdb.index', compact('profile', 'announcements', 'page'));
    }
}
