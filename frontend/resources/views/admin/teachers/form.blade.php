@extends('layouts.admin')

@section('title', isset($teacher) ? 'Sunting Guru & Staf' : 'Tambah Guru & Staf')
@section('page_title', isset($teacher) ? 'Sunting Data Guru & Staf' : 'Tambah Guru & Staf')
@section('page_subtitle', 'Kelola informasi profil tenaga pendidik dan kependidikan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-900">{{ isset($teacher) ? 'Sunting Data Pendidik' : 'Formulir Pendidik Baru' }}</h2>
            <a href="{{ route('admin.guru.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar
            </a>
        </div>

        <form action="{{ isset($teacher) ? route('admin.guru.update', $teacher['id']) : route('admin.guru.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6 text-xs">
            @csrf
            @if(isset($teacher))
                @method('PUT')
            @endif

            <!-- Nama & Tipe -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Nama Lengkap & Gelar <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $teacher['name'] ?? '') }}" required placeholder="Contoh: Budi Santoso, S.Pd." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-medium">
                </div>

                <div>
                    <label for="type" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Jenis Tenaga Pendidik <span class="text-red-500">*</span></label>
                    <select id="type" name="type" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-semibold">
                        <option value="guru" {{ old('type', $teacher['type'] ?? 'guru') === 'guru' ? 'selected' : '' }}>Guru Pengajar</option>
                        <option value="tendik" {{ old('type', $teacher['type'] ?? '') === 'tendik' ? 'selected' : '' }}>Tenaga Kependidikan / Staf TU</option>
                    </select>
                </div>
            </div>

            <!-- NIP & Jabatan -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="nip" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Nomor Induk Pegawai (NIP)</label>
                    <input type="text" id="nip" name="nip" value="{{ old('nip', $teacher['nip'] ?? '') }}" placeholder="Isi NIP atau - jika belum ber-NIP" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-medium">
                </div>

                <div>
                    <label for="position" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Jabatan / Tugas Tambahan</label>
                    <input type="text" id="position" name="position" value="{{ old('position', $teacher['position'] ?? '') }}" placeholder="Contoh: Guru Matematika / Waka Kesiswaan / Staf Tata Usaha" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-medium">
                </div>
            </div>

            <!-- Mapel & Email -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="subject" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Mata Pelajaran yang Diampu</label>
                    <input type="text" id="subject" name="subject" value="{{ old('subject', $teacher['subject'] ?? '') }}" placeholder="Contoh: Matematika, Bahasa Indonesia" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-medium">
                </div>

                <div>
                    <label for="email" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Alamat Email Resmi</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $teacher['email'] ?? '') }}" placeholder="nama@smpn2juwangi.sch.id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-medium">
                </div>
            </div>

            <!-- Foto -->
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Pas Foto Resmi Pendidik</label>
                @if(!empty($teacher['photo']))
                <div class="mb-3 flex items-center gap-4 p-3 bg-slate-50 rounded-xl border border-slate-200">
                    <img src="{{ \App\Services\ApiClient::assetUrl($teacher['photo']) }}" alt="Foto Saat Ini" class="w-16 h-20 object-cover rounded-lg border border-slate-200 shadow-xs">
                    <div>
                        <span class="text-xs font-bold text-slate-800 block">Foto Saat Ini Terpasang</span>
                        <span class="text-[11px] text-slate-500">Pilih berkas baru jika ingin memperbarui foto</span>
                    </div>
                </div>
                @endif
                <input type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/webp" class="w-full px-3 py-2 border border-slate-200 rounded-xl bg-slate-50 text-slate-600 text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                <p class="text-[11px] text-slate-400 mt-1">Format: JPG, PNG, WEBP. Maksimum ukuran: 3 MB.</p>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.guru.index') }}" class="px-5 py-2.5 border border-slate-200 rounded-xl font-bold text-slate-600 hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Data Pendidik
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
