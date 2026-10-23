<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Panel') — SMP Negeri 2 Juwangi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen flex">

    <!-- Sidebar Desktop -->
    <aside class="w-64 bg-slate-900 text-slate-300 hidden md:flex flex-col shrink-0 border-r border-slate-800">
        <!-- Brand -->
        <div class="h-20 flex items-center px-6 border-b border-slate-800 gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white font-extrabold shadow-md">
                2J
            </div>
            <div>
                <span class="text-sm font-extrabold text-white block leading-tight">SMPN 2 Juwangi</span>
                <span class="text-[11px] font-semibold text-amber-400 block">Panel Administrator</span>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-grow px-4 py-6 space-y-6 overflow-y-auto text-sm font-medium">
            <!-- 1. Dashboard -->
            <div>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white font-bold shadow-sm' : 'text-slate-400 hover:text-white hover:bg-slate-800/80' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
            </div>

            <!-- 2. Manajemen Konten -->
            <div class="space-y-1">
                <span class="px-3 text-[10px] font-extrabold text-slate-500 uppercase tracking-wider block">Konten & Publikasi</span>
                <a href="{{ route('admin.berita.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.berita.*') ? 'bg-blue-600 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    Berita & Artikel
                </a>
                <a href="{{ route('admin.kategori.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.kategori.*') ? 'bg-blue-600 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    Kategori Berita
                </a>
                <a href="{{ route('admin.pengumuman.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.pengumuman.*') ? 'bg-blue-600 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                    Pengumuman
                </a>
                <a href="{{ route('admin.agenda.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.agenda.*') ? 'bg-blue-600 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Agenda Kegiatan
                </a>
                <a href="{{ route('admin.halaman.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.halaman.*') ? 'bg-blue-600 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Halaman Informasi (PPDB)
                </a>
            </div>

            <!-- 3. Data Sekolah -->
            <div class="space-y-1">
                <span class="px-3 text-[10px] font-extrabold text-slate-500 uppercase tracking-wider block">Data Sekolah</span>
                <a href="{{ route('admin.profil.edit') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.profil.*') ? 'bg-blue-600 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Profil & Identitas
                </a>
                <a href="{{ route('admin.guru.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.guru.*') ? 'bg-blue-600 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Guru & Staf
                </a>
                <a href="{{ route('admin.prestasi.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.prestasi.*') ? 'bg-blue-600 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    Prestasi Siswa
                </a>
                <a href="{{ route('admin.ekstrakurikuler.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.ekstrakurikuler.*') ? 'bg-blue-600 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Ekstrakurikuler
                </a>
                <a href="{{ route('admin.fasilitas.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.fasilitas.*') ? 'bg-blue-600 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
                    Fasilitas Sekolah
                </a>
            </div>

            <!-- 4. Media & Unduhan -->
            <div class="space-y-1">
                <span class="px-3 text-[10px] font-extrabold text-slate-500 uppercase tracking-wider block">Media & Unduhan</span>
                <a href="{{ route('admin.galeri.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.galeri.*') ? 'bg-blue-600 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Album & Galeri
                </a>
                <a href="{{ route('admin.dokumen.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.dokumen.*') ? 'bg-blue-600 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/></svg>
                    Dokumen Unduhan
                </a>
            </div>

            <!-- 5. Akun Pengelola -->
            <div class="space-y-1">
                <span class="px-3 text-[10px] font-extrabold text-slate-500 uppercase tracking-wider block">Akun & Sistem</span>
                <a href="{{ route('admin.akun.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.akun.*') ? 'bg-blue-600 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Profil & Sandi
                </a>
            </div>
        </nav>

        <!-- User bottom section -->
        <div class="p-4 border-t border-slate-800 flex items-center justify-between text-xs">
            <div class="truncate pr-2">
                <span class="font-bold text-white block truncate">{{ session('admin_user.name', 'Administrator') }}</span>
                <span class="text-emerald-400 font-semibold text-[10px] uppercase">Admin</span>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="p-2 text-slate-400 hover:text-red-400 hover:bg-slate-800 rounded-lg transition-colors" title="Keluar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-grow flex flex-col min-w-0">
        <!-- Top Header -->
        <header class="h-20 bg-white border-b border-slate-200 px-6 sm:px-8 flex items-center justify-between sticky top-0 z-30 shadow-xs">
            <div class="flex items-center gap-3">
                <button id="mobile-toggle" class="md:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div>
                    <h1 class="text-lg sm:text-xl font-extrabold text-slate-900 leading-tight">@yield('page_title', 'Dashboard')</h1>
                    <p class="text-xs text-slate-500">@yield('page_subtitle', 'Sistem Manajemen Konten Website SMPN 2 Juwangi')</p>
                </div>
            </div>

            <div class="flex items-center gap-3 text-xs font-semibold">
                <a href="{{ route('home') }}" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Lihat Website Publik
                </a>
            </div>
        </header>

        <!-- Flash Messages -->
        <div class="max-w-7xl mx-auto w-full px-6 sm:px-8 pt-6">
            @if(session('success'))
            <div class="p-4 mb-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error') || $errors->any())
            <div class="p-4 mb-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm font-semibold flex items-start gap-3">
                <svg class="w-5 h-5 text-red-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <span>{{ session('error') ?? 'Terjadi kesalahan pada input data:' }}</span>
                    @if($errors->any())
                    <ul class="list-disc pl-5 mt-1 font-normal text-xs space-y-0.5">
                        @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Main Body -->
        <main class="flex-grow max-w-7xl mx-auto w-full px-6 sm:px-8 py-6">
            @yield('content')
        </main>
    </div>

    <!-- Universal Delete Confirmation Modal -->
    <div id="delete-modal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
            <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-900">Konfirmasi Penghapusan</h3>
                <p id="delete-message" class="text-sm text-slate-600 mt-1">Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 text-sm font-semibold rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors">
                    Batal
                </button>
                <form id="delete-form" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 text-sm font-bold rounded-xl bg-red-600 hover:bg-red-700 text-white transition-colors">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(url, title = 'data ini') {
            document.getElementById('delete-form').action = url;
            document.getElementById('delete-message').innerText = `Apakah Anda yakin ingin menghapus "${title}"? Tindakan ini permanen.`;
            document.getElementById('delete-modal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeDeleteModal();
        });
    </script>
</body>
</html>
