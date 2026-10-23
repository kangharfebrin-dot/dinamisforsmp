<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin — SMP Negeri 2 Juwangi</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-100 min-h-screen text-slate-800 flex flex-col">

    <!-- Top Admin Header -->
    <header class="bg-blue-950 text-white px-6 py-4 flex items-center justify-between shadow-md">
        <div class="flex items-center gap-3">
            <span class="font-extrabold text-lg text-white">SMPN 2 Juwangi</span>
            <span class="bg-amber-400 text-blue-950 text-[10px] font-bold px-2 py-0.5 rounded uppercase">Dashboard</span>
        </div>
        <div class="flex items-center gap-4 text-xs">
            <span class="text-slate-300">Halo, <strong>{{ $user['name'] ?? 'Admin' }}</strong> ({{ strtoupper($user['role'] ?? 'ADMIN') }})</span>
            <a href="{{ route('home') }}" target="_blank" class="text-amber-300 hover:text-amber-200">Lihat Web Publik ↗</a>
            <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                @csrf
                <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-600/80 hover:bg-red-600 text-white font-bold text-xs transition-colors">
                    Keluar
                </button>
            </form>
        </div>
    </header>

    <!-- Main Dashboard Container -->
    <main class="flex-grow max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold">
            {{ session('success') }}
        </div>
        @endif

        <!-- Quick Summary Stats Grid -->
        <div>
            <h2 class="text-lg font-bold text-slate-900 mb-4">Ringkasan Modul Konten</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
                    <span class="text-xs font-bold text-slate-400 uppercase">Total Berita</span>
                    <span class="block text-2xl font-extrabold text-blue-900 mt-1">{{ $summary['counts']['posts'] ?? 0 }}</span>
                    <span class="text-[11px] text-emerald-600 font-semibold">Published</span>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
                    <span class="text-xs font-bold text-slate-400 uppercase">Draft Berita</span>
                    <span class="block text-2xl font-extrabold text-amber-600 mt-1">{{ $summary['counts']['drafts'] ?? 0 }}</span>
                    <span class="text-[11px] text-slate-400">Belum terbit</span>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
                    <span class="text-xs font-bold text-slate-400 uppercase">Pengumuman</span>
                    <span class="block text-2xl font-extrabold text-slate-900 mt-1">{{ $summary['counts']['announcements'] ?? 0 }}</span>
                    <span class="text-[11px] text-blue-600 font-semibold">Aktif</span>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
                    <span class="text-xs font-bold text-slate-400 uppercase">Agenda</span>
                    <span class="block text-2xl font-extrabold text-slate-900 mt-1">{{ $summary['counts']['agendas'] ?? 0 }}</span>
                    <span class="text-[11px] text-slate-500">Kegiatan</span>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
                    <span class="text-xs font-bold text-slate-400 uppercase">Guru & Staf</span>
                    <span class="block text-2xl font-extrabold text-slate-900 mt-1">{{ $summary['counts']['teachers'] ?? 0 }}</span>
                    <span class="text-[11px] text-slate-500">Terdaftar</span>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
                    <span class="text-xs font-bold text-slate-400 uppercase">Prestasi</span>
                    <span class="block text-2xl font-extrabold text-amber-500 mt-1">{{ $summary['counts']['achievements'] ?? 0 }}</span>
                    <span class="text-[11px] text-slate-500">Tercatat</span>
                </div>
            </div>
        </div>

        <!-- Recent Posts List -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-4">
            <h3 class="text-base font-extrabold text-slate-900">Postingan Berita Terakhir</h3>
            <div class="divide-y divide-slate-100">
                @forelse($summary['recentPosts'] ?? [] as $post)
                <div class="py-3 flex items-center justify-between gap-4">
                    <div>
                        <span class="text-xs font-semibold text-blue-700 bg-blue-50 px-2 py-0.5 rounded">{{ $post['category_name'] ?? 'Umum' }}</span>
                        <h4 class="font-bold text-slate-900 text-sm mt-1">{{ $post['title'] }}</h4>
                        <span class="text-[11px] text-slate-400">{{ $post['created_at'] ?? '' }}</span>
                    </div>
                    <span class="shrink-0 px-2.5 py-1 text-xs font-bold rounded-full {{ ($post['status'] ?? '') === 'published' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                        {{ strtoupper($post['status'] ?? 'draft') }}
                    </span>
                </div>
                @empty
                <p class="text-xs text-slate-500 py-4">Belum ada postingan berita.</p>
                @endforelse
            </div>
        </div>
    </main>

</body>
</html>
