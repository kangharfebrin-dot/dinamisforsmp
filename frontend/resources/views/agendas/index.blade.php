@extends('layouts.app')

@section('title', 'Agenda Kegiatan Sekolah — SMP Negeri 2 Juwangi')
@section('meta_description', 'Jadwal rangkaian kegiatan akademik, ujian, perlombaan, upacara, dan rapat di SMP Negeri 2 Juwangi.')

@section('content')
<!-- Hero Header -->
<section class="bg-gradient-to-b from-slate-900 via-blue-950 to-slate-900 text-white py-16 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block px-3 py-1 bg-amber-400/20 text-amber-300 font-extrabold text-xs uppercase tracking-wider rounded-full border border-amber-400/30 mb-3">
            Kalender Sekolah
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Agenda Kegiatan Sekolah</h1>
        <p class="mt-3 text-slate-300 text-sm sm:text-base max-w-2xl mx-auto">
            Jadwal kegiatan akademik, ekstrakurikuler, dan acara resmi SMP Negeri 2 Juwangi
        </p>
    </div>
</section>

<!-- Content List -->
<section class="py-12 bg-slate-50 flex-grow">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        @forelse($agendas as $agenda)
        <article class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs hover:shadow-md transition-shadow flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
            <div class="flex items-start gap-4">
                <!-- Date Badge -->
                <div class="w-16 h-16 rounded-2xl bg-blue-50 border border-blue-200 text-blue-900 flex flex-col items-center justify-center shrink-0">
                    <span class="text-xs font-bold uppercase text-blue-600">{{ date('M', strtotime($agenda['start_at'])) }}</span>
                    <span class="text-xl font-extrabold leading-tight">{{ date('d', strtotime($agenda['start_at'])) }}</span>
                </div>

                <div class="space-y-1">
                    <h2 class="text-base sm:text-lg font-bold text-slate-900 hover:text-blue-700 transition-colors">
                        <a href="{{ route('agenda.show', $agenda['id']) }}">{{ $agenda['title'] }}</a>
                    </h2>

                    <div class="flex items-center gap-4 flex-wrap text-xs text-slate-500 font-medium">
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ date('H:i', strtotime($agenda['start_at'])) }} WIB
                            @if(!empty($agenda['end_at']))
                            - {{ date('H:i', strtotime($agenda['end_at'])) }} WIB
                            @endif
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $agenda['location'] ?? 'SMPN 2 Juwangi' }}
                        </span>
                    </div>

                    @if(!empty($agenda['description']))
                    <p class="text-xs text-slate-600 line-clamp-2 mt-1">
                        {{ $agenda['description'] }}
                    </p>
                    @endif
                </div>
            </div>

            <a href="{{ route('agenda.show', $agenda['id']) }}" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-xs transition-colors shrink-0">
                Detail Kegiatan &rarr;
            </a>
        </article>
        @empty
        <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center text-slate-500">
            <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <h3 class="font-bold text-base text-slate-800">Belum Ada Agenda Mendatang</h3>
            <p class="text-xs text-slate-400 mt-1">Seluruh agenda kegiatan akan diperbarui secara berkala.</p>
        </div>
        @endforelse
    </div>
</section>
@endsection
