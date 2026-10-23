@extends('layouts.admin')

@section('title', isset($achievement) ? 'Sunting Prestasi' : 'Tambah Prestasi Baru')
@section('page_title', isset($achievement) ? 'Sunting Prestasi' : 'Tambah Prestasi Baru')
@section('page_subtitle', 'Dokumentasikan prestasi dan kebanggaan siswa SMPN 2 Juwangi')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-900">{{ isset($achievement) ? 'Sunting Data Prestasi' : 'Formulir Prestasi Baru' }}</h2>
            <a href="{{ route('admin.prestasi.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar
            </a>
        </div>

        <form action="{{ isset($achievement) ? route('admin.prestasi.update', $achievement['id']) : route('admin.prestasi.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6 text-xs">
            @csrf
            @if(isset($achievement))
                @method('PUT')
            @endif

            <!-- Judul Prestasi -->
            <div>
                <label for="title" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Nama Prestasi / Raihan <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title', $achievement['title'] ?? '') }}" required placeholder="Contoh: Juara 1 Lomba OSN Matematika Tingkat Kabupaten" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm font-medium">
            </div>

            <!-- Tingkat & Tahun -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="level" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Tingkat Kejuaraan <span class="text-red-500">*</span></label>
                    <select id="level" name="level" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-semibold">
                        <option value="kecamatan" {{ old('level', $achievement['level'] ?? '') === 'kecamatan' ? 'selected' : '' }}>Kecamatan</option>
                        <option value="kabupaten" {{ old('level', $achievement['level'] ?? 'kabupaten') === 'kabupaten' ? 'selected' : '' }}>Kabupaten</option>
                        <option value="provinsi" {{ old('level', $achievement['level'] ?? '') === 'provinsi' ? 'selected' : '' }}>Provinsi</option>
                        <option value="nasional" {{ old('level', $achievement['level'] ?? '') === 'nasional' ? 'selected' : '' }}>Nasional</option>
                        <option value="internasional" {{ old('level', $achievement['level'] ?? '') === 'internasional' ? 'selected' : '' }}>Internasional</option>
                    </select>
                </div>

                <div>
                    <label for="year" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Tahun Peraihan <span class="text-red-500">*</span></label>
                    <input type="number" id="year" name="year" value="{{ old('year', $achievement['year'] ?? date('Y')) }}" required min="2000" max="{{ date('Y') + 1 }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-semibold">
                </div>
            </div>

            <!-- Nama Siswa & Nama Event -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="student_name" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Nama Siswa / Tim Peraih</label>
                    <input type="text" id="student_name" name="student_name" value="{{ old('student_name', $achievement['student_name'] ?? '') }}" placeholder="Contoh: Ahmad Rizki (Kelas 8B)" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-medium">
                </div>

                <div>
                    <label for="event_name" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Nama Kegiatan / Ajang Lomba</label>
                    <input type="text" id="event_name" name="event_name" value="{{ old('event_name', $achievement['event_name'] ?? '') }}" placeholder="Contoh: Olimpiade Sains Nasional (OSN) 2026" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-medium">
                </div>
            </div>

            <!-- Medali & Keterangan -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="medal" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Medali / Predikat</label>
                    <input type="text" id="medal" name="medal" value="{{ old('medal', $achievement['medal'] ?? '') }}" placeholder="Contoh: Juara 1 / Medali Emas / Juara Harapan" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Foto / Dokumentasi Piagam</label>
                    <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp" class="w-full px-3 py-2 border border-slate-200 rounded-xl bg-slate-50 text-slate-600 text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                </div>
            </div>

            <!-- Preview Image if exists -->
            @if(!empty($achievement['image']))
            <div class="flex items-center gap-4 p-3 bg-slate-50 rounded-xl border border-slate-200">
                <img src="{{ \App\Services\ApiClient::assetUrl($achievement['image']) }}" alt="Foto Saat Ini" class="w-20 h-16 object-cover rounded-lg border border-slate-200">
                <div>
                    <span class="text-xs font-bold text-slate-800 block">Dokumentasi Saat Ini Terpasang</span>
                    <span class="text-[11px] text-slate-500">Unggah berkas baru di atas jika ingin mengganti</span>
                </div>
            </div>
            @endif

            <!-- Deskripsi Singkat -->
            <div>
                <label for="description" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Deskripsi / Catatan Tambahan</label>
                <textarea id="description" name="description" rows="4" placeholder="Detail capaian atau pembimbing kejuaraan..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-normal">{{ old('description', $achievement['description'] ?? '') }}</textarea>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.prestasi.index') }}" class="px-5 py-2.5 border border-slate-200 rounded-xl font-bold text-slate-600 hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Prestasi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
