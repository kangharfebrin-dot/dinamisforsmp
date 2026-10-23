@extends('layouts.app')

@section('title', 'Dokumen & Berkas Unduhan — SMP Negeri 2 Juwangi')
@section('meta_description', 'Layanan unduhan dokumen resmi, formulir pendaftaran PPDB, tata tertib, dan materi belajar SMP Negeri 2 Juwangi.')

@section('content')
<!-- Hero Header -->
<section class="bg-linear-to-b from-slate-900 via-blue-950 to-slate-900 text-white py-16 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block px-3 py-1 bg-amber-400/20 text-amber-300 font-extrabold text-xs uppercase tracking-wider rounded-full border border-amber-400/30 mb-3">
            Pusat Dokumen
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Dokumen & Berkas Unduhan</h1>
        <p class="mt-3 text-slate-300 text-sm sm:text-base max-w-2xl mx-auto">
            Unduh formulir resmi, panduan akademik, juknis PPDB, dan berkas informasi SMP Negeri 2 Juwangi
        </p>
    </div>
</section>

<!-- Filter Kategori & List Dokumen -->
<section class="py-12 bg-slate-50 grow">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <!-- Kategori Filter -->
        <div class="flex items-center gap-2 overflow-x-auto pb-2 text-xs font-bold">
            <a href="{{ route('unduhan.index') }}" class="px-4 py-2 rounded-xl transition-all whitespace-nowrap {{ empty($category) ? 'bg-blue-600 text-white shadow-xs' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-100' }}">
                Semua Kategori
            </a>
            @foreach(['PPDB', 'Akademik', 'Kesiswaan', 'Tata Tertib', 'Umum'] as $cat)
            <a href="{{ route('unduhan.index', ['category' => $cat]) }}" class="px-4 py-2 rounded-xl transition-all whitespace-nowrap {{ $category === $cat ? 'bg-blue-600 text-white shadow-xs' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-100' }}">
                {{ $cat }}
            </a>
            @endforeach
        </div>

        <!-- Daftar Dokumen List -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs divide-y divide-slate-100 overflow-hidden">
            @forelse($documents as $doc)
            <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50/50 transition-colors">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-200 text-blue-700 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    </div>
                    <div class="space-y-1">
                        <h2 class="font-extrabold text-sm sm:text-base text-slate-900 leading-snug">
                            {{ $doc['title'] }}
                        </h2>
                        <div class="flex items-center gap-3 text-xs text-slate-400 font-medium flex-wrap">
                            <span class="px-2 py-0.5 bg-slate-100 text-slate-600 font-semibold rounded-md">
                                {{ $doc['category'] ?? 'Umum' }}
                            </span>
                            @if(!empty($doc['file_size']))
                            <span>{{ number_format($doc['file_size'] / 1024, 1) }} KB</span>
                            <span>•</span>
                            @endif
                            <span>Diunduh {{ number_format($doc['download_count'] ?? 0) }} kali</span>
                            @if(!empty($doc['created_at']))
                            <span>•</span>
                            <span>{{ date('d M Y', strtotime($doc['created_at'])) }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <a href="{{ route('unduhan.download', $doc['id']) }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-xs transition-colors shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Unduh Dokumen
                </a>
            </div>
            @empty
            <div class="p-12 text-center text-slate-400 text-xs">
                Belum ada dokumen yang tersedia pada kategori ini.
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
