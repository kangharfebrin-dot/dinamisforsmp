@extends('layouts.app')

@section('title', 'Sarana, Prasarana & Ekstrakurikuler — SMP Negeri 2 Juwangi')
@section('meta_description', 'Fasilitas ruang belajar, laboratorium, sarana olahraga, dan kegiatan ekstrakurikuler di SMP Negeri 2 Juwangi.')

@section('content')
<!-- Hero Header -->
<section class="bg-gradient-to-b from-slate-900 via-blue-950 to-slate-900 text-white py-16 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block px-3 py-1 bg-amber-400/20 text-amber-300 font-extrabold text-xs uppercase tracking-wider rounded-full border border-amber-400/30 mb-3">
            Lingkungan Belajar
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Sarana, Prasarana & Ekstrakurikuler</h1>
        <p class="mt-3 text-slate-300 text-sm sm:text-base max-w-2xl mx-auto">
            Fasilitas representatif dan wadah pengembangan potensi siswa SMP Negeri 2 Juwangi
        </p>
    </div>
</section>

<!-- Bagian 1: Fasilitas Sekolah -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mb-12">
            <span class="text-xs font-extrabold uppercase tracking-wider text-blue-600 block mb-1">Fasilitas Kampus</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Sarana & Prasarana Pembelajaran</h2>
            <p class="text-sm text-slate-500 mt-2">Dukungan infrastruktur yang aman, nyaman, dan memadai untuk kelancaran kegiatan belajar mengajar.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($facilities as $fac)
            <div class="bg-slate-50 rounded-2xl border border-slate-200 overflow-hidden hover:shadow-lg transition-all flex flex-col justify-between group">
                <div>
                    <div class="relative aspect-video bg-slate-200 overflow-hidden">
                        @if(!empty($fac['image']))
                        <img src="{{ \App\Services\ApiClient::assetUrl($fac['image']) }}" alt="{{ $fac['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                        <div class="w-full h-full flex items-center justify-center bg-blue-900/10 text-blue-700 font-bold text-sm">
                            FASILITAS SMPN 2 JUWANGI
                        </div>
                        @endif
                        <div class="absolute top-3 right-3 px-2.5 py-1 bg-white/90 backdrop-blur-xs text-slate-800 text-[11px] font-bold rounded-lg border border-slate-200 shadow-xs">
                            {{ $fac['quantity'] ?? 1 }} Unit
                        </div>
                    </div>

                    <div class="p-6 space-y-2">
                        <div class="flex items-center justify-between">
                            <h3 class="font-extrabold text-base text-slate-900">{{ $fac['name'] }}</h3>
                            @if(($fac['condition_status'] ?? '') === 'baik')
                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded-md border border-emerald-200">Kondisi Baik</span>
                            @else
                            <span class="px-2 py-0.5 bg-amber-50 text-amber-700 text-[10px] font-bold rounded-md border border-amber-200">Perawatan</span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            {{ $fac['description'] ?? 'Sarana pendukung kegiatan belajar mengajar di SMPN 2 Juwangi.' }}
                        </p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 text-center text-slate-400 text-xs">
                Data sarana dan prasarana sedang disiapkan.
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Bagian 2: Ekstrakurikuler -->
<section class="py-16 bg-slate-50 border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mb-12">
            <span class="text-xs font-extrabold uppercase tracking-wider text-amber-600 block mb-1">Pengembangan Diri</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Kegiatan Ekstrakurikuler</h2>
            <p class="text-sm text-slate-500 mt-2">Membina kepribadian, kepemimpinan, sportivitas, dan kreativitas siswa di luar jam pelajaran.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($extracurriculars as $ekskul)
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-lg transition-all flex flex-col justify-between group">
                <div>
                    <div class="relative aspect-video bg-slate-100 overflow-hidden">
                        @if(!empty($ekskul['image']))
                        <img src="{{ \App\Services\ApiClient::assetUrl($ekskul['image']) }}" alt="{{ $ekskul['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                        <div class="w-full h-full flex items-center justify-center bg-amber-50 text-amber-700 font-bold text-sm">
                            EKSTRAKURIKULER
                        </div>
                        @endif
                    </div>

                    <div class="p-6 space-y-3">
                        <h3 class="font-extrabold text-base text-slate-900">{{ $ekskul['name'] }}</h3>

                        <div class="space-y-1 text-xs text-slate-600">
                            @if(!empty($ekskul['coach_name']))
                            <div class="flex items-center gap-2">
                                <span class="text-slate-400 font-medium">Pembina:</span>
                                <span class="font-bold text-slate-800">{{ $ekskul['coach_name'] }}</span>
                            </div>
                            @endif

                            @if(!empty($ekskul['schedule']))
                            <div class="flex items-center gap-2">
                                <span class="text-slate-400 font-medium">Jadwal:</span>
                                <span class="font-semibold text-blue-700">{{ $ekskul['schedule'] }}</span>
                            </div>
                            @endif
                        </div>

                        <p class="text-xs text-slate-600 leading-relaxed pt-2 border-t border-slate-100">
                            {{ $ekskul['description'] ?? 'Kegiatan pembinaan minat dan bakat siswa.' }}
                        </p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 text-center text-slate-400 text-xs">
                Data ekstrakurikuler sedang disiapkan.
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
