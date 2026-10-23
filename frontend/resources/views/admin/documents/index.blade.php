@extends('layouts.admin')

@section('title', 'Kelola Dokumen Unduhan')
@section('page_title', 'Dokumen & Berkas Unduhan')
@section('page_subtitle', 'Kelola formulir, silabus, juknis, materi ajar, dan berkas PPDB resmi')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Form Unggah Dokumen -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6 h-fit text-xs">
        <h2 class="text-sm font-bold text-slate-900 mb-1">Unggah Dokumen Baru</h2>
        <p class="text-slate-500 mb-4">Unggah berkas untuk dapat diunduh oleh publik, siswa, atau guru.</p>

        <form action="{{ route('admin.dokumen.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label for="title" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1.5">Judul Dokumen <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" required placeholder="Contoh: Formulir Pendaftaran PPDB 2026/2027" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-medium">
            </div>

            <div>
                <label for="category" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1.5">Kategori Dokumen</label>
                <select id="category" name="category" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 text-xs font-semibold">
                    <option value="PPDB">PPDB (Penerimaan Siswa)</option>
                    <option value="Akademik">Akademik & Kurikulum</option>
                    <option value="Kesiswaan">Kesiswaan & Ekstrakurikuler</option>
                    <option value="Tata Tertib">Tata Tertib & Peraturan</option>
                    <option value="Umum" selected>Umum</option>
                </select>
            </div>

            <div>
                <label for="file" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1.5">Pilih Berkas Dokumen <span class="text-red-500">*</span></label>
                <input type="file" id="file" name="file" required accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar" class="w-full text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                <p class="text-[10px] text-slate-400 mt-1">Format: PDF, DOC, XLS, ZIP. Maks: 10 MB.</p>
            </div>

            <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-sm transition-colors flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Unggah Dokumen
            </button>
        </form>
    </div>

    <!-- Table Daftar Dokumen -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-sm font-bold text-slate-900">Daftar Dokumen Tersimpan</h2>
            <span class="text-xs text-slate-500 font-semibold">{{ count($documents) }} berkas</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 font-extrabold uppercase tracking-wider text-[11px]">
                        <th class="py-3.5 px-6">Judul Dokumen</th>
                        <th class="py-3.5 px-6">Kategori</th>
                        <th class="py-3.5 px-6">Ukuran</th>
                        <th class="py-3.5 px-6">Diunduh</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    @forelse($documents as $doc)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-2.5">
                                <svg class="w-6 h-6 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                <div>
                                    <span class="font-bold text-slate-900 block truncate max-w-xs">{{ $doc['title'] }}</span>
                                    <a href="{{ \App\Services\ApiClient::assetUrl($doc['file_path']) }}" target="_blank" class="text-[11px] text-blue-600 hover:underline">Unduh Berkas</a>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg text-[11px] font-semibold">
                                {{ $doc['category'] ?? 'Umum' }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-slate-500">
                            {{ isset($doc['file_size']) ? number_format($doc['file_size'] / 1024, 1) . ' KB' : '-' }}
                        </td>
                        <td class="py-4 px-6 text-slate-800 font-semibold">
                            {{ number_format($doc['download_count'] ?? 0) }}x
                        </td>
                        <td class="py-4 px-6 text-right">
                            <form action="{{ route('admin.dokumen.destroy', $doc['id']) }}" method="POST" onsubmit="return confirm('Hapus dokumen ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-slate-400">
                            Belum ada dokumen yang diunggah.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
