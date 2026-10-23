<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk Pengelola — Portal Admin SMP Negeri 2 Juwangi</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-linear-to-br from-slate-950 via-blue-950 to-slate-900 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-200">
        <!-- Header -->
        <div class="bg-blue-900 p-8 text-center text-white relative">
            <div class="w-16 h-16 rounded-2xl bg-white/10 mx-auto flex items-center justify-center backdrop-blur-md mb-3 border border-white/20">
                <svg class="w-8 h-8 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <h1 class="text-xl font-extrabold text-white">Portal Admin & Redaksi</h1>
            <p class="text-xs text-blue-200 mt-1">SMP Negeri 2 Juwangi, Boyolali</p>
        </div>

        <!-- Form Body -->
        <div class="p-8 space-y-6">
            @if($errors->any())
            <div class="p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs font-semibold">
                {{ $errors->first() }}
            </div>
            @endif

            @if(session('info'))
            <div class="p-3.5 rounded-xl bg-blue-50 border border-blue-200 text-blue-700 text-xs font-semibold">
                {{ session('info') }}
            </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Email Pengguna</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-600 focus:outline-none" placeholder="nama@smpn2juwangi.sch.id">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Kata Sandi</label>
                    <input type="password" name="password" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-600 focus:outline-none" placeholder="Masukkan kata sandi">
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3 rounded-xl bg-blue-900 hover:bg-blue-800 text-white font-bold text-sm shadow-md transition-all">
                        Masuk ke Dashboard
                    </button>
                </div>
            </form>

            <div class="pt-4 border-t border-slate-100 text-center">
                <a href="{{ route('home') }}" class="text-xs text-slate-500 hover:text-blue-700 font-semibold inline-flex items-center gap-1">
                    ← Kembali ke Halaman Publik
                </a>
            </div>
        </div>
    </div>

</body>
</html>
