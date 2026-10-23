@extends('layouts.app')

@section('title', 'Beranda — ' . ($profile['name'] ?? 'SMP Negeri 2 Juwangi'))
@section('meta_description', 'Selamat datang di website resmi SMP Negeri 2 Juwangi, Boyolali. Informasi pendidikan, PPDB, berita sekolah, prestasi siswa, dan sambutan kepala sekolah.')

@section('content')

    <!-- 1. Running Announcement Bar -->
    @if(!empty($announcements) && count($announcements) > 0)
    <div class="bg-gradient-to-r from-amber-500 via-amber-400 to-amber-500 text-blue-950 px-4 py-2.5 shadow-xs border-b border-amber-600/20">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-3 text-xs sm:text-sm font-semibold">
            <div class="flex items-center gap-2 overflow-hidden">
                <span class="inline-flex items-center gap-1 bg-blue-950 text-amber-300 px-2 py-0.5 rounded text-[11px] font-bold shrink-0 uppercase tracking-wider">
                    <svg class="w-3 h-3 text-amber-300 animate-pulse" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/></svg>
                    PENGUMUMAN
                </span>
                <span class="truncate text-blue-950">
                    <strong>{{ $announcements[0]['title'] ?? '' }}:</strong>
                    {{ Str::limit($announcements[0]['content'] ?? '', 110) }}
                </span>
            </div>
            <a href="{{ route('pengumuman.show', $announcements[0]['id']) }}" class="shrink-0 text-blue-950 underline hover:text-blue-900 text-xs font-bold">
                Detail →
            </a>
        </div>
    </div>
    @endif

    <!-- 2. Hero Section (Identitas & Foto Utama) -->
    <section class="relative bg-gradient-to-br from-blue-950 via-slate-900 to-blue-900 text-white overflow-hidden py-16 lg:py-24">
        <!-- Background Decorative Orbs -->
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Text Content -->
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-800/60 border border-blue-700/50 text-blue-200 text-xs font-semibold backdrop-blur-md">
                        <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                        <span>Portal Resmi Pendidikan • Terakreditasi A</span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white leading-tight">
                        Membangun Generasi <br class="hidden sm:inline">
                        <span class="bg-gradient-to-r from-amber-300 via-amber-200 to-yellow-400 bg-clip-text text-transparent">
                            Cerdas & Berkarakter
                        </span>
                    </h1>

                    <p class="text-base sm:text-lg text-slate-300 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        Selamat datang di <strong class="text-white">{{ $profile['name'] ?? 'SMP Negeri 2 Juwangi' }}</strong>. Kami mendidik dengan ketulusan hati, mengintegrasikan kurikulum inovatif, pembiasaan religius, dan kemandirian teknologi demi masa depan cemerlang putra-putri bangsa.
                    </p>

                    <!-- Call To Actions -->
                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                        <a href="{{ route('ppdb') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-7 py-3.5 rounded-xl font-bold text-sm bg-gradient-to-r from-amber-400 to-amber-500 text-blue-950 shadow-lg shadow-amber-400/20 hover:from-amber-300 hover:to-amber-400 hover:shadow-xl hover:shadow-amber-400/30 transition-all transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 text-blue-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Daftar PPDB 2026/2027
                        </a>
                        <a href="{{ route('profil.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl font-semibold text-sm bg-slate-800/80 hover:bg-slate-700/80 text-white border border-slate-700 transition-all">
                            <span>Tentang Sekolah</span>
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>

                    <!-- Quick Information Badges -->
                    <div class="pt-4 flex items-center justify-center lg:justify-start gap-6 text-xs text-slate-400">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Kurikulum Merdeka</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Sekolah Ramah Anak</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Berwawasan Lingkungan</span>
                        </div>
                    </div>
                </div>

                <!-- Visual Card / School Emblem Hero Display -->
                <div class="lg:col-span-5">
                    <div class="relative mx-auto max-w-md lg:max-w-none">
                        <!-- Card Border Glow -->
                        <div class="absolute -inset-1.5 bg-gradient-to-r from-blue-600 via-amber-500 to-blue-500 rounded-3xl blur-lg opacity-40"></div>
                        
                        <div class="relative bg-slate-900/90 border border-slate-800 rounded-2xl p-6 sm:p-8 backdrop-blur-xl shadow-2xl space-y-6">
                            <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-blue-600/30 border border-blue-500/40 flex items-center justify-center text-amber-300">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-white text-base">Profil Singkat</h3>
                                        <p class="text-xs text-slate-400">SMPN 2 Juwangi, Boyolali</p>
                                    </div>
                                </div>
                                <span class="bg-amber-400/20 text-amber-300 text-xs font-bold px-2.5 py-1 rounded-full border border-amber-400/30">
                                    NPSN {{ $profile['npsn'] ?? '20308482' }}
                                </span>
                            </div>

                            <!-- Visi Mini -->
                            <div class="space-y-2 bg-slate-800/50 p-4 rounded-xl border border-slate-800">
                                <span class="text-xs font-bold uppercase tracking-wider text-amber-400 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    Visi Utama
                                </span>
                                <p class="text-xs sm:text-sm text-slate-200 italic leading-relaxed">
                                    "{{ $profile['vision'] ?? 'Terwujudnya Peserta Didik yang Berakhlak Mulia, Cerdas, Terampil, Mandiri, dan Berbudaya Lingkungan.' }}"
                                </p>
                            </div>

                            <!-- Quick Fast Stats Grid (Dynamic from Database) -->
                            <div class="grid grid-cols-2 gap-3 pt-1">
                                <div class="bg-blue-950/60 p-3 rounded-xl border border-blue-900/40 text-center">
                                    <span class="block text-2xl font-extrabold text-amber-400">
                                        {{ ($stats['total_teachers'] ?? 0) + ($stats['total_staff'] ?? 0) }}
                                    </span>
                                    <span class="text-xs text-slate-300 font-medium">Pendidik & Tendik</span>
                                </div>
                                <div class="bg-blue-950/60 p-3 rounded-xl border border-blue-900/40 text-center">
                                    <span class="block text-2xl font-extrabold text-white">
                                        {{ $stats['total_fasilitas'] ?? 0 }}
                                    </span>
                                    <span class="text-xs text-slate-300 font-medium">Fasilitas Utama</span>
                                </div>
                                <div class="bg-blue-950/60 p-3 rounded-xl border border-blue-900/40 text-center">
                                    <span class="block text-2xl font-extrabold text-white">
                                        {{ $stats['total_ekskul'] ?? 0 }}
                                    </span>
                                    <span class="text-xs text-slate-300 font-medium">Ekstrakurikuler</span>
                                </div>
                                <div class="bg-blue-950/60 p-3 rounded-xl border border-blue-900/40 text-center">
                                    <span class="block text-2xl font-extrabold text-emerald-400">
                                        {{ $profile['accreditation'] ?? 'A' }}
                                    </span>
                                    <span class="text-xs text-slate-300 font-medium">Akreditasi BAN-S/M</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Sambutan Singkat Kepala Sekolah -->
    <section class="py-16 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-slate-50 via-blue-50/40 to-slate-50 rounded-3xl p-8 sm:p-12 border border-blue-100 shadow-sm">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                    <!-- Photo & Badge -->
                    <div class="lg:col-span-4 text-center">
                        <div class="relative inline-block">
                            <!-- Background decoration -->
                            <div class="w-48 h-48 sm:w-56 sm:h-56 rounded-2xl bg-gradient-to-tr from-blue-900 to-amber-400 p-1.5 shadow-xl">
                                <div class="w-full h-full rounded-2xl bg-slate-100 overflow-hidden flex items-center justify-center text-slate-400">
                                    @if(!empty($profile['principal_photo']))
                                        <img src="{{ \App\Services\ApiClient::assetUrl($profile['principal_photo']) }}" alt="{{ $profile['principal_name'] ?? 'Kepala Sekolah' }}" class="w-full h-full object-cover">
                                    @else
                                        <!-- Fallback logo/crest if photo not uploaded to avoid fabricating faces -->
                                        <div class="flex flex-col items-center justify-center p-4 text-center">
                                            <div class="w-16 h-16 rounded-2xl bg-blue-900 text-amber-300 flex items-center justify-center font-extrabold text-lg shadow-sm mb-2">
                                                SMPN 2
                                            </div>
                                            <span class="text-xs font-bold text-slate-700">Pimpinan Sekolah</span>
                                            <span class="text-[10px] text-slate-400">SMPN 2 Juwangi</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <span class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 bg-blue-950 text-amber-300 text-xs font-bold px-4 py-1.5 rounded-full shadow-md whitespace-nowrap border border-blue-800">
                                Kepala Sekolah
                            </span>
                        </div>
                        <div class="mt-6">
                            <h3 class="text-lg font-bold text-slate-900">{{ $profile['principal_name'] ?? 'Kepala SMP Negeri 2 Juwangi' }}</h3>
                            @if(!empty($profile['principal_nip']) && $profile['principal_nip'] !== '-')
                                <p class="text-xs text-slate-500 font-medium mt-0.5">NIP: {{ $profile['principal_nip'] }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Sambutan Body -->
                    <div class="lg:col-span-8 space-y-4">
                        <div class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-700 uppercase tracking-widest bg-blue-100/70 px-3 py-1 rounded-full">
                            <span>Sambutan Pimpinan</span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                            Mewujudkan Ekosistem Pendidikan yang Humanis, Berkarakter & Adaptif
                        </h2>
                        <div class="relative">
                            <svg class="absolute -top-2 -left-3 w-8 h-8 text-blue-200/60 -z-0" fill="currentColor" viewBox="0 0 32 32"><path d="M10 8v8H6c0 3.31 2.69 6 6 6v2c-4.41 0-8-3.59-8-8V8h6zm16 0v8h-4c0 3.31 2.69 6 6 6v2c-4.41 0-8-3.59-8-8V8h6z"/></svg>
                            <p class="text-slate-600 text-sm sm:text-base leading-relaxed relative z-10 pl-4">
                                {{ Str::limit($profile['principal_message'] ?? 'Puji syukur kita panjatkan ke hadirat Allah SWT atas karunia-Nya. Di era digital ini, kami terus berinovasi mewujudkan generasi cerdas berakhlak mulia.', 380) }}
                            </p>
                        </div>
                        <div class="pt-2">
                            <a href="{{ route('profil.sambutan') }}" class="inline-flex items-center gap-2 text-sm font-bold text-blue-700 hover:text-blue-900 transition-colors">
                                <span>Baca Sambutan Lengkap Selengkapnya</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Berita Terbaru Section (Sub-Fitur Berita Terbaru) -->
    <section class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-10 gap-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-700 bg-blue-100/60 px-3 py-1 rounded-full">
                        Informasi Terkini
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2 tracking-tight">
                        Kabar & Berita Sekolah
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">
                        Ikuti liputan kegiatan, pengumuman hasil belajar, dan prestasi civitas akademika.
                    </p>
                </div>
                <a href="{{ route('berita.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-blue-700 hover:text-blue-900 transition-colors shrink-0">
                    <span>Lihat Semua Berita</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

            <!-- News Grid -->
            @if(!empty($news) && count($news) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($news as $post)
                <article class="bg-white rounded-2xl overflow-hidden border border-slate-200/90 shadow-sm hover:shadow-xl hover:border-blue-300 transition-all duration-300 flex flex-col group">
                    <!-- Image / Header -->
                    <div class="relative h-48 bg-gradient-to-tr from-slate-800 to-blue-900 overflow-hidden flex items-center justify-center">
                        @if(!empty($post['cover_image']))
                            <img src="{{ \App\Services\ApiClient::assetUrl($post['cover_image']) }}" alt="{{ $post['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                        @else
                            <div class="text-center p-4">
                                <svg class="w-12 h-12 text-blue-400/50 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                <span class="text-[11px] text-blue-200/70 font-semibold block mt-1">SMPN 2 Juwangi</span>
                            </div>
                        @endif
                        <span class="absolute top-3 left-3 bg-blue-900/90 text-amber-300 text-[11px] font-bold px-2.5 py-1 rounded-md backdrop-blur-md shadow-sm">
                            {{ $post['category_name'] ?? 'Berita' }}
                        </span>
                    </div>

                    <!-- Body -->
                    <div class="p-5 flex flex-col flex-grow justify-between space-y-3">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 text-xs text-slate-400">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>{{ !empty($post['published_at']) ? date('d M Y', strtotime($post['published_at'])) : date('d M Y') }}</span>
                            </div>
                            <h3 class="font-bold text-slate-900 text-base leading-snug group-hover:text-blue-700 transition-colors line-clamp-2">
                                <a href="{{ route('berita.show', $post['slug']) }}">
                                    {{ $post['title'] }}
                                </a>
                            </h3>
                            <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                                {{ $post['excerpt'] ?? strip_tags($post['content'] ?? '') }}
                            </p>
                        </div>

                        <div class="pt-2 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-[11px] text-slate-400 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                {{ $post['views_count'] ?? 0 }} baca
                            </span>
                            <a href="{{ route('berita.show', $post['slug']) }}" class="text-xs font-bold text-blue-700 hover:text-blue-900 inline-flex items-center gap-1">
                                Baca →
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
            @else
            <div class="bg-white p-8 rounded-2xl text-center text-slate-500 border border-slate-200">
                <p>Belum ada berita yang dipublikasikan saat ini.</p>
            </div>
            @endif
        </div>
    </section>

    <!-- 5. Agenda & Pengumuman Penting (Two-column Grid) -->
    <section class="py-16 bg-white border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Left: Agenda Kegiatan -->
                <div>
                    <div class="flex items-center justify-between mb-6 pb-3 border-b border-slate-200">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-extrabold text-slate-900">Agenda Kegiatan</h3>
                                <p class="text-xs text-slate-500">Jadwal agenda & aktivitas mendatang</p>
                            </div>
                        </div>
                        <a href="{{ route('agenda.index') }}" class="text-xs font-bold text-blue-600 hover:underline">
                            Lihat Semua &rarr;
                        </a>
                    </div>

                    <div class="space-y-4">
                        @forelse($agendas as $agenda)
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-blue-300 hover:bg-blue-50/30 transition-all flex items-start gap-4">
                            <!-- Date badge -->
                            <div class="shrink-0 w-16 h-16 rounded-xl bg-blue-900 text-white flex flex-col items-center justify-center shadow-sm">
                                <span class="text-xs font-semibold uppercase text-amber-300">
                                    {{ !empty($agenda['start_at']) ? date('M', strtotime($agenda['start_at'])) : 'AKTIF' }}
                                </span>
                                <span class="text-xl font-extrabold leading-none mt-0.5">
                                    {{ !empty($agenda['start_at']) ? date('d', strtotime($agenda['start_at'])) : date('d') }}
                                </span>
                            </div>
                            <!-- Detail -->
                            <div class="space-y-1">
                                <h4 class="font-bold text-slate-900 text-sm sm:text-base leading-snug">
                                    {{ $agenda['title'] }}
                                </h4>
                                <p class="text-xs text-slate-500 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $agenda['location'] ?? 'SMPN 2 Juwangi' }}
                                </p>
                                <p class="text-xs text-slate-600 line-clamp-2 pt-1 leading-relaxed">
                                    {{ $agenda['description'] ?? 'Silakan ikuti agenda kegiatan sesuai dengan jadwal yang telah ditetapkan.' }}
                                </p>
                            </div>
                        </div>
                        @empty
                        <div class="p-6 text-center text-slate-500 bg-slate-50 rounded-2xl border border-slate-200">
                            Tidak ada agenda kegiatan terdekat saat ini.
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Right: Pengumuman Resmi -->
                <div>
                    <div class="flex items-center justify-between mb-6 pb-3 border-b border-slate-200">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-extrabold text-slate-900">Pengumuman Penting</h3>
                                <p class="text-xs text-slate-500">Pemberitahuan resmi sekolah</p>
                            </div>
                        </div>
                        <a href="{{ route('pengumuman.index') }}" class="text-xs font-bold text-amber-600 hover:underline">
                            Lihat Semua &rarr;
                        </a>
                    </div>

                    <div class="space-y-4">
                        @forelse($announcements as $ann)
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-amber-300 transition-all space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] font-bold text-slate-500 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ !empty($ann['published_at']) ? date('d M Y', strtotime($ann['published_at'])) : date('d M Y') }}
                                </span>
                                @if(($ann['priority'] ?? 0) > 0)
                                <span class="bg-red-100 text-red-700 text-[10px] font-extrabold px-2 py-0.5 rounded-full uppercase tracking-wider">
                                    PENTING
                                </span>
                                @endif
                            </div>
                            <h4 class="font-bold text-slate-900 text-sm sm:text-base leading-snug">
                                {{ $ann['title'] }}
                            </h4>
                            <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed">
                                {{ $ann['content'] }}
                            </p>
                        </div>
                        @empty
                        <div class="p-6 text-center text-slate-500 bg-slate-50 rounded-2xl border border-slate-200">
                            Tidak ada pengumuman baru.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. Prestasi Siswa Terkini Section -->
    @if(!empty($achievements) && count($achievements) > 0)
    <section class="py-16 bg-gradient-to-b from-slate-50 to-blue-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12 space-y-2">
                <span class="text-xs font-bold uppercase tracking-wider text-amber-600 bg-amber-100/70 px-3 py-1 rounded-full">
                    Kebanggaan Sekolah
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Prestasi Gemilang Siswa
                </h2>
                <p class="text-sm text-slate-500">
                    Dedikasi, bakat, dan kerja keras yang mengharumkan nama SMP Negeri 2 Juwangi di berbagai kompetisi.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($achievements as $ach)
                <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm hover:shadow-lg transition-all space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-1 rounded-full {{ ($ach['medal'] ?? '') === 'emas' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-800' }}">
                            🏆 {{ strtoupper($ach['medal'] ?? 'JUARA') }}
                        </span>
                        <span class="text-xs font-semibold text-slate-400">Tahun {{ $ach['year'] ?? date('Y') }}</span>
                    </div>
                    <h3 class="font-extrabold text-slate-900 text-base leading-snug">
                        {{ $ach['title'] }}
                    </h3>
                    <p class="text-xs text-blue-700 font-semibold">
                        Oleh: {{ $ach['student_name'] ?? 'Siswa Berprestasi' }}
                    </p>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        {{ $ach['description'] ?? 'Tingkat ' . ucfirst($ach['level'] ?? 'Kabupaten') }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- 7. Call To Action (PPDB Online) -->
    <section class="py-14 bg-gradient-to-r from-blue-900 via-blue-950 to-slate-900 text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-4">
            <span class="bg-amber-400 text-blue-950 text-xs font-extrabold px-3.5 py-1 rounded-full uppercase tracking-wider">
                Penerimaan Peserta Didik Baru
            </span>
            <h2 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight">
                Siap Menjadi Bagian dari SMP Negeri 2 Juwangi?
            </h2>
            <p class="text-slate-300 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                Pendaftaran siswa baru tahun ajaran 2026/2027 telah dibuka melalui jalur Zonasi, Afirmasi, Prestasi, dan Perpindahan Tugas. Dapatkan pendidikan bermutu tanpa diskriminasi.
            </p>
            <div class="pt-4 flex flex-wrap justify-center gap-4">
                <a href="{{ route('ppdb') }}" class="px-8 py-3.5 rounded-xl font-bold text-sm bg-gradient-to-r from-amber-400 to-amber-500 text-blue-950 shadow-lg hover:from-amber-300 hover:to-amber-400 transition-all transform hover:-translate-y-0.5">
                    Informasi & Syarat Pendaftaran PPDB
                </a>
                <a href="{{ route('kontak') }}" class="px-7 py-3.5 rounded-xl font-semibold text-sm bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 transition-all">
                    Hubungi Panitia PPDB
                </a>
            </div>
        </div>
    </section>

@endsection
