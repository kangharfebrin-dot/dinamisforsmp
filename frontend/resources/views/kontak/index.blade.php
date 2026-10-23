@extends('layouts.app')

@section('title', 'Kontak & Lokasi — ' . ($profile['name'] ?? 'SMP Negeri 2 Juwangi'))

@section('content')
<div class="bg-slate-900 text-white py-12 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-bold uppercase tracking-wider text-amber-400">Layanan & Komunikasi</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white mt-1">Kontak & Lokasi Sekolah</h1>
        <p class="text-slate-400 text-sm mt-1 max-w-2xl">Kami siap mendengarkan aspirasi, pertanyaan, serta kebutuhan informasi Anda.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if(session('success'))
    <div class="mb-8 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-2">
        <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        <!-- Info Cards -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs space-y-6">
                <h3 class="text-lg font-extrabold text-slate-900 pb-3 border-b border-slate-100">Informasi Alamat & Telepon</h3>
                <div class="space-y-4 text-sm text-slate-600">
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center shrink-0">
                            📍
                        </div>
                        <div>
                            <strong class="block text-slate-900 font-bold text-xs uppercase text-slate-400">Alamat Lengkap</strong>
                            <p class="mt-0.5 leading-relaxed">{{ $profile['address'] ?? 'Jl. Raya Juwangi - Kedungombo Km. 2, Juwangi, Boyolali, Jawa Tengah 57391' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center shrink-0">
                            📞
                        </div>
                        <div>
                            <strong class="block text-slate-900 font-bold text-xs uppercase text-slate-400">Telepon / Fax</strong>
                            <p class="mt-0.5">{{ $profile['phone'] ?? '(0298) 610023' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center shrink-0">
                            ✉️
                        </div>
                        <div>
                            <strong class="block text-slate-900 font-bold text-xs uppercase text-slate-400">Email Resmi</strong>
                            <p class="mt-0.5">{{ $profile['email'] ?? 'info@smpn2juwangi.sch.id' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center shrink-0">
                            ⏰
                        </div>
                        <div>
                            <strong class="block text-slate-900 font-bold text-xs uppercase text-slate-400">Jam Layanan Pelayanan Tata Usaha</strong>
                            <p class="mt-0.5">Senin - Kamis: 07.00 - 14.30 WIB<br>Jumat: 07.00 - 11.30 WIB<br>Sabtu: 07.00 - 13.00 WIB</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="lg:col-span-7">
            <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-xs">
                <h3 class="text-xl font-extrabold text-slate-900 mb-1">Kirim Pesan / Pengaduan</h3>
                <p class="text-xs text-slate-500 mb-6">Silakan isi formulir di bawah ini, tim staf kami akan segera merespons pesan Anda.</p>

                <form method="POST" action="{{ route('kontak.submit') }}" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Lengkap</label>
                            <input type="text" name="name" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none" placeholder="Masukkan nama Anda">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Alamat Email</label>
                            <input type="email" name="email" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none" placeholder="nama@email.com">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Subjek / Keperluan</label>
                        <input type="text" name="subject" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none" placeholder="Contoh: Informasi Pendaftaran PPDB">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Pesan Lengkap</label>
                        <textarea name="message" rows="5" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none" placeholder="Tuliskan pesan atau pertanyaan Anda secara rinci..."></textarea>
                    </div>
                    <button type="submit" class="w-full sm:w-auto px-8 py-3 rounded-xl bg-blue-900 hover:bg-blue-800 text-white font-bold text-xs shadow-md transition-colors">
                        Kirim Pesan Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
