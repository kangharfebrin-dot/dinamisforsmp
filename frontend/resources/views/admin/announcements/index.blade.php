@extends('layouts.admin')

@section('title', 'Kelola Pengumuman')
@section('page_title', 'Pengumuman Sekolah')
@section('page_subtitle', 'Informasi resmi dan penting untuk siswa, guru, dan wali murid')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
        <div>
            <h2 class="text-base font-bold text-slate-900">Daftar Pengumuman</h2>
            <p class="text-xs text-slate-500 mt-0.5">Pengumuman penting yang ditampilkan di website sekolah</p>
        </div>
        <a href="{{ route('admin.pengumuman.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Pengumuman Baru
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 font-extrabold uppercase tracking-wider text-[11px]">
                        <th class="py-3.5 px-6">Judul Pengumuman</th>
                        <th class="py-3.5 px-6">Prioritas</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6">Lampiran</th>
                        <th class="py-3.5 px-6">Tanggal Dibuat</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    @forelse($announcements as $item)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="py-4 px-6">
                            <span class="font-bold text-slate-900 block truncate max-w-xs sm:max-w-md">{{ $item['title'] }}</span>
                            <span class="text-[11px] text-slate-400 font-normal">Slug: {{ $item['slug'] ?? '-' }}</span>
                        </td>
                        <td class="py-4 px-6">
                            @if(($item['priority'] ?? 0) > 0)
                            <span class="px-2.5 py-1 bg-amber-50 text-amber-800 border border-amber-200 rounded-lg text-[11px] font-bold inline-flex items-center gap-1">
                                <svg class="w-3 h-3 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                Penting
                            </span>
                            @else
                            <span class="text-slate-400">Normal</span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            @if(($item['status'] ?? '') === 'published')
                            <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg text-[11px] font-bold">Terbit</span>
                            @else
                            <span class="px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded-lg text-[11px] font-bold">Draf</span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            @if(!empty($item['attachment']))
                            <a href="{{ \App\Services\ApiClient::assetUrl($item['attachment']) }}" target="_blank" class="inline-flex items-center gap-1 text-blue-600 hover:underline font-semibold">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                Unduh Berkas
                            </a>
                            @else
                            <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-slate-500">
                            {{ isset($item['created_at']) ? date('d M Y', strtotime($item['created_at'])) : '-' }}
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('admin.pengumuman.edit', $item['id']) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Sunting">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </a>
                                <form action="{{ route('admin.pengumuman.destroy', $item['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400">
                            Belum ada pengumuman yang dibuat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
