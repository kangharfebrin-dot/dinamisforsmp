@extends('layouts.app')

@section('title', 'Galeri Foto & Dokumentasi — SMP Negeri 2 Juwangi')
@section('meta_description', 'Dokumentasi visual rangkaian kegiatan, prestasi, upacara, dan aktivitas belajar siswa SMP Negeri 2 Juwangi.')

@section('content')
<!-- Hero Header -->
<section class="bg-gradient-to-b from-slate-900 via-blue-950 to-slate-900 text-white py-16 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block px-3 py-1 bg-amber-400/20 text-amber-300 font-extrabold text-xs uppercase tracking-wider rounded-full border border-amber-400/30 mb-3">
            Dokumentasi Visual
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Galeri Foto Sekolah</h1>
        <p class="mt-3 text-slate-300 text-sm sm:text-base max-w-2xl mx-auto">
            Merekam momen berharga, kebersamaan, dan dinamika kegiatan di SMP Negeri 2 Juwangi
        </p>
    </div>
</section>

<!-- Albums Grid & Photos -->
<section class="py-12 bg-slate-50 flex-grow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        <!-- Koleksi Foto Grid -->
        <div>
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">Koleksi Foto Terkini</h2>
                    <p class="text-xs text-slate-500 mt-1">Dokumentasi kegiatan akademik, ekstrakurikuler, dan perlombaan</p>
                </div>
                <span class="text-xs font-semibold text-slate-500">{{ count($galleries) }} foto</span>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-4 sm:gap-6">
                @forelse($galleries as $photo)
                <div class="group relative rounded-2xl overflow-hidden border border-slate-200 bg-slate-100 aspect-4/3 shadow-xs hover:shadow-xl transition-all duration-300">
                    <img src="{{ \App\Services\ApiClient::assetUrl($photo['image']) }}" alt="{{ $photo['title'] ?? 'Dokumentasi Sekolah' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-4 flex flex-col justify-end">
                        <span class="text-white font-bold text-xs sm:text-sm line-clamp-1">{{ $photo['title'] ?? 'Dokumentasi Sekolah' }}</span>
                        @if(!empty($photo['album_name']))
                        <span class="text-amber-300 text-[10px] font-semibold mt-0.5">{{ $photo['album_name'] }}</span>
                        @endif
                        <a href="{{ \App\Services\ApiClient::assetUrl($photo['image']) }}" target="_blank" class="mt-2 text-[11px] text-white font-bold underline inline-flex items-center gap-1">
                            Perbesar Foto &rarr;
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-full bg-white rounded-2xl border border-slate-200 p-12 text-center text-slate-500">
                    <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <h3 class="font-bold text-base text-slate-800">Galeri Foto Sedang Disiapkan</h3>
                    <p class="text-xs text-slate-400 mt-1">Dokumentasi foto kegiatan sekolah akan ditampilkan di sini.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection
