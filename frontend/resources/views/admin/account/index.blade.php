@extends('layouts.admin')

@section('title', 'Profil & Keamanan Akun Admin')
@section('page_title', 'Profil & Keamanan Akun')
@section('page_subtitle', 'Kelola informasi identitas login administrator dan ganti kata sandi akun')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <!-- Card 1: Informasi Profil Akun -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6 sm:p-8 text-xs">
        <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-100">
            <div>
                <h2 class="text-sm font-bold text-slate-900">Informasi Akun Administrator</h2>
                <p class="text-slate-500">Perbarui nama dan alamat surel (email) login</p>
            </div>
            <span class="px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg font-bold text-[11px] uppercase">
                Peran: Admin
            </span>
        </div>

        <form action="{{ route('admin.akun.profile.update') }}" method="POST" class="space-y-4 max-w-xl">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1.5">Nama Pengguna / Admin <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $user['name'] ?? '') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 text-xs font-medium">
            </div>

            <div>
                <label for="email" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1.5">Alamat Email Login <span class="text-red-500">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email', $user['email'] ?? '') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 text-xs font-medium">
            </div>

            <div class="pt-2">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Perbarui Profil
                </button>
            </div>
        </form>
    </div>

    <!-- Card 2: Ubah Kata Sandi -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6 sm:p-8 text-xs">
        <div class="pb-4 mb-6 border-b border-slate-100">
            <h2 class="text-sm font-bold text-slate-900">Ubah Kata Sandi (Password)</h2>
            <p class="text-slate-500">Gunakan kata sandi yang kuat dengan minimal 8 karakter demi keamanan sistem</p>
        </div>

        <form action="{{ route('admin.akun.password.update') }}" method="POST" class="space-y-4 max-w-xl">
            @csrf
            @method('PUT')

            <div>
                <label for="current_password" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1.5">Kata Sandi Saat Ini <span class="text-red-500">*</span></label>
                <input type="password" id="current_password" name="current_password" required placeholder="Masukkan kata sandi lama Anda" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 text-xs font-medium">
            </div>

            <div>
                <label for="new_password" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1.5">Kata Sandi Baru <span class="text-red-500">*</span></label>
                <input type="password" id="new_password" name="new_password" required placeholder="Minimal 8 karakter" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 text-xs font-medium">
            </div>

            <div>
                <label for="new_password_confirmation" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1.5">Ulangi Kata Sandi Baru <span class="text-red-500">*</span></label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" required placeholder="Konfirmasi kata sandi baru" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 text-xs font-medium">
            </div>

            <div class="pt-2">
                <button type="submit" class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    Ganti Kata Sandi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
