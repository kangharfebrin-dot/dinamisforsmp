@extends('layouts.app')

@section('title', 'Pengumuman Resmi — SMP Negeri 2 Juwangi')
@section('meta_description', 'Daftar pengumuman resmi, edaran, dan informasi penting bagi siswa dan wali murid SMP Negeri 2 Juwangi.')

@section('content')
<!-- Hero Header -->
<section class="bg-gradient-to-b from-slate-900 via-blue-950 to-slate-900 text-white py-16 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block px-3 py-1 bg-amber-400/20 text-amber-300 font-extrabold text-xs uppercase tracking-wider rounded-full border border-amber-400/30 mb-3">
            Warta Sekolah
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Pengumuman Resmi</h1>
        <p class="mt-3 text-slate-300 text-sm sm:text-base max-w-2xl mx-auto">
            Informasi edaran, kebijakan akademik, dan pengumuman resmi dari SMP Negeri 2 Juwangi
        </p>
    </div>
</section>

<!-- Content List -->
<section class="py-12 bg-slate-50 flex-grow">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        @forelse($announcements as $item)
        <article class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                <div class="space-y-2 flex-grow">
                    <div class="flex items-center gap-2 flex-wrap">
                        @if(($item['priority'] ?? 0) > 0)
                        <span class="px-2.5 py-0.5 bg-amber-100 text-amber-900 font-extrabold text-[11px] rounded-md border border-amber-200">
                            Penting
                        </span>
                        @endif
                        <span class="text-xs text-slate-400 font-medium">
                            {{ isset($item['created_at']) ? date('d F Y', strtotime($item['created_at'])) : '-' }}
                        </span>
                    </div>

                    <h2 class="text-lg sm:text-xl font-bold text-slate-900 hover:text-blue-700 transition-colors">
                        <a href="{{ route('pengumuman.show', $item['id']) }}">{{ $item['title'] }}</a>
                    </h2>

                    <p class="text-xs sm:text-sm text-slate-600 line-clamp-3 leading-relaxed">
                        {{ strip_tags($item['content']) }}
                    </p>
                </div>

                <div class="shrink-0 flex sm:flex-col items-center gap-2">
                    <a href="{{ route('pengumuman.show', $item['id']) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-xs transition-colors whitespace-nowrap">
                        Baca Rinci &rarr;
                    </a>
                    @if(!empty($item['attachment']))
                    <a href="{{ \App\Services\ApiClient::assetUrl($item['attachment']) }}" target="_blank" class="px-3 py-2 border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl font-bold text-xs flex items-center gap-1.5 whitespace-nowrap">
                        <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                        Lampiran
                    </a>
                    @endif
                </div>
            </div>
        </article>
        @empty
        <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center text-slate-500">
            <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
            <h3 class="font-bold text-base text-slate-800">Belum Ada Pengumuman Baru</h3>
            <p class="text-xs text-slate-400 mt-1">Saat ini belum ada pengumuman resmi yang dipublikasikan.</p>
        </div>
        @endforelse
    </div>
</section>
@endsection
