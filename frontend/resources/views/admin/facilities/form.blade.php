@extends('layouts.admin')

@section('title', isset($facility) ? 'Sunting Fasilitas' : 'Tambah Fasilitas')
@section('page_title', isset($facility) ? 'Sunting Data Fasilitas' : 'Tambah Fasilitas Baru')
@section('page_subtitle', 'Kelola informasi sarana, prasarana, dan ruang belajar')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-900">{{ isset($facility) ? 'Sunting Fasilitas' : 'Formulir Fasilitas Baru' }}</h2>
            <a href="{{ route('admin.fasilitas.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar
            </a>
        </div>

        <form action="{{ isset($facility) ? route('admin.fasilitas.update', $facility['id']) : route('admin.fasilitas.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6 text-xs">
            @csrf
            @if(isset($facility))
                @method('PUT')
            @endif

            <!-- Nama Fasilitas -->
            <div>
                <label for="name" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Nama Sarana / Prasarana <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $facility['name'] ?? '') }}" required placeholder="Contoh: Laboratorium Komputer & TIK, Perpustakaan 'Cahaya Ilmu'" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm font-medium">
            </div>

            <!-- Jumlah & Kondisi -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="quantity" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Jumlah Unit / Ruang</label>
                    <input type="number" id="quantity" name="quantity" value="{{ old('quantity', $facility['quantity'] ?? 1) }}" min="0" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-semibold">
                </div>

                <div>
                    <label for="condition_status" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Kondisi Fisik <span class="text-red-500">*</span></label>
                    <select id="condition_status" name="condition_status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-semibold">
                        <option value="baik" {{ old('condition_status', $facility['condition_status'] ?? 'baik') === 'baik' ? 'selected' : '' }}>Baik & Siap Digunakan</option>
                        <option value="rusak_ringan" {{ old('condition_status', $facility['condition_status'] ?? '') === 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan (Dalam Perawatan)</option>
                        <option value="rusak_berat" {{ old('condition_status', $facility['condition_status'] ?? '') === 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                </div>
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="description" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Deskripsi & Kelengkapan Alat</label>
                <textarea id="description" name="description" rows="5" placeholder="Penjelasan mengenai kapasitas ruang, perlengkapan, dan peruntukan pembelajaran..." class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-normal leading-relaxed">{{ old('description', $facility['description'] ?? '') }}</textarea>
            </div>

            <!-- Foto Fasilitas -->
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Foto / Dokumentasi Fasilitas</label>
                @if(!empty($facility['image']))
                <div class="mb-3 flex items-center gap-4 p-3 bg-slate-50 rounded-xl border border-slate-200">
                    <img src="{{ \App\Services\ApiClient::assetUrl($facility['image']) }}" alt="Foto Saat Ini" class="w-24 h-16 object-cover rounded-lg border border-slate-200">
                    <div>
                        <span class="text-xs font-bold text-slate-800 block">Foto Saat Ini Terpasang</span>
                        <span class="text-[11px] text-slate-500">Pilih berkas baru di bawah jika ingin mengganti</span>
                    </div>
                </div>
                @endif
                <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp" class="w-full px-3 py-2 border border-slate-200 rounded-xl bg-slate-50 text-slate-600 text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                <p class="text-[11px] text-slate-400 mt-1">Format: JPG, PNG, WEBP. Maksimum: 3 MB.</p>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.fasilitas.index') }}" class="px-5 py-2.5 border border-slate-200 rounded-xl font-bold text-slate-600 hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Fasilitas
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
