<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SMP Negeri 2 Juwangi — Cerdas, Berkarakter & Berprestasi')</title>
    <meta name="description" content="@yield('meta_description', 'Website resmi SMP Negeri 2 Juwangi, Boyolali, Jawa Tengah. Informasi akademik, PPDB, berita sekolah, prestasi, dan profil guru.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased flex flex-col min-h-screen">

    <!-- Top Info Bar -->
    <div class="bg-slate-900 text-slate-300 text-xs py-2 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-4 flex-wrap justify-center sm:justify-start">
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Juwangi, Boyolali, Jawa Tengah
                </span>
                <span class="hidden md:inline text-slate-600">|</span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    {{ $profile['phone'] ?? '(0298) 610023' }}
                </span>
                <span class="hidden md:inline text-slate-600">|</span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    {{ $profile['email'] ?? 'info@smpn2juwangi.sch.id' }}
                </span>
            </div>
            <div class="flex items-center gap-3">
                <span class="bg-amber-400/20 text-amber-300 font-semibold px-2 py-0.5 rounded text-[11px] border border-amber-400/30">
                    NPSN: {{ $profile['npsn'] ?? '20308482' }}
                </span>
                <span class="bg-emerald-500/20 text-emerald-300 font-semibold px-2 py-0.5 rounded text-[11px] border border-emerald-500/30">
                    Terakreditasi A
                </span>
                <a href="{{ route('admin.login') }}" class="text-slate-400 hover:text-white transition-colors flex items-center gap-1 pl-2 border-l border-slate-700">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    Portal Admin
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-xs transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand Identity -->
                <a href="{{ route('home') }}" class="flex items-center gap-3.5 group">
                    @if(!empty($profile['logo']))
                    <img src="{{ \App\Services\ApiClient::assetUrl($profile['logo']) }}" alt="Logo" class="w-12 h-12 object-contain group-hover:scale-105 transition-transform">
                    @else
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-blue-900 to-blue-700 flex items-center justify-center text-white font-extrabold shadow-md shadow-blue-900/20 group-hover:scale-105 transition-transform">
                        <svg class="w-7 h-7 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    @endif
                    <div>
                        <span class="text-xl font-extrabold tracking-tight text-blue-950 block leading-tight group-hover:text-blue-700 transition-colors">
                            {{ $profile['name'] ?? 'SMP Negeri 2 Juwangi' }}
                        </span>
                        <span class="text-xs font-semibold text-amber-600 block tracking-wide">
                            {{ $profile['tagline'] ?? 'Cerdas, Berkarakter & Berprestasi' }}
                        </span>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <nav class="hidden xl:flex items-center gap-6 text-sm font-semibold text-slate-700">
                    <a href="{{ route('home') }}" class="transition-colors {{ request()->routeIs('home') ? 'text-blue-700 font-bold' : 'hover:text-blue-600' }}">
                        Beranda
                    </a>

                    <!-- Dropdown Profil -->
                    <div class="relative group">
                        <button class="flex items-center gap-1 hover:text-blue-600 transition-colors py-2 focus:outline-none {{ request()->routeIs('profil.*', 'guru.*', 'fasilitas.*') ? 'text-blue-700 font-bold' : '' }}">
                            <span>Profil</span>
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-600 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div class="absolute left-0 mt-1 w-56 bg-white rounded-xl shadow-xl border border-slate-100 py-2 opacity-0 translate-y-2 pointer-events-none group-hover:opacity-100 group-hover:translate-y-0 group-hover:pointer-events-auto transition-all duration-200 z-50">
                            <a href="{{ route('profil.index') }}" class="block px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                                Tentang & Sejarah
                            </a>
                            <a href="{{ route('profil.visi-misi') }}" class="block px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                                Visi & Misi
                            </a>
                            <a href="{{ route('profil.sambutan') }}" class="block px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                                Sambutan Kepala Sekolah
                            </a>
                            <a href="{{ route('guru.index') }}" class="block px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                                Guru & Tenaga Kependidikan
                            </a>
                            <a href="{{ route('fasilitas.index') }}" class="block px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                                Sarana, Prasarana & Ekskul
                            </a>
                        </div>
                    </div>

                    <!-- Dropdown Informasi / Kabar -->
                    <div class="relative group">
                        <button class="flex items-center gap-1 hover:text-blue-600 transition-colors py-2 focus:outline-none {{ request()->routeIs('berita.*', 'pengumuman.*', 'agenda.*', 'prestasi.*') ? 'text-blue-700 font-bold' : '' }}">
                            <span>Informasi</span>
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-600 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div class="absolute left-0 mt-1 w-56 bg-white rounded-xl shadow-xl border border-slate-100 py-2 opacity-0 translate-y-2 pointer-events-none group-hover:opacity-100 group-hover:translate-y-0 group-hover:pointer-events-auto transition-all duration-200 z-50">
                            <a href="{{ route('berita.index') }}" class="block px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                                Berita & Artikel
                            </a>
                            <a href="{{ route('pengumuman.index') }}" class="block px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                                Pengumuman Resmi
                            </a>
                            <a href="{{ route('agenda.index') }}" class="block px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                                Agenda Kegiatan
                            </a>
                            <a href="{{ route('prestasi.index') }}" class="block px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                                Prestasi Siswa & Sekolah
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('galeri.index') }}" class="transition-colors {{ request()->routeIs('galeri.*') ? 'text-blue-700 font-bold' : 'hover:text-blue-600' }}">
                        Galeri
                    </a>

                    <a href="{{ route('unduhan.index') }}" class="transition-colors {{ request()->routeIs('unduhan.*') ? 'text-blue-700 font-bold' : 'hover:text-blue-600' }}">
                        Unduhan
                    </a>

                    <a href="{{ route('kontak') }}" class="transition-colors {{ request()->routeIs('kontak') ? 'text-blue-700 font-bold' : 'hover:text-blue-600' }}">
                        Kontak
                    </a>

                    <a href="{{ route('ppdb') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full font-bold text-xs bg-gradient-to-r from-amber-500 to-amber-400 text-blue-950 shadow-md shadow-amber-500/20 hover:from-amber-400 hover:to-amber-300 transition-all transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Info PPDB 2026
                    </a>
                </nav>

                <!-- Mobile menu button -->
                <div class="flex items-center xl:hidden">
                    <button id="mobile-menu-btn" type="button" class="p-2.5 rounded-lg text-slate-700 hover:text-blue-700 hover:bg-blue-50 focus:outline-none" aria-label="Buka Menu">
                        <svg id="menu-icon-open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg id="menu-icon-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Drawer Menu -->
        <div id="mobile-menu" class="hidden xl:hidden border-t border-slate-200 bg-white px-4 pt-3 pb-6 space-y-2 shadow-xl text-xs font-semibold">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-slate-800 hover:bg-blue-50 hover:text-blue-700">Beranda</a>
            <div class="pl-3 py-1 space-y-1 border-l-2 border-slate-200 ml-2">
                <span class="block px-2 text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Profil Sekolah</span>
                <a href="{{ route('profil.index') }}" class="block px-2 py-1.5 text-slate-700 hover:text-blue-700">Tentang & Sejarah</a>
                <a href="{{ route('profil.visi-misi') }}" class="block px-2 py-1.5 text-slate-700 hover:text-blue-700">Visi & Misi</a>
                <a href="{{ route('profil.sambutan') }}" class="block px-2 py-1.5 text-slate-700 hover:text-blue-700">Sambutan Kepala Sekolah</a>
                <a href="{{ route('guru.index') }}" class="block px-2 py-1.5 text-slate-700 hover:text-blue-700">Guru & Tendik</a>
                <a href="{{ route('fasilitas.index') }}" class="block px-2 py-1.5 text-slate-700 hover:text-blue-700">Sarana, Prasarana & Ekskul</a>
            </div>
            <div class="pl-3 py-1 space-y-1 border-l-2 border-slate-200 ml-2">
                <span class="block px-2 text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Informasi & Kabar</span>
                <a href="{{ route('berita.index') }}" class="block px-2 py-1.5 text-slate-700 hover:text-blue-700">Berita & Artikel</a>
                <a href="{{ route('pengumuman.index') }}" class="block px-2 py-1.5 text-slate-700 hover:text-blue-700">Pengumuman Resmi</a>
                <a href="{{ route('agenda.index') }}" class="block px-2 py-1.5 text-slate-700 hover:text-blue-700">Agenda Kegiatan</a>
                <a href="{{ route('prestasi.index') }}" class="block px-2 py-1.5 text-slate-700 hover:text-blue-700">Prestasi Siswa</a>
            </div>
            <a href="{{ route('galeri.index') }}" class="block px-3 py-2 rounded-lg text-slate-800 hover:bg-blue-50 hover:text-blue-700">Galeri Foto</a>
            <a href="{{ route('unduhan.index') }}" class="block px-3 py-2 rounded-lg text-slate-800 hover:bg-blue-50 hover:text-blue-700">Dokumen Unduhan</a>
            <a href="{{ route('kontak') }}" class="block px-3 py-2 rounded-lg text-slate-800 hover:bg-blue-50 hover:text-blue-700">Kontak & Lokasi</a>
            <div class="pt-3">
                <a href="{{ route('ppdb') }}" class="block text-center w-full py-2.5 rounded-xl font-bold bg-amber-400 text-blue-950 shadow-md">
                    Penerimaan Peserta Didik Baru (PPDB)
                </a>
            </div>
        </div>
    </header>

    <!-- Content Body -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- School Footer -->
    <footer class="bg-slate-900 text-slate-300 pt-16 pb-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                <!-- Col 1: Identitas -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-700 to-blue-500 flex items-center justify-center text-white font-bold">
                            <svg class="w-6 h-6 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-extrabold text-white">SMP Negeri 2 Juwangi</h3>
                            <p class="text-xs text-amber-400 font-medium">Kabupaten Boyolali</p>
                        </div>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Lembaga pendidikan tingkat pertama yang berdedikasi membentuk generasi bangsa yang beriman, bertakwa, berkarakter mulia, dan kompetitif dalam era global.
                    </p>
                    <div class="flex items-center gap-2 pt-2">
                        <span class="inline-block px-3 py-1 bg-blue-950 text-blue-300 text-xs font-semibold rounded-full border border-blue-800">
                            NPSN: {{ $profile['npsn'] ?? '20308482' }}
                        </span>
                        <span class="inline-block px-3 py-1 bg-amber-950/60 text-amber-300 text-xs font-semibold rounded-full border border-amber-800/60">
                            Terakreditasi A
                        </span>
                    </div>
                </div>

                <!-- Col 2: Navigasi Cepat -->
                <div>
                    <h4 class="text-white font-bold text-base mb-4 pb-2 border-b border-slate-800">Tautan Cepat</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-amber-400 transition-colors flex items-center gap-1.5"><span class="text-slate-600">›</span> Beranda</a></li>
                        <li><a href="{{ route('profil.index') }}" class="hover:text-amber-400 transition-colors flex items-center gap-1.5"><span class="text-slate-600">›</span> Profil & Sejarah</a></li>
                        <li><a href="{{ route('berita.index') }}" class="hover:text-amber-400 transition-colors flex items-center gap-1.5"><span class="text-slate-600">›</span> Berita & Artikel</a></li>
                        <li><a href="{{ route('pengumuman.index') }}" class="hover:text-amber-400 transition-colors flex items-center gap-1.5"><span class="text-slate-600">›</span> Pengumuman Resmi</a></li>
                        <li><a href="{{ route('agenda.index') }}" class="hover:text-amber-400 transition-colors flex items-center gap-1.5"><span class="text-slate-600">›</span> Agenda Kegiatan</a></li>
                        <li><a href="{{ route('prestasi.index') }}" class="hover:text-amber-400 transition-colors flex items-center gap-1.5"><span class="text-slate-600">›</span> Prestasi Siswa</a></li>
                        <li><a href="{{ route('fasilitas.index') }}" class="hover:text-amber-400 transition-colors flex items-center gap-1.5"><span class="text-slate-600">›</span> Fasilitas & Ekskul</a></li>
                        <li><a href="{{ route('galeri.index') }}" class="hover:text-amber-400 transition-colors flex items-center gap-1.5"><span class="text-slate-600">›</span> Galeri Foto</a></li>
                        <li><a href="{{ route('unduhan.index') }}" class="hover:text-amber-400 transition-colors flex items-center gap-1.5"><span class="text-slate-600">›</span> Dokumen Unduhan</a></li>
                        <li><a href="{{ route('ppdb') }}" class="hover:text-amber-400 transition-colors flex items-center gap-1.5"><span class="text-slate-600">›</span> Informasi PPDB 2026</a></li>
                    </ul>
                </div>

                <!-- Col 3: Hubungi Kami -->
                <div>
                    <h4 class="text-white font-bold text-base mb-4 pb-2 border-b border-slate-800">Kontak Sekolah</h4>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li class="flex items-start gap-2.5">
                            <svg class="w-5 h-5 text-amber-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>{{ $profile['address'] ?? 'Jl. Raya Juwangi, Kec. Juwangi, Kab. Boyolali, Jawa Tengah' }}</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="w-5 h-5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span>{{ $profile['phone'] ?? '(0298) 610023' }}</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="w-5 h-5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>{{ $profile['email'] ?? 'info@smpn2juwangi.sch.id' }}</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="w-5 h-5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Senin - Sabtu: 07.00 - 14.30 WIB</span>
                        </li>
                    </ul>
                </div>

                <!-- Col 4: Lokasi & Media -->
                <div>
                    <h4 class="text-white font-bold text-base mb-4 pb-2 border-b border-slate-800">Media Sosial & Lokasi</h4>
                    <p class="text-sm text-slate-400 mb-4">
                        Ikuti kabar dan kegiatan siswa melalui kanal resmi:
                    </p>
                    <div class="flex items-center gap-3 mb-6">
                        <a href="{{ $profile['facebook'] ?? '#' }}" target="_blank" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-blue-600 text-slate-300 hover:text-white flex items-center justify-center transition-all" title="Facebook">
                            <span class="font-bold text-sm">f</span>
                        </a>
                        <a href="{{ $profile['instagram'] ?? '#' }}" target="_blank" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-pink-600 text-slate-300 hover:text-white flex items-center justify-center transition-all" title="Instagram">
                            <span class="font-bold text-sm">ig</span>
                        </a>
                        <a href="{{ $profile['youtube'] ?? '#' }}" target="_blank" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-red-600 text-slate-300 hover:text-white flex items-center justify-center transition-all" title="YouTube">
                            <span class="font-bold text-sm">yt</span>
                        </a>
                    </div>
                    <a href="{{ $profile['maps_url'] ?? 'https://maps.google.com/?q=SMP+Negeri+2+Juwangi+Boyolali' }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold border border-slate-700 transition-colors">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                        Buka di Google Maps
                    </a>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="mt-12 pt-8 border-t border-slate-800/80 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} SMP Negeri 2 Juwangi. Hak Cipta Dilindungi.</p>
                <p class="flex items-center gap-3">
                    <a href="{{ route('admin.login') }}" class="hover:text-slate-300">Portal Admin</a>
                    <span>•</span>
                    <span>Boyolali, Jawa Tengah</span>
                </p>
            </div>
        </div>
    </footer>

    <!-- Interactive script for mobile drawer -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btn = document.getElementById('mobile-menu-btn');
            const menu = document.getElementById('mobile-menu');
            const iconOpen = document.getElementById('menu-icon-open');
            const iconClose = document.getElementById('menu-icon-close');

            btn?.addEventListener('click', () => {
                menu.classList.toggle('hidden');
                iconOpen.classList.toggle('hidden');
                iconClose.classList.toggle('hidden');
            });
        });
    </script>
</body>
</html>
