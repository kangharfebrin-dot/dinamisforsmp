@extends('layouts.app')

@section('title', 'Guru & Tenaga Kependidikan — ' . ($profile['name'] ?? 'SMP Negeri 2 Juwangi'))

@section('content')
<div class="bg-slate-900 text-white py-12 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-bold uppercase tracking-wider text-amber-400">Pendidik & Tenaga Kependidikan</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white mt-1">Dewan Guru & Staf Tata Usaha</h1>
        <p class="text-slate-400 text-sm mt-1 max-w-2xl">Tenaga pendidik profesional, berdedikasi tinggi, dan berkompeten di bidangnya.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Filter Tabs -->
    <div class="flex items-center gap-2 mb-8 border-b border-slate-200 pb-4">
        <a href="{{ route('guru.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold {{ empty($type) ? 'bg-blue-900 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
            Semua ({{ count($teachers) }})
        </a>
        <a href="{{ route('guru.index', ['type' => 'guru']) }}" class="px-4 py-2 rounded-xl text-xs font-bold {{ $type === 'guru' ? 'bg-blue-900 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
            Tenaga Pendidik (Guru)
        </a>
        <a href="{{ route('guru.index', ['type' => 'tendik']) }}" class="px-4 py-2 rounded-xl text-xs font-bold {{ $type === 'tendik' ? 'bg-blue-900 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
            Tenaga Kependidikan (TU & Staf)
        </a>
    </div>

    <!-- Teachers Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($teachers as $t)
        <div class="bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-xs hover:shadow-lg transition-all text-center p-6 space-y-3 group">
            <div class="w-24 h-24 mx-auto rounded-full bg-slate-100 p-1 border-2 border-blue-100 group-hover:border-blue-500 transition-colors overflow-hidden">
                @if(!empty($t['photo']))
                <img src="{{ \App\Services\ApiClient::assetUrl($t['photo']) }}" alt="{{ $t['name'] }}" class="w-full h-full object-cover rounded-full">
                @else
                <div class="w-full h-full rounded-full bg-slate-200 overflow-hidden flex items-center justify-center text-slate-400">
                    <svg class="w-14 h-14" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </div>
                @endif
            </div>
            <div>
                <h3 class="font-bold text-slate-900 text-base group-hover:text-blue-700 transition-colors">{{ $t['name'] }}</h3>
                <p class="text-xs font-semibold text-blue-800 mt-0.5">{{ $t['position'] ?? 'Guru Mata Pelajaran' }}</p>
                @if(!empty($t['subject']))
                <span class="inline-block mt-2 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-blue-50 text-blue-700 border border-blue-100">
                    {{ $t['subject'] }}
                </span>
                @endif
                @if(!empty($t['nip']))
                <p class="text-[11px] text-slate-400 mt-2 font-mono">NIP: {{ $t['nip'] }}</p>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white p-10 rounded-2xl text-center text-slate-500 border border-slate-200">
            Data dewan guru belum dimuat.
        </div>
        @endforelse
    </div>
</div>
@endsection
