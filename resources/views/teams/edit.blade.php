@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">
    <div class="mb-10">
        {{-- Tombol Kembali yang Pinter di Halaman Edit --}}
<a href="{{ Auth::user()->role === 'admin' ? route('teams.index') : route('my-teams.index') }}" 
   class="flex items-center gap-2 text-[10px] font-bold tracking-widest uppercase text-gray-500 hover:text-cyan-400 transition-colors no-underline">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
    </svg>
    RETURN TO TEAMS
</a>
        <h1 class="text-3xl font-orbitron font-black text-white tracking-widest uppercase">
            Update <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-purple-500">Data Skuad</span>
        </h1>
    </div>

    @if ($errors->any())
    <div class="mb-6 relative bg-red-500/10 border border-red-500/50 rounded p-4 shadow-[0_0_15px_rgba(248,113,113,0.15)] z-20">
        <div class="flex items-center gap-3 mb-2">
            <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <span class="font-orbitron text-red-400 font-bold tracking-widest text-xs uppercase">Update Failed</span>
        </div>
        <ul class="list-disc list-inside text-xs text-red-300/80 ml-7 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="relative bg-[#08090f] border border-pink-500/20 rounded-md p-8 shadow-[0_0_30px_rgba(236,72,153,0.05)] mt-6">
        <div class="absolute top-0 left-0 w-6 h-6 border-t-2 border-l-2 border-pink-500/80 rounded-tl-md"></div>
        <div class="absolute bottom-0 right-0 w-6 h-6 border-b-2 border-r-2 border-pink-500/80 rounded-br-md"></div>

        <form action="{{ route('teams.update', $team->id_team) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6 relative z-10">
            @csrf
            @method('PUT')

            {{-- Nama Tim --}}
            <div class="flex flex-col gap-2 relative">
                <label class="text-[11px] tracking-[2px] uppercase text-pink-400 font-bold flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-pink-500 shadow-[0_0_5px_#ec4899]"></span>
                    Nama Skuad / Tim
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-pink-500/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <input type="text" name="nama_tim" value="{{ old('nama_tim', $team->nama_tim) }}"
                           class="w-full bg-[#0b0c16] border border-pink-500/30 pl-12 pr-4 py-3 rounded-md text-pink-100 focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition-all font-medium tracking-wide">
                </div>
            </div>

             <div class="mb-6">
                <label class="block text-[10px] text-gray-400 font-bold tracking-widest uppercase mb-3">Singkatan Tim (Max 5 Huruf)</label>
                <input type="text" name="singkatan" maxlength="5" placeholder="Contoh: PRX, RRQ, TL" value="{{ old('singkatan', $team->singkatan ?? '') }}" class="w-full bg-[#050508] border border-gray-800 focus:border-pink-500 text-white px-4 py-3 text-sm tracking-wider outline-none uppercase transition-colors">
            </div>

            {{-- ══ UPLOAD / GANTI LOGO ══ --}}
            <div class="flex flex-col gap-2 relative">
                <label class="text-[11px] tracking-[2px] uppercase text-yellow-400 font-bold flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 shadow-[0_0_5px_#eab308]"></span>
                    Logo Tim <span class="text-yellow-500/40 font-normal normal-case tracking-normal">(kosongkan jika tidak ingin ganti)</span>
                </label>

                @if($team->logo_path)
                {{-- Logo saat ini --}}
                <div id="current-logo-block" class="flex items-center gap-4 bg-yellow-500/5 border border-yellow-500/20 rounded-md px-4 py-3">
                    <img src="{{ Storage::url($team->logo_path) }}" alt="Logo saat ini" class="w-14 h-14 object-contain rounded-sm border border-yellow-500/20 bg-[#0b0c16] p-1">
                    <div class="flex-1 min-w-0">
                        <p class="text-[10px] text-yellow-500/60 uppercase tracking-widest mb-0.5">Logo Saat Ini</p>
                        <p class="text-xs text-yellow-300/70 font-mono truncate">{{ basename($team->logo_path) }}</p>
                    </div>
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="checkbox" name="hapus_logo" id="hapus_logo" value="1" class="w-4 h-4 accent-red-500">
                        <span class="text-[11px] text-red-400 font-bold tracking-widest uppercase group-hover:text-red-300 transition-colors">Hapus Logo</span>
                    </label>
                </div>
                @endif

                {{-- Drop Zone --}}
                <div id="drop-zone"
                     class="relative border-2 border-dashed border-yellow-500/30 rounded-md p-6 text-center cursor-pointer hover:border-yellow-500/60 hover:bg-yellow-500/5 transition-all group"
                     onclick="document.getElementById('logo-input').click()">

                    <div id="preview-wrapper" class="hidden flex-col items-center gap-3">
                        <img id="logo-preview" src="" alt="Preview" class="w-20 h-20 object-contain rounded-sm border border-yellow-500/30 bg-[#0b0c16] p-1">
                        <p id="preview-name" class="text-xs text-yellow-400/70 font-mono"></p>
                        <button type="button" onclick="clearLogo(event)" class="text-[10px] text-red-400 hover:text-red-300 tracking-widest uppercase border border-red-400/30 px-3 py-1 rounded-sm hover:bg-red-500/10 transition-all">
                            Batal Pilih
                        </button>
                    </div>

                    <div id="upload-placeholder" class="flex flex-col items-center gap-2">
                        <svg class="w-9 h-9 text-yellow-500/40 group-hover:text-yellow-500/60 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm text-yellow-400/60 font-medium">{{ $team->logo_path ? 'Upload logo baru untuk mengganti' : 'Klik atau drag & drop logo tim' }}</p>
                        <p class="text-[10px] text-yellow-500/30 tracking-widest uppercase">PNG · JPG · WEBP · max 2MB</p>
                    </div>

                    <input type="file" id="logo-input" name="logo" accept="image/png,image/jpeg,image/webp" class="hidden">
                </div>
            </div>

            {{-- Cabang Game --}}
            <div class="flex flex-col gap-2 relative">
                <label class="text-[11px] tracking-[2px] uppercase text-purple-400 font-bold flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-purple-500 shadow-[0_0_5px_#a855f7]"></span>
                    Cabang Game
                </label>
                <div class="relative">
                    <select name="game_id" required
                            class="w-full bg-[#0b0c16] border border-purple-500/30 pl-4 pr-10 py-3 rounded-md text-purple-100 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-all font-medium appearance-none">
                        <option value="" disabled>-- Pilih Game --</option>
                        @foreach($games as $game)
                            <option value="{{ $game->id_game }}" {{ $team->game_id == $game->id_game ? 'selected' : '' }}>{{ $game->nama_game }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Kapten --}}
            <div class="flex flex-col gap-2 relative">
                <label class="text-[11px] tracking-[2px] uppercase text-cyan-400 font-bold flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-500 shadow-[0_0_5px_#06b6d4]"></span>
                    Pilih Kapten Tim
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-cyan-500/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <select name="captain_id"
                            class="w-full bg-[#0b0c16] border border-cyan-500/30 pl-12 pr-10 py-3 rounded-md text-cyan-100 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition-all font-medium tracking-wide appearance-none">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $team->captain_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-cyan-500/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-pink-600 to-purple-600 text-white font-bold text-sm tracking-widest uppercase shadow-[0_0_20px_rgba(236,72,153,0.3)] hover:shadow-[0_0_30px_rgba(236,72,153,0.6)] hover:-translate-y-0.5 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Update Skuad
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const input       = document.getElementById('logo-input');
const dropZone    = document.getElementById('drop-zone');
const preview     = document.getElementById('logo-preview');
const previewW    = document.getElementById('preview-wrapper');
const placeholder = document.getElementById('upload-placeholder');
const previewName = document.getElementById('preview-name');

function showPreview(file) {
    if (!file || !file.type.startsWith('image/')) return;
    const reader = new FileReader();
    reader.onload = e => {
        preview.src = e.target.result;
        previewName.textContent = file.name;
        previewW.classList.remove('hidden');
        previewW.classList.add('flex');
        placeholder.classList.add('hidden');
    };
    reader.readAsDataURL(file);
}

function clearLogo(e) {
    e.stopPropagation();
    input.value = '';
    previewW.classList.add('hidden');
    previewW.classList.remove('flex');
    placeholder.classList.remove('hidden');
}

input.addEventListener('change', () => { if (input.files[0]) showPreview(input.files[0]); });

dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('border-yellow-500/70', 'bg-yellow-500/10'); });
dropZone.addEventListener('dragleave', () => { dropZone.classList.remove('border-yellow-500/70', 'bg-yellow-500/10'); });
dropZone.addEventListener('drop', e => {
    e.preventDefault();
    dropZone.classList.remove('border-yellow-500/70', 'bg-yellow-500/10');
    const file = e.dataTransfer.files[0];
    if (file) {
        const dt = new DataTransfer();
        dt.items.add(file);
        input.files = dt.files;
        showPreview(file);
    }
});
</script>
@endsection
