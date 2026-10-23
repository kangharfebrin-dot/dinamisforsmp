@extends('layouts.app')

@section('title', $agenda['title'] . ' — Agenda SMP Negeri 2 Juwangi')
@section('meta_description', Str::limit(strip_tags($agenda['description'] ?? 'Detail agenda kegiatan sekolah'), 150))

@section('content')
<section class="bg-gradient-to-b from-slate-900 to-blue-950 text-white py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('agenda.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-300 hover:text-amber-200 mb-4 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Agenda
        </a>
        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight leading-tight">
            {{ $agenda['title'] }}
        </h1>
    </div>
</section>

<section class="py-12 bg-slate-50 flex-grow">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-10 shadow-xs space-y-8">
            <!-- Informasi Waktu & Lokasi -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-5 bg-blue-50/50 rounded-2xl border border-blue-100 text-xs">
                <div class="flex items-start gap-3">
                    <div class="p-2.5 rounded-xl bg-blue-600 text-white shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <span class="text-slate-500 font-bold uppercase text-[10px] block">Waktu Pelaksanaan</span>
                        <span class="font-extrabold text-slate-900 text-sm block mt-0.5">
                            {{ date('d F Y', strtotime($agenda['start_at'])) }}
                        </span>
                        <span class="text-slate-600 font-medium">
                            Pukul {{ date('H:i', strtotime($agenda['start_at'])) }} WIB
                            @if(!empty($agenda['end_at']))
                            s/d {{ date('H:i', strtotime($agenda['end_at'])) }} WIB
                            @endif
                        </span>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="p-2.5 rounded-xl bg-amber-500 text-blue-950 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <span class="text-slate-500 font-bold uppercase text-[10px] block">Tempat / Lokasi</span>
                        <span class="font-extrabold text-slate-900 text-sm block mt-0.5">
                            {{ $agenda['location'] ?? 'SMPN 2 Juwangi' }}
                        </span>
                        <span class="text-slate-600 font-medium">Juwangi, Boyolali</span>
                    </div>
                </div>
            </div>

            <!-- Detail Deskripsi -->
            <div class="space-y-3">
                <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Detail Informasi Kegiatan</h3>
                <div class="text-sm text-slate-700 leading-relaxed whitespace-pre-line">
                    {{ $agenda['description'] ?? 'Tidak ada rincian tambahan untuk kegiatan ini.' }}
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                <span>Penyelenggara: SMP Negeri 2 Juwangi</span>
                <a href="{{ route('agenda.index') }}" class="text-blue-600 font-bold hover:underline">Lihat Semua Agenda &rarr;</a>
            </div>
        </div>
    </div>
</section>
@endsection
