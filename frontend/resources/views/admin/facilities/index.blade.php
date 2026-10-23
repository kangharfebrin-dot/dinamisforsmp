@extends('layouts.admin')

@section('title', 'Kelola Fasilitas')
@section('page_title', 'Sarana & Prasarana Sekolah')
@section('page_subtitle', 'Inventaris fasilitas penunjang pembelajaran SMPN 2 Juwangi')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
        <div>
            <h2 class="text-base font-bold text-slate-900">Daftar Sarana & Prasarana</h2>
            <p class="text-xs text-slate-500 mt-0.5">Fasilitas gedung, laboratorium, ruang belajar, dan sarana olahraga</p>
        </div>
        <a href="{{ route('admin.fasilitas.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Fasilitas Baru
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 font-extrabold uppercase tracking-wider text-[11px]">
                        <th class="py-3.5 px-6">Nama Fasilitas</th>
                        <th class="py-3.5 px-6">Jumlah Unit</th>
                        <th class="py-3.5 px-6">Kondisi</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    @forelse($facilities as $item)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                @if(!empty($item['image']))
                                <img src="{{ \App\Services\ApiClient::assetUrl($item['image']) }}" alt="{{ $item['name'] }}" class="w-12 h-10 object-cover rounded-lg shrink-0 border border-slate-200">
                                @else
                                <div class="w-12 h-10 bg-slate-100 text-slate-500 rounded-lg shrink-0 flex items-center justify-center font-bold border border-slate-200 text-xs">
                                    FAS
                                </div>
                                @endif
                                <div class="min-w-0">
                                    <span class="font-bold text-slate-900 block truncate max-w-xs sm:max-w-md">{{ $item['name'] }}</span>
                                    @if(!empty($item['description']))
                                    <span class="text-[11px] text-slate-400 font-normal line-clamp-1">{{ $item['description'] }}</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-slate-800 font-bold">
                            {{ $item['quantity'] ?? 1 }} Unit/Ruang
                        </td>
                        <td class="py-4 px-6">
                            @if(($item['condition_status'] ?? '') === 'baik')
                            <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg text-[11px] font-bold">Kondisi Baik</span>
                            @elseif(($item['condition_status'] ?? '') === 'rusak_ringan')
                            <span class="px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded-lg text-[11px] font-bold">Rusak Ringan</span>
                            @else
                            <span class="px-2.5 py-1 bg-red-50 text-red-700 border border-red-200 rounded-lg text-[11px] font-bold">Rusak Berat</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('admin.fasilitas.edit', $item['id']) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Sunting">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </a>
                                <form action="{{ route('admin.fasilitas.destroy', $item['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus fasilitas ini?');">
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
                        <td colspan="4" class="py-12 text-center text-slate-400">
                            Belum ada data fasilitas sarana dan prasarana.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
