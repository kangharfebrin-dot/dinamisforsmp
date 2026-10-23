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
            'address' => 'Jl. Kayen Baru No. 1, Desa Kayen, Kec. Juwangi, Kab. Boyolali, Jawa Tengah 57391',
            'phone' => '085642696466',
            'email' => 'smpn2juwang@gmail.com',
            'accreditation' => 'A',
            'principal_name' => 'Kepala SMP Negeri 2 Juwangi',
            'principal_nip' => '-',
            'principal_message' => 'Selamat datang di portal informasi resmi SMP Negeri 2 Juwangi, Boyolali. Kami berkomitmen menyelenggarakan ekosistem pendidikan yang humanis, berkarakter, dan berdaya saing bagi seluruh generasi bangsa.',
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
