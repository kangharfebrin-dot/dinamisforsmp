@extends('layouts.admin')

@section('title', isset($page) ? 'Sunting Halaman' : 'Buat Halaman Baru')
@section('page_title', isset($page) ? 'Sunting Halaman' : 'Buat Halaman Baru')
@section('page_subtitle', 'Pengelolaan halaman dinamis dan informasi PPDB')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-900">{{ isset($page) ? 'Sunting Data Halaman' : 'Formulir Halaman Baru' }}</h2>
            <a href="{{ route('admin.halaman.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar
            </a>
        </div>

        <form action="{{ isset($page) ? route('admin.halaman.update', $page['id']) : route('admin.halaman.store') }}" method="POST" class="p-6 space-y-6 text-xs">
            @csrf
            @if(isset($page))
                @method('PUT')
            @endif

            <!-- Judul Halaman -->
            <div>
                <label for="title" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Judul Halaman <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title', $page['title'] ?? '') }}" required placeholder="Contoh: Informasi & Syarat PPDB 2026/2027" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm font-medium">
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Status Publikasi <span class="text-red-500">*</span></label>
                <select id="status" name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-semibold">
                    <option value="published" {{ old('status', $page['status'] ?? 'published') === 'published' ? 'selected' : '' }}>Publikasikan (Terbit)</option>
                    <option value="draft" {{ old('status', $page['status'] ?? '') === 'draft' ? 'selected' : '' }}>Simpan sebagai Draf</option>
                </select>
            </div>

            <!-- Konten Lengkap -->
            <div>
                <label for="content" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Isi Konten Halaman <span class="text-red-500">*</span></label>
                <textarea id="content" name="content" rows="12" required placeholder="Tuliskan isi informasi lengkap di sini (mendukung format HTML atau teks rapi)..." class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-normal leading-relaxed">{{ old('content', $page['content'] ?? '') }}</textarea>
            </div>

            <!-- Meta Title & Description (SEO) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="meta_title" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Judul Meta (SEO Title)</label>
                    <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $page['meta_title'] ?? '') }}" placeholder="Judul untuk mesin pencari..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-medium">
                </div>

                <div>
                    <label for="meta_description" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Deskripsi Meta (SEO Description)</label>
                    <input type="text" id="meta_description" name="meta_description" value="{{ old('meta_description', $page['meta_description'] ?? '') }}" placeholder="Deskripsi ringkas untuk pencarian..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-medium">
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.halaman.index') }}" class="px-5 py-2.5 border border-slate-200 rounded-xl font-bold text-slate-600 hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Halaman
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
