@extends('layouts.app')

@section('title', ($post['title'] ?? 'Detail Berita') . ' — ' . ($profile['name'] ?? 'SMP Negeri 2 Juwangi'))
@section('meta_description', Str::limit(strip_tags($post['excerpt'] ?? $post['content'] ?? ''), 150))

@section('content')
<div class="bg-slate-900 text-white py-10 border-b border-slate-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('berita.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-400 hover:text-amber-300 mb-3">
            ← Kembali ke Berita
        </a>
        <div class="flex items-center gap-2 mb-2">
            <span class="bg-blue-800 text-amber-300 text-xs font-bold px-2.5 py-0.5 rounded-md">
                {{ $post['category_name'] ?? 'Berita' }}
            </span>
            <span class="text-xs text-slate-400">
                {{ !empty($post['published_at']) ? date('d F Y', strtotime($post['published_at'])) : date('d F Y') }}
            </span>
        </div>
        <h1 class="text-2xl sm:text-4xl font-extrabold text-white leading-tight">
            {{ $post['title'] }}
        </h1>
        <div class="mt-4 flex items-center gap-3 text-xs text-slate-400 pt-3 border-t border-slate-800">
            <span>Ditulis oleh: <strong class="text-slate-200">{{ $post['author_name'] ?? 'Humas Sekolah' }}</strong></span>
            <span>•</span>
            <span>{{ $post['views_count'] ?? 1 }} kali dibaca</span>
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <article class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/90 shadow-sm space-y-6">
        @if(!empty($post['cover_image']))
        <div class="rounded-2xl overflow-hidden max-h-96 w-full">
            <img src="{{ \App\Services\ApiClient::assetUrl($post['cover_image']) }}" alt="{{ $post['title'] }}" class="w-full h-full object-cover">
        </div>
        @endif

        @if(!empty($post['excerpt']))
        <div class="p-4 rounded-xl bg-blue-50/70 border-l-4 border-blue-700 text-slate-700 text-sm italic leading-relaxed">
            {{ $post['excerpt'] }}
        </div>
        @endif

        <div class="prose prose-slate max-w-none text-sm sm:text-base leading-relaxed space-y-4">
            {!! $post['content'] !!}
        </div>
    </article>

    <!-- Related news -->
    @if(!empty($related) && count($related) > 0)
    <div class="mt-12">
        <h3 class="text-xl font-bold text-slate-900 mb-6 pb-2 border-b border-slate-200">Berita Terkait Lainnya</h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            @foreach($related as $rel)
            <a href="{{ route('berita.show', $rel['slug']) }}" class="bg-white p-4 rounded-2xl border border-slate-200 hover:border-blue-300 hover:shadow-md transition-all flex flex-col justify-between group">
                <span class="text-[11px] font-bold text-blue-700">{{ $rel['category_name'] ?? 'Berita' }}</span>
                <h4 class="font-bold text-sm text-slate-900 group-hover:text-blue-700 transition-colors my-2 line-clamp-2">
                    {{ $rel['title'] }}
                </h4>
                <span class="text-[11px] text-slate-400">
                    {{ !empty($rel['published_at']) ? date('d M Y', strtotime($rel['published_at'])) : date('d M Y') }}
                </span>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
