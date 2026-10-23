@extends('layouts.app')

@section('title', 'Sambutan Kepala Sekolah — ' . ($profile['name'] ?? 'SMP Negeri 2 Juwangi'))

@section('content')
<div class="bg-slate-900 text-white py-12 border-b border-slate-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-bold uppercase tracking-wider text-amber-400">Pimpinan Satuan Pendidikan</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white mt-1">Sambutan Kepala Sekolah</h1>
        <p class="text-slate-400 text-sm mt-1">Pesan resmi dari pimpinan sekolah untuk peserta didik, orang tua, dan masyarakat luas.</p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200/90 shadow-sm space-y-8">
        <div class="flex flex-col sm:flex-row items-center gap-6 pb-6 border-b border-slate-100 text-center sm:text-left">
            <div class="w-24 h-24 rounded-2xl bg-gradient-to-tr from-blue-900 to-amber-400 p-1 shrink-0">
                <div class="w-full h-full rounded-2xl bg-slate-100 overflow-hidden flex items-center justify-center">
                    @if(!empty($profile['principal_photo']))
                        <img src="{{ \App\Services\ApiClient::assetUrl($profile['principal_photo']) }}" alt="{{ $profile['principal_name'] ?? 'Kepala Sekolah' }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-blue-900 text-amber-300 font-extrabold flex items-center justify-center text-sm shadow-inner">
                            SMPN 2
                        </div>
                    @endif
                </div>
            </div>
            <div>
                <h2 class="text-xl font-extrabold text-slate-900">{{ $profile['principal_name'] ?? 'Kepala SMP Negeri 2 Juwangi' }}</h2>
                <p class="text-xs text-blue-700 font-semibold mt-0.5">Kepala SMP Negeri 2 Juwangi</p>
                @if(!empty($profile['principal_nip']) && $profile['principal_nip'] !== '-')
                    <p class="text-xs text-slate-400">NIP: {{ $profile['principal_nip'] }}</p>
                @endif
            </div>
        </div>

        <div class="text-slate-700 text-sm sm:text-base leading-relaxed space-y-4">
            <p class="font-bold text-slate-900">
                Assalamu’alaikum Warahmatullahi Wabarakatuh, Salam Sejahtera untuk Kita Semua.
            </p>
            <p>
                {{ $profile['principal_message'] ?? 'Puji syukur senantiasa kita panjatkan ke hadirat Tuhan Yang Maha Esa atas segala limpahan berkah dan karunia-Nya. Selamat datang di portal resmi informasi SMP Negeri 2 Juwangi.' }}
            </p>
            <p>
                Di era transformasi digital dan revolusi industri modern, pendidikan bukan hanya berfokus pada penguasaan materi tekstual, melainkan bagaimana menumbuhkan kecakapan bernalar kritis, kreativitas, kepedulian sosial, serta ketaatan beribadah dan akhlak karimah.
            </p>
            <p>
                Semoga media ini menjadi sarana komunikasi yang konstruktif dan akuntabel bagi seluruh keluarga besar sekolah, orang tua, maupun masyarakat luas.
            </p>
            <p class="font-bold text-slate-900 pt-4">
                Wassalamu’alaikum Warahmatullahi Wabarakatuh.
            </p>
        </div>
    </div>
</div>
@endsection
