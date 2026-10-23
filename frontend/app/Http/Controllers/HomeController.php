<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(ApiClient $api)
    {
        $profile = $api->get('profile')->json('data') ?? [
            'name' => 'SMP Negeri 2 Juwangi',
            'npsn' => '20308482',
            'tagline' => 'Cerdas, Berkarakter, Berakhlak Mulia, dan Berprestasi',
            'address' => 'Jl. Raya Juwangi - Kedungombo Km. 2, Juwangi, Boyolali, Jawa Tengah 57391',
            'phone' => '(0298) 610023',
            'email' => 'info@smpn2juwangi.sch.id',
            'principal_name' => 'Drs. H. Mulyono, M.Pd.',
            'principal_nip' => '19680512 199403 1 005',
            'principal_message' => 'Selamat datang di portal resmi SMP Negeri 2 Juwangi. Kami berkomitmen untuk menyelenggarakan pendidikan holistik yang membina akhlak dan keunggulan masa depan.',
        ];

        $news = $api->get('news', ['limit' => 4, 'status' => 'published'])->json('data') ?? [];
        $announcements = $api->get('announcements', ['limit' => 3])->json('data') ?? [];
        $agendas = $api->get('agendas', ['limit' => 3])->json('data') ?? [];
        $stats = $api->get('stats')->json('data') ?? [];
        $achievements = $api->get('achievements', ['limit' => 3])->json('data') ?? [];
        $extracurriculars = $api->get('extracurriculars')->json('data') ?? [];
        $facilities = $api->get('facilities')->json('data') ?? [];
        $galleries = $api->get('galleries')->json('data') ?? [];

        return view('home', compact(
            'profile',
            'news',
            'announcements',
            'agendas',
            'stats',
            'achievements',
            'extracurriculars',
            'facilities',
            'galleries'
        ));
    }
}
