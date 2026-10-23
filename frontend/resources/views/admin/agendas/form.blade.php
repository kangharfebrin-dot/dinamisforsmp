@extends('layouts.admin')

@section('title', isset($agenda) ? 'Sunting Agenda' : 'Tambah Agenda Baru')
@section('page_title', isset($agenda) ? 'Sunting Agenda' : 'Tambah Agenda Baru')
@section('page_subtitle', 'Kelola jadwal kegiatan dan agenda sekolah')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-900">{{ isset($agenda) ? 'Sunting Data Agenda' : 'Formulir Agenda Baru' }}</h2>
            <a href="{{ route('admin.agenda.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar
            </a>
        </div>

        <form action="{{ isset($agenda) ? route('admin.agenda.update', $agenda['id']) : route('admin.agenda.store') }}" method="POST" class="p-6 space-y-6 text-xs">
            @csrf
            @if(isset($agenda))
                @method('PUT')
            @endif

            <!-- Judul Kegiatan -->
            <div>
                <label for="title" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Nama / Judul Kegiatan <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title', $agenda['title'] ?? '') }}" required placeholder="Contoh: Asesmen Sumatif Akhir Semester Genap" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm font-medium">
            </div>

            <!-- Tanggal & Waktu Mulai & Selesai -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="start_at" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Waktu Mulai <span class="text-red-500">*</span></label>
                    <input type="datetime-local" id="start_at" name="start_at" value="{{ old('start_at', isset($agenda['start_at']) ? date('Y-m-d\TH:i', strtotime($agenda['start_at'])) : '') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-semibold">
                </div>

                <div>
                    <label for="end_at" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Waktu Selesai (Opsional)</label>
                    <input type="datetime-local" id="end_at" name="end_at" value="{{ old('end_at', isset($agenda['end_at']) ? date('Y-m-d\TH:i', strtotime($agenda['end_at'])) : '') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-semibold">
                </div>
            </div>

            <!-- Lokasi & Status -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="location" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Lokasi / Tempat Pelaksanaan</label>
                    <input type="text" id="location" name="location" value="{{ old('location', $agenda['location'] ?? 'SMPN 2 Juwangi') }}" placeholder="Contoh: Aula Sekolah, Lapangan Utama" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-medium">
                </div>

                <div>
                    <label for="status" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Status Publikasi <span class="text-red-500">*</span></label>
                    <select id="status" name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-semibold">
                        <option value="published" {{ old('status', $agenda['status'] ?? 'published') === 'published' ? 'selected' : '' }}>Publikasikan (Terbit)</option>
                        <option value="draft" {{ old('status', $agenda['status'] ?? '') === 'draft' ? 'selected' : '' }}>Simpan sebagai Draf</option>
                    </select>
                </div>
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="description" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-2">Deskripsi / Detail Rangkaian Kegiatan</label>
                <textarea id="description" name="description" rows="5" placeholder="Penjelasan mengenai agenda kegiatan, perlengkapan yang perlu dibawa, dll..." class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-normal leading-relaxed">{{ old('description', $agenda['description'] ?? '') }}</textarea>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.agenda.index') }}" class="px-5 py-2.5 border border-slate-200 rounded-xl font-bold text-slate-600 hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Agenda
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
