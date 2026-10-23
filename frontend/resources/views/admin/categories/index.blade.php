@extends('layouts.admin')

@section('title', 'Kelola Kategori Berita')
@section('page_title', 'Kategori Berita')
@section('page_subtitle', 'Pengelompokan topik kabar dan artikel sekolah')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Form Tambah Kategori -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6 h-fit text-xs">
        <h2 class="text-sm font-bold text-slate-900 mb-1">Tambah Kategori Baru</h2>
        <p class="text-slate-500 mb-4">Buat kategori baru untuk mengelompokkan artikel dan kabar berita.</p>

        <form action="{{ route('admin.kategori.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1.5">Nama Kategori <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" required placeholder="Contoh: Prestasi, Kurikulum, Pramuka" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs font-medium">
            </div>
            <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-sm transition-colors flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Kategori
            </button>
        </form>
    </div>

    <!-- Table Daftar Kategori -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h2 class="text-sm font-bold text-slate-900">Daftar Kategori Terdaftar</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 font-extrabold uppercase tracking-wider text-[11px]">
                        <th class="py-3.5 px-6">Nama Kategori</th>
                        <th class="py-3.5 px-6">Slug URL</th>
                        <th class="py-3.5 px-6">Jumlah Berita</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    @forelse($categories as $category)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="py-4 px-6 font-bold text-slate-900">
                            {{ $category['name'] }}
                        </td>
                        <td class="py-4 px-6 text-slate-400 font-mono text-[11px]">
                            {{ $category['slug'] }}
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg text-[11px] font-semibold">
                                {{ $category['posts_count'] ?? 0 }} artikel
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="inline-flex items-center gap-2">
                                <!-- Modal Trigger Edit (Simple Inline Form Toggle or Prompt) -->
                                <button type="button" onclick="editCategory('{{ $category['id'] }}', '{{ addslashes($category['name']) }}')" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Sunting">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </button>
                                <form action="{{ route('admin.kategori.destroy', $category['id']) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?');">
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
                            Belum ada kategori. Silakan tambahkan pada form di samping.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Edit Kategori -->
<div id="editModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-200 text-xs">
        <h3 class="text-sm font-bold text-slate-900 mb-1">Sunting Kategori</h3>
        <p class="text-slate-500 mb-4">Ubah nama kategori yang sudah ada.</p>

        <form id="editForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label for="edit_name" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1.5">Nama Kategori</label>
                <input type="text" id="edit_name" name="name" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 text-xs font-medium">
            </div>
            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 rounded-xl border border-slate-200 font-bold text-slate-600 hover:bg-slate-50">Batal</button>
                <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-sm">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
function editCategory(id, name) {
    const modal = document.getElementById('editModal');
    const form = document.getElementById('editForm');
    const input = document.getElementById('edit_name');
    form.action = `/admin/kategori/${id}`;
    input.value = name;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
function closeEditModal() {
    const modal = document.getElementById('editModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>
@endsection
