@extends('layouts.app')

@section('title', 'Prestasi Siswa & Sekolah — SMP Negeri 2 Juwangi')
@section('meta_description', 'Raihan kejuaraan dan prestasi membanggakan siswa SMP Negeri 2 Juwangi tingkat kecamatan, kabupaten, provinsi, dan nasional.')

@section('content')
<!-- Hero Header -->
<section class="bg-linear-to-b from-slate-900 via-blue-950 to-slate-900 text-white py-16 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block px-3 py-1 bg-amber-400/20 text-amber-300 font-extrabold text-xs uppercase tracking-wider rounded-full border border-amber-400/30 mb-3">
            Kebanggaan Sekolah
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Prestasi Siswa & Sekolah</h1>
        <p class="mt-3 text-slate-300 text-sm sm:text-base max-w-2xl mx-auto">
            Apresiasi dedikasi, kerja keras, dan bakat peserta didik SMP Negeri 2 Juwangi di berbagai ajang kompetisi
        </p>
    </div>
</section>

<!-- Grid Prestasi -->
<section class="py-12 bg-slate-50 grow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @forelse($achievements as $item)
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs hover:shadow-lg transition-all duration-300 flex flex-col justify-between group">
                <div>
                    <!-- Image / Trophy Header -->
                    <div class="relative aspect-video bg-slate-100 overflow-hidden">
                        @if(!empty($item['image']))
                        <img src="{{ \App\Services\ApiClient::assetUrl($item['image']) }}" alt="{{ $item['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                        <div class="w-full h-full flex flex-col items-center justify-center bg-linear-to-br from-amber-50 to-amber-100 text-amber-600">
                            <span class="text-4xl font-bold">🏆</span>
                        </div>
                        @endif

                        <!-- Badges -->
                        <div class="absolute top-3 left-3 flex items-center gap-1.5 flex-wrap">
                            <span class="px-2.5 py-1 bg-amber-500 text-blue-950 font-extrabold text-[11px] rounded-lg shadow-sm">
                                {{ $item['medal'] ?? 'Juara' }}
                            </span>
                            <span class="px-2.5 py-1 bg-blue-900/90 text-white font-bold text-[10px] rounded-lg uppercase tracking-wider backdrop-blur-xs">
                                Tingkat {{ $item['level'] }}
                            </span>
                        </div>

                        <div class="absolute bottom-3 right-3 px-2 py-0.5 bg-slate-900/80 text-white text-[11px] font-bold rounded-md">
                            Tahun {{ $item['year'] }}
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="p-6 space-y-3">
                        <h2 class="font-extrabold text-base sm:text-lg text-slate-900 leading-snug">
                            {{ $item['title'] }}
                        </h2>

                        <div class="space-y-1 text-xs">
                            @if(!empty($item['student_name']))
                            <div class="flex items-center gap-2 text-slate-700">
                                <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <span class="font-bold">{{ $item['student_name'] }}</span>
                            </div>
                            @endif

                            @if(!empty($item['event_name']))
                            <div class="flex items-center gap-2 text-slate-500">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <span>{{ $item['event_name'] }}</span>
                            </div>
                            @endif
                        </div>

                        @if(!empty($item['description']))
                        <p class="text-xs text-slate-600 leading-relaxed pt-2 border-t border-slate-100">
                            {{ $item['description'] }}
                        </p>
                        @endif
                    </div>
                </div>

                <div class="px-6 pb-6 pt-2">
                    <span class="text-[11px] font-semibold text-slate-400">SMP Negeri 2 Juwangi, Boyolali</span>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white rounded-2xl border border-slate-200 p-12 text-center text-slate-500">
                <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                <h3 class="font-bold text-base text-slate-800">Data Prestasi Sedang Diperbarui</h3>
                <p class="text-xs text-slate-400 mt-1">Daftar prestasi siswa dan sekolah akan ditampilkan segera.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
