@extends('layouts.admin')

@section('title', isset($announcement) ? 'Sunting Pengumuman' : 'Buat Pengumuman Baru')
@section('page_title', isset($announcement) ? 'Sunting Pengumuman' : 'Buat Pengumuman Baru')
@section('page_subtitle', 'Publikasikan pengumuman penting bagi seluruh civitas akademika')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-900">{{ isset($announcement) ? 'Sunting Data Pengumuman' : 'Formulir Pengumuman Baru' }}</h2>
            <a href="{{ route('admin.pengumuman.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar
            </a>
        </div>

        <form action="{{ isset($announcement) ? route('admin.pengumuman.update', $announcement['id']) : route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6 text-xs">
            @csrf
            @if(isset($announcement))
                @method('PUT')
            @endif

            <!-- Judul -->
            <div>
                <label for="title" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Judul Pengumuman <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title', $announcement['title'] ?? '') }}" required placeholder="Contoh: Pengumuman Libur Hari Raya & Jadwal Masuk Sekolah" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm font-medium">
            </div>

            <!-- Status & Prioritas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="status" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Status Publikasi <span class="text-red-500">*</span></label>
                    <select id="status" name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-semibold">
                        <option value="published" {{ old('status', $announcement['status'] ?? 'published') === 'published' ? 'selected' : '' }}>Publikasikan (Terbit)</option>
                        <option value="draft" {{ old('status', $announcement['status'] ?? '') === 'draft' ? 'selected' : '' }}>Simpan sebagai Draf</option>
                    </select>
                </div>

                <div>
                    <label for="priority" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Tingkat Prioritas</label>
                    <select id="priority" name="priority" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-semibold">
                        <option value="0" {{ old('priority', $announcement['priority'] ?? 0) == 0 ? 'selected' : '' }}>Normal (Standar)</option>
                        <option value="1" {{ old('priority', $announcement['priority'] ?? 0) > 0 ? 'selected' : '' }}>Penting / Disematkan di Atas</option>
                    </select>
                </div>
            </div>

            <!-- Isi Pengumuman -->
            <div>
                <label for="content" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Isi Pengumuman Lengkap <span class="text-red-500">*</span></label>
                <textarea id="content" name="content" rows="8" required placeholder="Tuliskan isi pengumuman secara rinci di sini..." class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-normal leading-relaxed">{{ old('content', $announcement['content'] ?? '') }}</textarea>
            </div>

            <!-- Berkas Lampiran -->
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Lampiran Berkas (Opsional, PDF / Gambar)</label>
                @if(!empty($announcement['attachment']))
                <div class="mb-3 flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-200">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                    <div class="grow">
                        <span class="text-xs font-bold text-slate-800 block">Berkas Lampiran Saat Ini Terpasang</span>
                        <a href="{{ \App\Services\ApiClient::assetUrl($announcement['attachment']) }}" target="_blank" class="text-[11px] text-blue-600 hover:underline">Lihat / Unduh Berkas</a>
                    </div>
                </div>
                @endif
                <input type="file" id="attachment" name="attachment" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="w-full px-3 py-2 border border-slate-200 rounded-xl bg-slate-50 text-slate-600 text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                <p class="text-[11px] text-slate-400 mt-1">Format: PDF, Word, JPG, PNG. Maksimum ukuran file: 5 MB.</p>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.pengumuman.index') }}" class="px-5 py-2.5 border border-slate-200 rounded-xl font-bold text-slate-600 hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Pengumuman
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
