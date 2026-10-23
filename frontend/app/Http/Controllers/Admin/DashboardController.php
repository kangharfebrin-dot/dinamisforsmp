<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiClient;

class DashboardController extends Controller
{
    public function index(ApiClient $api)
    {
        $token = session('api_token');
        $response = $api->get('admin/dashboard-summary', [], $token);
        $summary = $response->json('data') ?? [
            'counts' => ['posts' => 0, 'drafts' => 0, 'announcements' => 0, 'agendas' => 0, 'teachers' => 0, 'achievements' => 0],
            'recentPosts' => [],
        ];

        $user = session('admin_user');
        return view('admin.dashboard', compact('summary', 'user'));
    }
}
