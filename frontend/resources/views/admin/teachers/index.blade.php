@extends('layouts.admin')

@section('title', 'Kelola Guru & Staf')
@section('page_title', 'Guru & Tenaga Kependidikan')
@section('page_subtitle', 'Kelola direktori pendidik dan tenaga kependidikan SMPN 2 Juwangi')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
        <div>
            <h2 class="text-base font-bold text-slate-900">Direktori Guru & Staf</h2>
            <p class="text-xs text-slate-500 mt-0.5">Daftar tenaga pengajar dan staf administrasi sekolah</p>
        </div>
        <a href="{{ route('admin.guru.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Guru / Staf
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 font-extrabold uppercase tracking-wider text-[11px]">
                        <th class="py-3.5 px-6">Nama & NIP</th>
                        <th class="py-3.5 px-6">Tipe</th>
                        <th class="py-3.5 px-6">Jabatan</th>
                        <th class="py-3.5 px-6">Mata Pelajaran</th>
                        <th class="py-3.5 px-6">Email</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    @forelse($teachers as $teacher)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                @if(!empty($teacher['photo']))
                                <img src="{{ \App\Services\ApiClient::assetUrl($teacher['photo']) }}" alt="{{ $teacher['name'] }}" class="w-10 h-10 object-cover rounded-full border border-slate-200">
                                @else
                                <div class="w-10 h-10 bg-blue-100 text-blue-700 font-extrabold rounded-full flex items-center justify-center text-xs border border-blue-200">
                                    {{ strtoupper(substr($teacher['name'], 0, 2)) }}
                                </div>
                                @endif
                                <div>
                                    <span class="font-bold text-slate-900 block">{{ $teacher['name'] }}</span>
                                    <span class="text-[11px] text-slate-400">NIP: {{ $teacher['nip'] ?? '-' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            @if(($teacher['type'] ?? '') === 'guru')
                            <span class="px-2.5 py-1 bg-blue-50 text-blue-700 border border-blue-200 rounded-lg text-[11px] font-bold">Guru Pengajar</span>
                            @else
                            <span class="px-2.5 py-1 bg-purple-50 text-purple-700 border border-purple-200 rounded-lg text-[11px] font-bold">Tenaga Kependidikan</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-slate-700 font-semibold">
                            {{ $teacher['position'] ?? '-' }}
                        </td>
                        <td class="py-4 px-6 text-slate-600">
                            {{ $teacher['subject'] ?? '-' }}
                        </td>
                        <td class="py-4 px-6 text-slate-500">
                            {{ $teacher['email'] ?? '-' }}
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('admin.guru.edit', $teacher['id']) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Sunting">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </a>
                                <form action="{{ route('admin.guru.destroy', $teacher['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data guru/staf ini?');">
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
                            Belum ada data guru atau tenaga kependidikan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
