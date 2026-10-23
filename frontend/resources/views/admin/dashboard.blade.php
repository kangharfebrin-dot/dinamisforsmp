@extends('layouts.admin')

@section('title', 'Dashboard Ringkasan')
@section('page_title', 'Ringkasan Dashboard')
@section('page_subtitle', 'Selamat datang kembali, ' . session('admin_user.name', 'Administrator'))

@section('content')
<div class="space-y-8">

    <!-- Quick Action Shortcuts (PRD 8.3) -->
    <div class="bg-gradient-to-r from-blue-900 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-lg flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
        <div>
            <span class="bg-amber-400 text-slate-950 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Aksi Cepat Admin</span>
            <h2 class="text-xl sm:text-2xl font-extrabold mt-2">Kelola Konten & Informasi Sekolah</h2>
            <p class="text-slate-300 text-sm mt-1 max-w-xl">
                Publikasikan warta terbaru, pengumuman penting, atau perbarui profil sekolah untuk masyarakat dan peserta didik.
            </p>
        </div>
        <div class="flex flex-wrap gap-3 shrink-0">
            <a href="{{ route('admin.berita.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-bold text-sm shadow-md transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Berita
            </a>
            <a href="{{ route('admin.pengumuman.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-sm border border-white/20 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Pengumuman
            </a>
            <a href="{{ route('admin.agenda.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-sm border border-white/20 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Agenda
            </a>
        </div>
    </div>

    <!-- Stat Cards Grid (PRD 8.3) -->
    <div>
        <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider mb-4">Statistik Modul Konten Real-time</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            <!-- Berita Published -->
            <a href="{{ route('admin.berita.index') }}" class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:border-blue-300 hover:shadow-md transition-all block group">
                <div class="flex items-center justify-between text-slate-400 group-hover:text-blue-600">
                    <span class="text-[11px] font-bold uppercase tracking-wider">Berita Terbit</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
                <span class="block text-2xl font-extrabold text-blue-900 mt-2">{{ $summary['counts']['posts'] ?? 0 }}</span>
                <span class="text-[11px] text-emerald-600 font-semibold mt-1 block">Aktif di publik</span>
            </a>

            <!-- Draft Berita -->
            <a href="{{ route('admin.berita.index', ['status' => 'draft']) }}" class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:border-amber-300 hover:shadow-md transition-all block group">
                <div class="flex items-center justify-between text-slate-400 group-hover:text-amber-600">
                    <span class="text-[11px] font-bold uppercase tracking-wider">Draft Berita</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
                <span class="block text-2xl font-extrabold text-amber-600 mt-2">{{ $summary['counts']['drafts'] ?? 0 }}</span>
                <span class="text-[11px] text-slate-500 font-semibold mt-1 block">Belum diterbitkan</span>
            </a>

            <!-- Pengumuman -->
            <a href="{{ route('admin.pengumuman.index') }}" class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:border-blue-300 hover:shadow-md transition-all block group">
                <div class="flex items-center justify-between text-slate-400 group-hover:text-blue-600">
                    <span class="text-[11px] font-bold uppercase tracking-wider">Pengumuman</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                </div>
                <span class="block text-2xl font-extrabold text-slate-900 mt-2">{{ $summary['counts']['announcements'] ?? 0 }}</span>
                <span class="text-[11px] text-blue-600 font-semibold mt-1 block">Informasi</span>
            </a>

            <!-- Agenda Kegiatan -->
            <a href="{{ route('admin.agenda.index') }}" class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:border-blue-300 hover:shadow-md transition-all block group">
                <div class="flex items-center justify-between text-slate-400 group-hover:text-blue-600">
                    <span class="text-[11px] font-bold uppercase tracking-wider">Agenda</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <span class="block text-2xl font-extrabold text-slate-900 mt-2">{{ $summary['counts']['agendas'] ?? 0 }}</span>
                <span class="text-[11px] text-slate-500 font-semibold mt-1 block">Kalender kegiatan</span>
            </a>

            <!-- Guru & Staf -->
            <a href="{{ route('admin.guru.index') }}" class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:border-blue-300 hover:shadow-md transition-all block group">
                <div class="flex items-center justify-between text-slate-400 group-hover:text-blue-600">
                    <span class="text-[11px] font-bold uppercase tracking-wider">Guru & Staf</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <span class="block text-2xl font-extrabold text-slate-900 mt-2">{{ $summary['counts']['teachers'] ?? 0 }}</span>
                <span class="text-[11px] text-slate-500 font-semibold mt-1 block">Pendidik & Tendik</span>
            </a>

            <!-- Prestasi Siswa -->
            <a href="{{ route('admin.prestasi.index') }}" class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:border-amber-300 hover:shadow-md transition-all block group">
                <div class="flex items-center justify-between text-slate-400 group-hover:text-amber-600">
                    <span class="text-[11px] font-bold uppercase tracking-wider">Prestasi</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                </div>
                <span class="block text-2xl font-extrabold text-amber-500 mt-2">{{ $summary['counts']['achievements'] ?? 0 }}</span>
                <span class="text-[11px] text-slate-500 font-semibold mt-1 block">Kejuaraan tercatat</span>
            </a>
        </div>
    </div>

    <!-- Second Row: Recent Posts & Upcoming Agendas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Posts List -->
        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-xs space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-base font-extrabold text-slate-900">Postingan Berita Terbaru</h3>
                <a href="{{ route('admin.berita.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800">Lihat Semua →</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($summary['recentPosts'] ?? [] as $post)
                <div class="py-3 flex items-center justify-between gap-4">
                    <div class="min-w-0">
                        <span class="text-[11px] font-semibold text-blue-700 bg-blue-50 px-2 py-0.5 rounded">{{ $post['category_name'] ?? 'Umum' }}</span>
                        <h4 class="font-bold text-slate-900 text-sm mt-1 truncate">{{ $post['title'] }}</h4>
                        <span class="text-[11px] text-slate-400">{{ $post['created_at'] ?? '' }}</span>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <span class="px-2.5 py-0.5 text-[11px] font-bold rounded-full {{ ($post['status'] ?? '') === 'published' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                            {{ strtoupper($post['status'] ?? 'draft') }}
                        </span>
                        <a href="{{ route('admin.berita.edit', $post['id']) }}" class="p-1.5 text-slate-400 hover:text-blue-600 rounded-lg hover:bg-slate-50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </a>
                    </div>
                </div>
                @empty
                <p class="text-xs text-slate-400 py-4">Belum ada postingan berita.</p>
                @endforelse
            </div>
        </div>

        <!-- Upcoming Agendas -->
        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-xs space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-base font-extrabold text-slate-900">Agenda Kegiatan Mendatang</h3>
                <a href="{{ route('admin.agenda.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800">Lihat Semua →</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($summary['upcomingAgendas'] ?? [] as $agenda)
                <div class="py-3 flex items-center justify-between gap-4">
                    <div class="min-w-0">
                        <span class="text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded">{{ date('d M Y', strtotime($agenda['start_at'])) }}</span>
                        <h4 class="font-bold text-slate-900 text-sm mt-1 truncate">{{ $agenda['title'] }}</h4>
                        <span class="text-[11px] text-slate-400">{{ $agenda['location'] ?? 'Lokasi Sekolah' }}</span>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <a href="{{ route('admin.agenda.edit', $agenda['id']) }}" class="p-1.5 text-slate-400 hover:text-blue-600 rounded-lg hover:bg-slate-50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </a>
                    </div>
                </div>
                @empty
                <p class="text-xs text-slate-400 py-4">Belum ada agenda terdaftar.</p>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
