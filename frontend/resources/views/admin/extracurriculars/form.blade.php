@extends('layouts.admin')

@section('title', isset($extracurricular) ? 'Sunting Ekstrakurikuler' : 'Tambah Ekstrakurikuler')
@section('page_title', isset($extracurricular) ? 'Sunting Data Ekstrakurikuler' : 'Tambah Ekstrakurikuler Baru')
@section('page_subtitle', 'Kelola informasi kegiatan ekstrakurikuler siswa')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-900">{{ isset($extracurricular) ? 'Sunting Ekstrakurikuler' : 'Formulir Ekstrakurikuler Baru' }}</h2>
            <a href="{{ route('admin.ekstrakurikuler.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar
            </a>
        </div>

        <form action="{{ isset($extracurricular) ? route('admin.ekstrakurikuler.update', $extracurricular['id']) : route('admin.ekstrakurikuler.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6 text-xs">
            @csrf
            @if(isset($extracurricular))
                @method('PUT')
            @endif

            <!-- Nama Ekskul -->
            <div>
                <label for="name" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Nama Kegiatan Ekstrakurikuler <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $extracurricular['name'] ?? '') }}" required placeholder="Contoh: Pramuka, Palang Merah Remaja (PMR), Bola Voli" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm font-medium">
            </div>

            <!-- Pembina & Jadwal -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="coach_name" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Nama Pembina / Pelatih</label>
                    <input type="text" id="coach_name" name="coach_name" value="{{ old('coach_name', $extracurricular['coach_name'] ?? '') }}" placeholder="Contoh: Suwandi, S.Pd." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-medium">
                </div>

                <div>
                    <label for="schedule" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Jadwal Hari & Jam Latihan</label>
                    <input type="text" id="schedule" name="schedule" value="{{ old('schedule', $extracurricular['schedule'] ?? '') }}" placeholder="Contoh: Jumat, 14.00 - 16.00 WIB" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-medium">
                </div>
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="description" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Deskripsi Kegiatan</label>
                <textarea id="description" name="description" rows="5" placeholder="Penjelasan mengenai fokus pembinaan, aktivitas mingguan, dan prestasi ekskul..." class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-normal leading-relaxed">{{ old('description', $extracurricular['description'] ?? '') }}</textarea>
            </div>

            <!-- Gambar / Foto Dokumentasi -->
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Foto / Dokumentasi Ekstrakurikuler</label>
                @if(!empty($extracurricular['image']))
                <div class="mb-3 flex items-center gap-4 p-3 bg-slate-50 rounded-xl border border-slate-200">
                    <img src="{{ \App\Services\ApiClient::assetUrl($extracurricular['image']) }}" alt="Foto Saat Ini" class="w-24 h-16 object-cover rounded-lg border border-slate-200">
                    <div>
                        <span class="text-xs font-bold text-slate-800 block">Dokumentasi Saat Ini Terpasang</span>
                        <span class="text-[11px] text-slate-500">Unggah berkas baru di bawah jika ingin mengganti</span>
                    </div>
                </div>
                @endif
                <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp" class="w-full px-3 py-2 border border-slate-200 rounded-xl bg-slate-50 text-slate-600 text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                <p class="text-[11px] text-slate-400 mt-1">Format: JPG, PNG, WEBP. Maksimum: 3 MB.</p>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.ekstrakurikuler.index') }}" class="px-5 py-2.5 border border-slate-200 rounded-xl font-bold text-slate-600 hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Ekstrakurikuler
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
