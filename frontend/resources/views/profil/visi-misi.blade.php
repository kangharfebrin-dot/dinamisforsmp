@extends('layouts.app')

@section('title', 'Visi & Misi — ' . ($profile['name'] ?? 'SMP Negeri 2 Juwangi'))

@section('content')
<div class="bg-slate-900 text-white py-12 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-bold uppercase tracking-wider text-amber-400">Fondasi Pendidikan</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white mt-1">Visi & Misi Sekolah</h1>
        <p class="text-slate-400 text-sm mt-1 max-w-2xl">Arah kebijakan, komitmen nilai, dan tujuan strategis SMP Negeri 2 Juwangi.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-10">
    <!-- Visi Box -->
    <div class="bg-gradient-to-r from-blue-900 via-blue-950 to-slate-900 text-white rounded-3xl p-8 sm:p-12 shadow-xl border border-blue-800 space-y-4">
        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-400 text-blue-950 font-bold text-xs uppercase tracking-wider">
            Visi Sekolah
        </span>
        <h2 class="text-xl sm:text-3xl font-extrabold text-amber-300 leading-snug">
            "{{ $profile['vision'] ?? 'Terwujudnya Peserta Didik yang Berakhlak Mulia, Unggul dalam Prestasi, Terampil dalam Teknologi, Mandiri, dan Berbudaya Lingkungan.' }}"
        </h2>
    </div>

    <!-- Misi Box -->
    <div class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200/90 shadow-xs space-y-6">
        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-100 text-blue-800 font-bold text-xs uppercase tracking-wider">
            Misi Sekolah
        </span>
        <h3 class="text-xl sm:text-2xl font-bold text-slate-900">
            Langkah Nyata Mewujudkan Visi
        </h3>
        <div class="space-y-4 text-slate-700 text-sm sm:text-base leading-relaxed">
            @php
                $missions = preg_split('/\r\n|\r|\n/', $profile['mission'] ?? '');
            @endphp
            @foreach($missions as $m)
                @if(trim($m))
                <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="w-6 h-6 rounded-full bg-blue-700 text-white font-bold text-xs flex items-center justify-center shrink-0 mt-0.5">✓</span>
                    <span>{{ preg_replace('/^\d+\.\s*/', '', trim($m)) }}</span>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection
