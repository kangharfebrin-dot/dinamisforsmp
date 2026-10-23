@extends('layouts.app')

@section('title', 'Penerimaan Peserta Didik Baru (PPDB) 2026/2027 — ' . ($profile['name'] ?? 'SMP Negeri 2 Juwangi'))

@section('content')
<div class="bg-linear-to-r from-blue-950 to-slate-900 text-white py-14 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center sm:text-left">
        <span class="text-xs font-bold uppercase tracking-wider text-amber-400 bg-amber-400/20 px-3 py-1 rounded-full border border-amber-400/30">
            Tahun Ajaran 2026/2027
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-white mt-3">Informasi Resmi PPDB SMPN 2 Juwangi</h1>
        <p class="text-slate-300 text-sm sm:text-base mt-2 max-w-2xl">Panduan lengkap alur pendaftaran, persyaratan berkas, daya tampung, dan jadwal seleksi siswa baru.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">
    <!-- Jalur Pendaftaran Grid -->
    <div>
        <h2 class="text-2xl font-extrabold text-slate-900 mb-6 text-center sm:text-left">4 Jalur Penerimaan</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-xs space-y-3">
                <span class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 font-extrabold flex items-center justify-center text-sm">50%</span>
                <h3 class="font-bold text-slate-900 text-base">Jalur Zonasi</h3>
                <p class="text-xs text-slate-600 leading-relaxed">Diperuntukkan bagi calon peserta didik yang berdomisili di dalam wilayah zonasi yang ditetapkan pemerintah daerah.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-xs space-y-3">
                <span class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 font-extrabold flex items-center justify-center text-sm">15%</span>
                <h3 class="font-bold text-slate-900 text-base">Jalur Afirmasi</h3>
                <p class="text-xs text-slate-600 leading-relaxed">Bagi peserta didik dari keluarga ekonomi tidak mampu (KIP/PKH) dan penyandang disabilitas.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-xs space-y-3">
                <span class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 font-extrabold flex items-center justify-center text-sm">30%</span>
                <h3 class="font-bold text-slate-900 text-base">Jalur Prestasi</h3>
                <p class="text-xs text-slate-600 leading-relaxed">Seleksi berdasarkan nilai rapor semester 1-5 dan sertifikat kejuaraan akademik maupun non-akademik.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-xs space-y-3">
                <span class="w-10 h-10 rounded-xl bg-purple-100 text-purple-700 font-extrabold flex items-center justify-center text-sm">5%</span>
                <h3 class="font-bold text-slate-900 text-base">Perpindahan Tugas</h3>
                <p class="text-xs text-slate-600 leading-relaxed">Diperuntukkan bagi calon peserta didik yang berpindah domisili mengikuti penugasan orang tua/wali.</p>
            </div>
        </div>
    </div>

    <!-- Alur & Syarat -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Syarat -->
        <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-xs space-y-4">
            <h3 class="text-lg font-bold text-slate-900 pb-2 border-b border-slate-100">Syarat Berkas Pendaftaran</h3>
            <ul class="space-y-2.5 text-xs sm:text-sm text-slate-600">
                <li class="flex items-center gap-2"><span class="text-blue-700 font-bold">✔</span> Ijazah / Surat Keterangan Lulus (SKL) SD/MI asli & fotokopi.</li>
                <li class="flex items-center gap-2"><span class="text-blue-700 font-bold">✔</span> Akta Kelahiran resmi.</li>
                <li class="flex items-center gap-2"><span class="text-blue-700 font-bold">✔</span> Kartu Keluarga (KK) yang diterbitkan minimal 1 tahun sebelum pendaftaran.</li>
                <li class="flex items-center gap-2"><span class="text-blue-700 font-bold">✔</span> Pas foto terbaru ukuran 3x4 (3 lembar).</li>
                <li class="flex items-center gap-2"><span class="text-blue-700 font-bold">✔</span> Piagam kejuaraan (khusus jalur prestasi).</li>
            </ul>
        </div>

        <!-- Bantuan Panitia -->
        <div class="bg-linear-to-br from-blue-900 to-slate-900 text-white p-8 rounded-3xl shadow-md flex flex-col justify-between space-y-4">
            <div>
                <span class="text-amber-400 text-xs font-bold uppercase">Layanan Informasi & Konsultasi</span>
                <h3 class="text-xl font-extrabold text-white mt-1">Butuh Bantuan Pendaftaran?</h3>
                <p class="text-slate-300 text-xs sm:text-sm mt-2 leading-relaxed">
                    Panitia PPDB SMPN 2 Juwangi siap melayani pendampingan pendaftaran online bagi orang tua dan calon siswa di posko pendaftaran sekolah.
                </p>
            </div>
            <div class="pt-2">
                <a href="{{ route('kontak') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-amber-400 text-blue-950 font-bold text-xs shadow-md hover:bg-amber-300 transition-colors">
                    Hubungi Sekretariat PPDB
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
