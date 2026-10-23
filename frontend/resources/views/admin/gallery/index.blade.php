@extends('layouts.admin')

@section('title', 'Kelola Album & Galeri Foto')
@section('page_title', 'Album & Galeri Foto')
@section('page_subtitle', 'Dokumentasi visual kegiatan, upacara, perlombaan, dan fasilitas sekolah')

@section('content')
<div class="space-y-8">
    <!-- Section 1: Kelola Album Foto -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-base font-bold text-slate-900">Daftar Album Foto</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelompokkan foto dokumentasi berdasarkan peristiwa atau kegiatan</p>
            </div>
            <button type="button" onclick="openNewAlbumModal()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Buat Album Baru
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('admin.galeri.index') }}" class="p-4 rounded-xl border {{ empty($selectedAlbumId) ? 'border-blue-600 bg-blue-50/50' : 'border-slate-200 hover:border-slate-300' }} transition-all text-xs flex flex-col justify-between">
                <div>
                    <span class="font-bold text-slate-900 block text-sm">Semua Foto</span>
                    <span class="text-slate-500 mt-1 block">Seluruh koleksi dokumentasi</span>
                </div>
                <span class="text-[11px] font-semibold text-blue-600 mt-3">Tampilkan Semua &rarr;</span>
            </a>

            @forelse($albums as $alb)
            <div class="p-4 rounded-xl border {{ $selectedAlbumId == $alb['id'] ? 'border-blue-600 bg-blue-50/50' : 'border-slate-200 hover:border-slate-300' }} transition-all text-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between gap-2">
                        <a href="{{ route('admin.galeri.index', ['album_id' => $alb['id']]) }}" class="font-bold text-slate-900 hover:text-blue-600 block text-sm">
                            {{ $alb['name'] }}
                        </a>
                        <div class="inline-flex items-center gap-1 shrink-0">
                            <button type="button" onclick="editAlbum('{{ $alb['id'] }}', '{{ addslashes($alb['name']) }}', '{{ addslashes($alb['description'] ?? '') }}')" class="p-1 text-slate-400 hover:text-blue-600" title="Sunting Album">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            <form action="{{ route('admin.galeri.album.destroy', $alb['id']) }}" method="POST" onsubmit="return confirm('Hapus album ini beserta foto di dalamnya?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1 text-slate-400 hover:text-red-600" title="Hapus Album">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    <p class="text-slate-500 mt-1 line-clamp-1 text-[11px]">{{ $alb['description'] ?? 'Tidak ada deskripsi' }}</p>
                </div>
                <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                    <span class="font-semibold text-slate-600">{{ $alb['photos_count'] ?? 0 }} foto</span>
                    <a href="{{ route('admin.galeri.index', ['album_id' => $alb['id']]) }}" class="text-blue-600 font-bold hover:underline">Pilih Album</a>
                </div>
            </div>
            @empty
            <div class="col-span-full py-6 text-center text-slate-400 text-xs">
                Belum ada album foto dibuat. Silakan klik tombol "Buat Album Baru".
            </div>
            @endforelse
        </div>
    </div>

    <!-- Section 2: Upload Foto Baru -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6 text-xs">
        <h2 class="text-base font-bold text-slate-900 mb-1">Unggah Foto ke Galeri</h2>
        <p class="text-slate-500 mb-4">Tambahkan dokumentasi foto baru ke dalam galeri sekolah</p>

        <form action="{{ route('admin.galeri.photo.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
            @csrf
            <div>
                <label for="album_id" class="block font-bold text-slate-700 uppercase tracking-wider text-[10px] mb-1.5">Pilih Album</label>
                <select id="album_id" name="album_id" class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-600 text-xs font-semibold">
                    <option value="">-- Tanpa Album / Umum --</option>
                    @foreach($albums as $alb)
                    <option value="{{ $alb['id'] }}" {{ $selectedAlbumId == $alb['id'] ? 'selected' : '' }}>
                        {{ $alb['name'] }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="photo_title" class="block font-bold text-slate-700 uppercase tracking-wider text-[10px] mb-1.5">Judul / Keterangan Foto</label>
                <input type="text" id="photo_title" name="title" placeholder="Contoh: Upacara Bendera HUT RI" class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-600 text-xs font-medium">
            </div>

            <div>
                <label for="photo_file" class="block font-bold text-slate-700 uppercase tracking-wider text-[10px] mb-1.5">Berkas Foto <span class="text-red-500">*</span></label>
                <input type="file" id="photo_file" name="image" required accept="image/jpeg,image/png,image/webp" class="w-full text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
            </div>

            <div>
                <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-sm transition-colors flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    Unggah Foto
                </button>
            </div>
        </form>
    </div>

    <!-- Section 3: Daftar Foto dalam Galeri -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-base font-bold text-slate-900">
                Koleksi Foto {{ !empty($selectedAlbumId) ? '(Album Terpilih)' : '(Semua Foto)' }}
            </h2>
            <span class="text-xs font-semibold text-slate-500">{{ count($photos) }} foto ditemukan</span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @forelse($photos as $photo)
            <div class="group relative rounded-xl overflow-hidden border border-slate-200 aspect-square bg-slate-100 flex flex-col justify-end">
                <img src="{{ \App\Services\ApiClient::assetUrl($photo['image']) }}" alt="{{ $photo['title'] ?? 'Galeri' }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                <div class="absolute inset-0 bg-linear-to-t from-slate-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-3 flex flex-col justify-end">
                    <span class="text-white font-bold text-xs truncate">{{ $photo['title'] ?? 'Foto' }}</span>
                    @if(!empty($photo['album_name']))
                    <span class="text-slate-300 text-[10px] truncate">{{ $photo['album_name'] }}</span>
                    @endif
                    <div class="mt-2 flex items-center justify-between">
                        <a href="{{ \App\Services\ApiClient::assetUrl($photo['image']) }}" target="_blank" class="text-[10px] text-white underline">Lihat Full</a>
                        <form action="{{ route('admin.galeri.photo.destroy', $photo['id']) }}" method="POST" onsubmit="return confirm('Hapus foto ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1 text-red-400 hover:text-red-300" title="Hapus Foto">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 text-center text-slate-400 text-xs">
                Belum ada foto dalam galeri/album ini. Silakan unggah foto di formulir atas.
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Modal Buat / Edit Album -->
<div id="albumModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-200 text-xs">
        <h3 id="albumModalTitle" class="text-sm font-bold text-slate-900 mb-1">Buat Album Foto Baru</h3>
        <p class="text-slate-500 mb-4">Atur nama album dan deskripsi singkat.</p>

        <form id="albumForm" method="POST" class="space-y-4">
            @csrf
            <div id="albumMethodField"></div>
            <div>
                <label for="modal_album_name" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1.5">Nama Album <span class="text-red-500">*</span></label>
                <input type="text" id="modal_album_name" name="name" required placeholder="Contoh: Peringatan Hari Guru Nasional 2026" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 text-xs font-medium">
            </div>
            <div>
                <label for="modal_album_desc" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1.5">Deskripsi Album</label>
                <textarea id="modal_album_desc" name="description" rows="3" placeholder="Keterangan singkat kegiatan..." class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 text-xs font-normal"></textarea>
            </div>
            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" onclick="closeAlbumModal()" class="px-4 py-2 rounded-xl border border-slate-200 font-bold text-slate-600 hover:bg-slate-50">Batal</button>
                <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-sm">Simpan Album</button>
            </div>
        </form>
    </div>
</div>

<script>
function openNewAlbumModal() {
    const modal = document.getElementById('albumModal');
    const form = document.getElementById('albumForm');
    const title = document.getElementById('albumModalTitle');
    const methodField = document.getElementById('albumMethodField');
    title.innerText = 'Buat Album Foto Baru';
    form.action = "{{ route('admin.galeri.album.store') }}";
    methodField.innerHTML = '';
    document.getElementById('modal_album_name').value = '';
    document.getElementById('modal_album_desc').value = '';
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function editAlbum(id, name, desc) {
    const modal = document.getElementById('albumModal');
    const form = document.getElementById('albumForm');
    const title = document.getElementById('albumModalTitle');
    const methodField = document.getElementById('albumMethodField');
    title.innerText = 'Sunting Album Foto';
    form.action = `/admin/galeri/album/${id}`;
    methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('modal_album_name').value = name;
    document.getElementById('modal_album_desc').value = desc;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeAlbumModal() {
    const modal = document.getElementById('albumModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>
@endsection
