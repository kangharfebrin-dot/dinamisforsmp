@extends('layouts.app')

@section('title', 'Kabar & Berita — ' . ($profile['name'] ?? 'SMP Negeri 2 Juwangi'))
@section('meta_description', 'Kumpulan berita, artikel, dan dokumentasi kegiatan resmi SMP Negeri 2 Juwangi.')

@section('content')
<div class="bg-slate-900 text-white py-12 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-bold uppercase tracking-wider text-amber-400">Portal Informasi</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white mt-1">Berita & Kabar Sekolah</h1>
        <p class="text-slate-400 text-sm mt-1 max-w-2xl">Liputan terpercaya seputar kegiatan akademik, prestasi siswa, dan agenda resmi SMP Negeri 2 Juwangi.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Filter & Search Bar -->
    <div class="bg-white p-4 sm:p-6 rounded-2xl border border-slate-200/90 shadow-xs mb-8 flex flex-col md:flex-row gap-4 items-center justify-between">
        <!-- Categories Chips -->
        <div class="flex items-center gap-2 overflow-x-auto w-full md:w-auto pb-2 md:pb-0">
            <a href="{{ route('berita.index') }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap {{ !request('category') ? 'bg-blue-900 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                Semua
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('berita.index', ['category' => $cat['slug']]) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap {{ request('category') == $cat['slug'] ? 'bg-blue-900 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                {{ $cat['name'] }}
            </a>
            @endforeach
        </div>

        <!-- Search Form -->
        <form method="GET" action="{{ route('berita.index') }}" class="w-full md:w-72 flex gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul berita..." class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent">
            <button type="submit" class="px-4 py-2 bg-blue-900 text-white text-xs font-bold rounded-xl hover:bg-blue-800 transition-colors">
                Cari
            </button>
        </form>
    </div>

    <!-- News Grid -->
    @if(!empty($news) && count($news) > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($news as $post)
        <article class="bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-xs hover:shadow-xl hover:border-blue-300 transition-all flex flex-col group">
            <div class="relative h-52 bg-slate-800 overflow-hidden">
                @if(!empty($post['cover_image']))
                    <img src="{{ \App\Services\ApiClient::assetUrl($post['cover_image']) }}" alt="{{ $post['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-linear-to-tr from-slate-900 to-blue-900 text-slate-500">
                        <svg class="w-12 h-12 text-blue-300/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </div>
                @endif
                <span class="absolute top-3 left-3 bg-blue-950/80 text-amber-300 text-xs font-bold px-2.5 py-1 rounded-md backdrop-blur-md">
                    {{ $post['category_name'] ?? 'Berita' }}
                </span>
            </div>

            <div class="p-6 flex flex-col grow justify-between space-y-4">
                <div class="space-y-2">
                    <div class="flex items-center gap-2 text-xs text-slate-400">
                        <span>{{ !empty($post['published_at']) ? date('d M Y', strtotime($post['published_at'])) : date('d M Y') }}</span>
                        <span>•</span>
                        <span>{{ $post['author_name'] ?? 'Humas' }}</span>
                    </div>
                    <h2 class="font-bold text-slate-900 text-lg leading-snug group-hover:text-blue-700 transition-colors">
                        <a href="{{ route('berita.show', $post['slug']) }}">
                            {{ $post['title'] }}
                        </a>
                    </h2>
                    <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                        {{ $post['excerpt'] ?? strip_tags($post['content'] ?? '') }}
                    </p>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs text-slate-400">{{ $post['views_count'] ?? 0 }} kali dibaca</span>
                    <a href="{{ route('berita.show', $post['slug']) }}" class="text-xs font-bold text-blue-700 hover:text-blue-900">
                        Baca Lengkap →
                    </a>
                </div>
            </div>
        </article>
        @endforeach
    </div>
    @else
    <div class="bg-white p-12 rounded-2xl text-center text-slate-500 border border-slate-200">
        <p class="text-base font-semibold">Tidak ada berita yang sesuai dengan pencarian Anda.</p>
        <a href="{{ route('berita.index') }}" class="inline-block mt-3 text-xs font-bold text-blue-700 underline">Tampilkan Semua Berita</a>
    </div>
    @endif
</div>
@endsection
