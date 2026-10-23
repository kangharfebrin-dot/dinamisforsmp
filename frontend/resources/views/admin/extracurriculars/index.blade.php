@extends('layouts.admin')

@section('title', 'Kelola Ekstrakurikuler')
@section('page_title', 'Kegiatan Ekstrakurikuler')
@section('page_subtitle', 'Pengembangan minat dan bakat siswa SMPN 2 Juwangi')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
        <div>
            <h2 class="text-base font-bold text-slate-900">Daftar Ekstrakurikuler</h2>
            <p class="text-xs text-slate-500 mt-0.5">Wadah pembinaan bakat, seni, olahraga, dan kepanduan</p>
        </div>
        <a href="{{ route('admin.ekstrakurikuler.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Ekstrakurikuler
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 font-extrabold uppercase tracking-wider text-[11px]">
                        <th class="py-3.5 px-6">Nama Ekstrakurikuler</th>
                        <th class="py-3.5 px-6">Pembina / Pelatih</th>
                        <th class="py-3.5 px-6">Jadwal Latihan</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    @forelse($extracurriculars as $ekskul)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                @if(!empty($ekskul['image']))
                                <img src="{{ \App\Services\ApiClient::assetUrl($ekskul['image']) }}" alt="{{ $ekskul['name'] }}" class="w-12 h-10 object-cover rounded-lg shrink-0 border border-slate-200">
                                @else
                                <div class="w-12 h-10 bg-blue-50 text-blue-600 rounded-lg shrink-0 flex items-center justify-center font-bold border border-blue-200 text-xs">
                                    ESK
                                </div>
                                @endif
                                <div class="min-w-0">
                                    <span class="font-bold text-slate-900 block truncate max-w-xs sm:max-w-md">{{ $ekskul['name'] }}</span>
                                    @if(!empty($ekskul['description']))
                                    <span class="text-[11px] text-slate-400 font-normal line-clamp-1">{{ $ekskul['description'] }}</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-slate-800 font-semibold">
                            {{ $ekskul['coach_name'] ?? '-' }}
                        </td>
                        <td class="py-4 px-6 text-slate-600">
                            {{ $ekskul['schedule'] ?? 'Sesuai Jadwal' }}
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('admin.ekstrakurikuler.edit', $ekskul['id']) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Sunting">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </a>
                                <form action="{{ route('admin.ekstrakurikuler.destroy', $ekskul['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ekstrakurikuler ini?');">
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
                            Belum ada data ekstrakurikuler.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
