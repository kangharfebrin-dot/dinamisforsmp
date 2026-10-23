<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;

class PpdbController extends Controller
{
    public function index(ApiClient $api)
    {
        $profile = $api->get('profile')->json('data') ?? [];
        $announcements = $api->get('announcements')->json('data') ?? [];
        return view('ppdb.index', compact('profile', 'announcements'));
    }
}
