<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function index(Request $request, ApiClient $api)
    {
        $profile = $api->get('profile')->json('data') ?? [];
        $achievements = $api->get('achievements')->json('data') ?? [];

        return view('achievements.index', compact('profile', 'achievements'));
    }
}
