@extends('layouts.app')

@section('title', $announcement['title'] . ' — SMP Negeri 2 Juwangi')
@section('meta_description', Str::limit(strip_tags($announcement['content']), 150))

@section('content')
<section class="bg-gradient-to-b from-slate-900 to-blue-950 text-white py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('pengumuman.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-300 hover:text-amber-200 mb-4 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Pengumuman
        </a>
        <div class="flex items-center gap-2 mb-3">
            @if(($announcement['priority'] ?? 0) > 0)
            <span class="px-2.5 py-0.5 bg-amber-400 text-blue-950 font-extrabold text-[11px] rounded-md">
                Penting
            </span>
            @endif
            <span class="text-xs text-slate-300">
                Dipublikasikan: {{ isset($announcement['created_at']) ? date('d F Y', strtotime($announcement['created_at'])) : '-' }}
            </span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight leading-tight">
            {{ $announcement['title'] }}
        </h1>
    </div>
</section>

<section class="py-12 bg-slate-50 flex-grow">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-10 shadow-xs space-y-6">
            <!-- Isi Pengumuman -->
            <div class="prose prose-slate max-w-none text-sm text-slate-700 leading-relaxed whitespace-pre-line">
                {{ $announcement['content'] }}
            </div>

            <!-- Lampiran Berkas Jika Ada -->
            @if(!empty($announcement['attachment']))
            <div class="pt-6 border-t border-slate-100">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Berkas Lampiran Resmi</h3>
                <div class="flex items-center justify-between p-4 bg-blue-50/60 rounded-xl border border-blue-100">
                    <div class="flex items-center gap-3">
                        <svg class="w-7 h-7 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        <div>
                            <span class="text-xs font-bold text-slate-900 block">Lampiran Pengumuman</span>
                            <span class="text-[11px] text-slate-500">Unduh dokumen edaran resmi</span>
                        </div>
                    </div>
                    <a href="{{ \App\Services\ApiClient::assetUrl($announcement['attachment']) }}" target="_blank" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-xs transition-colors">
                        Unduh Berkas
                    </a>
                </div>
            </div>
            @endif

            <div class="pt-6 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                <span>Dikeluarkan oleh: Bagian Tata Usaha SMPN 2 Juwangi</span>
                <a href="{{ route('pengumuman.index') }}" class="text-blue-600 font-bold hover:underline">Daftar Lainnya &rarr;</a>
            </div>
        </div>
    </div>
</section>
@endsection
