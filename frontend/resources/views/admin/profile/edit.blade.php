@extends('layouts.admin')

@section('title', 'Identitas & Profil Sekolah')
@section('page_title', 'Profil & Identitas Sekolah')
@section('page_subtitle', 'Kelola data pokok sekolah, kontak, visi misi, foto kepala sekolah, dan banner')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-900">Pengaturan Identitas Sekolah</h2>
                <p class="text-xs text-slate-500 mt-0.5">Seluruh perubahan akan langsung diterapkan pada seluruh halaman publik website</p>
            </div>
            <span class="px-3 py-1 bg-blue-50 border border-blue-200 text-blue-700 font-extrabold text-[11px] rounded-lg">
                NPSN Terverifikasi: 20308482
            </span>
        </div>

        <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-8 text-xs">
            @csrf
            @method('PUT')

            <!-- Bagian 1: Data Pokok Sekolah -->
            <div>
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-400 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    1. Data Pokok & Identitas
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Nama Resmi Sekolah <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $profile['name'] ?? 'SMP Negeri 2 Juwangi') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 text-xs font-semibold">
                    </div>

                    <div>
                        <label for="npsn" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Nomor Pokok Sekolah Nasional (NPSN) <span class="text-red-500">*</span></label>
                        <input type="text" id="npsn" name="npsn" value="{{ old('npsn', $profile['npsn'] ?? '20308482') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 text-xs font-semibold">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="tagline" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Slogan / Tagline Sekolah</label>
                        <input type="text" id="tagline" name="tagline" value="{{ old('tagline', $profile['tagline'] ?? 'Berkarakter, Unggul, dan Berwawasan Lingkungan') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 text-xs font-medium">
                    </div>
                </div>
            </div>

            <!-- Bagian 2: Kontak & Alamat -->
            <div>
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-400 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    2. Kontak & Lokasi
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="email" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Email Resmi Sekolah</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $profile['email'] ?? 'smpn2juwang@gmail.com') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 text-xs font-medium">
                    </div>

                    <div>
                        <label for="phone" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Nomor Telepon / Kontak</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $profile['phone'] ?? '085642696466') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 text-xs font-medium">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="address" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Alamat Lengkap</label>
                        <textarea id="address" name="address" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 text-xs font-normal">{{ old('address', $profile['address'] ?? 'Jl. Kayen Baru No. 1, Desa Kayen, Kec. Juwangi, Kab. Boyolali, Jawa Tengah 57391') }}</textarea>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="maps_url" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Embed Google Maps URL / Iframe Link</label>
                        <input type="text" id="maps_url" name="maps_url" value="{{ old('maps_url', $profile['maps_url'] ?? '') }}" placeholder="https://www.google.com/maps/embed?..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 text-xs font-mono">
                    </div>
                </div>
            </div>

            <!-- Bagian 3: Media & Gambar -->
            <div>
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-400 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    3. Berkas Media (Logo & Banner)
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Logo -->
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50">
                        <label class="block font-bold text-slate-800 text-xs mb-2">Logo Resmi Sekolah</label>
                        @if(!empty($profile['logo']))
                        <div class="mb-3 flex items-center gap-3">
                            <img src="{{ \App\Services\ApiClient::assetUrl($profile['logo']) }}" alt="Logo" class="w-16 h-16 object-contain bg-white rounded-lg p-1 border border-slate-200">
                            <span class="text-[11px] text-slate-500">Logo saat ini terpasang</span>
                        </div>
                        @endif
                        <input type="file" id="logo" name="logo" accept="image/*" class="w-full text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                    </div>

                    <!-- Hero Banner -->
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50">
                        <label class="block font-bold text-slate-800 text-xs mb-2">Banner Utama (Hero Banner)</label>
                        @if(!empty($profile['hero_banner']))
                        <div class="mb-3 flex items-center gap-3">
                            <img src="{{ \App\Services\ApiClient::assetUrl($profile['hero_banner']) }}" alt="Banner" class="w-24 h-14 object-cover rounded-lg border border-slate-200">
                            <span class="text-[11px] text-slate-500">Banner saat ini terpasang</span>
                        </div>
                        @endif
                        <input type="file" id="hero_banner" name="hero_banner" accept="image/*" class="w-full text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                    </div>
                </div>
            </div>

            <!-- Bagian 4: Kepala Sekolah & Sambutan -->
            <div>
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-400 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    4. Pimpinan Sekolah & Sambutan
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div>
                        <label for="principal_name" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Nama Kepala Sekolah</label>
                        <input type="text" id="principal_name" name="principal_name" value="{{ old('principal_name', $profile['principal_name'] ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 text-xs font-medium">
                    </div>

                    <div>
                        <label for="principal_nip" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">NIP Kepala Sekolah</label>
                        <input type="text" id="principal_nip" name="principal_nip" value="{{ old('principal_nip', $profile['principal_nip'] ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 text-xs font-medium">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Foto Kepala Sekolah</label>
                        <input type="file" id="principal_photo" name="principal_photo" accept="image/*" class="w-full text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                    </div>

                    <div class="sm:col-span-3">
                        <label for="principal_message" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Pesan & Sambutan Kepala Sekolah</label>
                        <textarea id="principal_message" name="principal_message" rows="6" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 text-xs font-normal leading-relaxed">{{ old('principal_message', $profile['principal_message'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Bagian 5: Visi, Misi, Sejarah -->
            <div>
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-400 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    5. Visi, Misi & Sejarah Singkat
                </h3>
                <div class="space-y-6">
                    <div>
                        <label for="vision" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Visi Sekolah</label>
                        <textarea id="vision" name="vision" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 text-xs font-normal leading-relaxed">{{ old('vision', $profile['vision'] ?? '') }}</textarea>
                    </div>

                    <div>
                        <label for="mission" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Misi Sekolah</label>
                        <textarea id="mission" name="mission" rows="5" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 text-xs font-normal leading-relaxed">{{ old('mission', $profile['mission'] ?? '') }}</textarea>
                    </div>

                    <div>
                        <label for="history" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Sejarah Singkat Pendirian Sekolah</label>
                        <textarea id="history" name="history" rows="5" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 text-xs font-normal leading-relaxed">{{ old('history', $profile['history'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Seluruh Perubahan Identitas Sekolah
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
