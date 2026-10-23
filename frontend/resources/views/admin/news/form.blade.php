@extends('layouts.admin')

@section('title', isset($post) ? 'Sunting Berita' : 'Tulis Berita Baru')
@section('page_title', isset($post) ? 'Sunting Berita' : 'Tulis Berita Baru')
@section('page_subtitle', 'Kelola informasi publikasi kabar dan agenda SMPN 2 Juwangi')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-900">{{ isset($post) ? 'Sunting Data Berita' : 'Formulir Berita Baru' }}</h2>
            <a href="{{ route('admin.berita.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar
            </a>
        </div>

        <form action="{{ isset($post) ? route('admin.berita.update', $post['id']) : route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6 text-xs">
            @csrf
            @if(isset($post))
                @method('PUT')
            @endif

            <!-- Judul -->
            <div>
                <label for="title" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Judul Berita <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title', $post['title'] ?? '') }}" required placeholder="Contoh: Peringatan Hari Pendidikan Nasional di SMPN 2 Juwangi" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm font-medium">
            </div>

            <!-- Kategori & Status -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="category_id" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Kategori Berita <span class="text-red-500">*</span></label>
                    <select id="category_id" name="category_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-semibold">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                        <option value="{{ $category['id'] }}" {{ old('category_id', $post['category_id'] ?? '') == $category['id'] ? 'selected' : '' }}>
                            {{ $category['name'] }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="status" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Status Publikasi <span class="text-red-500">*</span></label>
                    <select id="status" name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-semibold">
                        <option value="published" {{ old('status', $post['status'] ?? 'published') === 'published' ? 'selected' : '' }}>Publikasikan (Terbit)</option>
                        <option value="draft" {{ old('status', $post['status'] ?? '') === 'draft' ? 'selected' : '' }}>Simpan sebagai Draf</option>
                    </select>
                </div>
            </div>

            <!-- Ringkasan Singkat (Excerpt) -->
            <div>
                <label for="excerpt" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Ringkasan / Sinopsis Singkat</label>
                <textarea id="excerpt" name="excerpt" rows="2" placeholder="Ringkasan 1-2 kalimat untuk preview di beranda atau kartu berita..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-normal">{{ old('excerpt', $post['excerpt'] ?? '') }}</textarea>
            </div>

            <!-- Konten Lengkap -->
            <div>
                <label for="content" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Isi Berita Lengkap <span class="text-red-500">*</span></label>
                <textarea id="content" name="content" rows="10" required placeholder="Tuliskan isi berita secara lengkap di sini..." class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-normal leading-relaxed">{{ old('content', $post['content'] ?? '') }}</textarea>
            </div>

            <!-- Gambar Sampul -->
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Gambar Sampul (Cover Image)</label>
                @if(!empty($post['cover_image']))
                <div class="mb-3 flex items-center gap-4 p-3 bg-slate-50 rounded-xl border border-slate-200">
                    <img src="{{ \App\Services\ApiClient::assetUrl($post['cover_image']) }}" alt="Cover Saat Ini" class="w-24 h-16 object-cover rounded-lg border border-slate-200">
                    <div>
                        <span class="text-xs font-bold text-slate-800 block">Gambar Sampul Saat Ini</span>
                        <span class="text-[11px] text-slate-500">Unggah berkas baru di bawah jika ingin mengganti</span>
                    </div>
                </div>
                @endif
                <input type="file" id="cover_image" name="cover_image" accept="image/jpeg,image/png,image/webp" class="w-full px-3 py-2 border border-slate-200 rounded-xl bg-slate-50 text-slate-600 text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                <p class="text-[11px] text-slate-400 mt-1">Format: JPG, PNG, WEBP. Maksimum ukuran file: 3 MB.</p>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.berita.index') }}" class="px-5 py-2.5 border border-slate-200 rounded-xl font-bold text-slate-600 hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Berita
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
