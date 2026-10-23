@extends('layouts.app')

@section('title', 'Profil Sekolah — ' . ($profile['name'] ?? 'SMP Negeri 2 Juwangi'))

@section('content')
<div class="bg-slate-900 text-white py-12 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-bold uppercase tracking-wider text-amber-400">Tentang Kami</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white mt-1">Profil & Sejarah Singkat</h1>
        <p class="text-slate-400 text-sm mt-1 max-w-2xl">Mengenal lebih dekat identitas, sejarah, dan nilai-nilai keunggulan SMP Negeri 2 Juwangi, Boyolali.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-10">
    <!-- Identitas Formal Grid -->
    <div class="bg-white rounded-3xl p-8 border border-slate-200/90 shadow-xs">
        <h2 class="text-xl font-extrabold text-slate-900 mb-6 pb-2 border-b border-slate-100 flex items-center gap-2">
            <span class="w-2.5 h-6 bg-blue-700 rounded-full"></span>
            Identitas Resmi Satuan Pendidikan
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-sm">
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                <span class="text-xs text-slate-400 font-bold block uppercase">Nama Sekolah</span>
                <span class="font-bold text-slate-800 text-base">{{ $profile['name'] ?? 'SMP Negeri 2 Juwangi' }}</span>
            </div>
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                <span class="text-xs text-slate-400 font-bold block uppercase">NPSN</span>
                <span class="font-bold text-slate-800 text-base">{{ $profile['npsn'] ?? '20308253' }}</span>
            </div>
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                <span class="text-xs text-slate-400 font-bold block uppercase">Status Akreditasi</span>
                <span class="font-bold text-emerald-600 text-base">Terakreditasi "A" (Amat Baik)</span>
            </div>
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                <span class="text-xs text-slate-400 font-bold block uppercase">Bentuk Pendidikan</span>
                <span class="font-bold text-slate-800 text-base">Sekolah Menengah Pertama (SMP)</span>
            </div>
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                <span class="text-xs text-slate-400 font-bold block uppercase">Status Kepemilikan</span>
                <span class="font-bold text-slate-800 text-base">Pemerintah Daerah (Negeri)</span>
            </div>
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                <span class="text-xs text-slate-400 font-bold block uppercase">Kurikulum</span>
                <span class="font-bold text-slate-800 text-base">Kurikulum Merdeka Mandiri Berbagi</span>
            </div>
        </div>
    </div>

    <!-- Sejarah Singkat -->
    <div class="bg-white rounded-3xl p-8 border border-slate-200/90 shadow-xs space-y-4">
        <h2 class="text-xl font-extrabold text-slate-900 pb-2 border-b border-slate-100 flex items-center gap-2">
            <span class="w-2.5 h-6 bg-amber-500 rounded-full"></span>
            Sejarah Perkembangan Sekolah
        </h2>
        <div class="text-slate-600 text-sm sm:text-base leading-relaxed space-y-3">
            <p>
                {{ $profile['history'] ?? 'SMP Negeri 2 Juwangi didirikan untuk memberikan pemerataan dan perluasan akses pendidikan dasar 9 tahun yang bermutu bagi masyarakat di wilayah Kecamatan Juwangi dan daerah sekitarnya di Boyolali Utara.' }}
            </p>
            <p>
                Dengan semangat gotong royong dan dukungan penuh dari dinas pendidikan serta tokoh masyarakat, sekolah ini terus berkembang dari sisi infrastruktur ruang kelas, laboratorium komputer, perpustakaan terakreditasi, serta sarana olahraga yang representatif.
            </p>
        </div>
    </div>
</div>
@endsection
