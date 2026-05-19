@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-8 py-12">
    
    {{-- Header Form --}}
    <div class="flex items-end justify-between mb-8">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-block w-6 h-0.5 bg-blue-400"></span>
                <span class="text-xs tracking-[4px] uppercase text-blue-400 font-semibold">Edit Data</span>
            </div>
            <h1 class="font-orbitron text-3xl font-black text-white glow-purple m-0">UPDATE GAME</h1>
        </div>
        <a href="{{ route('games.index') }}" class="text-sm font-bold tracking-widest uppercase text-purple-400 hover:text-pink-400 transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    {{-- Form Panel --}}
    <div class="relative bg-white/[0.02] border border-blue-500/20 rounded-md p-8">
        <div class="absolute top-0 left-0 w-5 h-5 border-t-2 border-l-2 border-blue-400"></div>
        <div class="absolute bottom-0 right-0 w-5 h-5 border-b-2 border-r-2 border-blue-400"></div>

        {{-- Pesan Error Validasi (Pastikan ini ada di atas tag <form>) --}}
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

<form action="{{ route('games.update', $game->id_game) }}" method="POST" class="flex flex-col gap-6 relative z-10">
    @csrf
    @method('PUT')

    <div class="flex flex-col gap-2 relative">
        <label class="text-[11px] tracking-[2px] uppercase text-purple-400 font-bold flex items-center gap-2">
            <span class="w-1.5 h-1.5 rounded-full bg-purple-500 shadow-[0_0_5px_#a855f7]"></span>
            Nama Game
        </label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-purple-500/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 6l-2-2m0 0L10 6m2-2v6m-4 4h8a2 2 0 002-2v-4a2 2 0 00-2-2h-8a2 2 0 00-2 2v4a2 2 0 002 2z"/></svg>
            </div>
            <input type="text" name="nama_game" value="{{ $game->nama_game }}" 
                   class="w-full bg-[#0b0c16] border border-purple-500/30 pl-12 pr-4 py-3 rounded-md text-purple-100 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 focus:shadow-[0_0_15px_rgba(168,85,247,0.4)] transition-all font-medium tracking-wide">
        </div>
    </div>

    <div class="flex flex-col gap-2 relative">
        <label class="text-[11px] tracking-[2px] uppercase text-cyan-400 font-bold flex items-center gap-2">
            <span class="w-1.5 h-1.5 rounded-full bg-cyan-500 shadow-[0_0_5px_#06b6d4]"></span>
            Platform
        </label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-cyan-500/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <select name="platform"
                    class="w-full bg-[#0b0c16] border border-cyan-500/30 pl-12 pr-10 py-3 rounded-md text-cyan-100 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 focus:shadow-[0_0_15px_rgba(6,182,212,0.4)] transition-all font-medium tracking-wide appearance-none">
                <option value="PC" {{ $game->platform == 'PC' ? 'selected' : '' }}>PC</option>
                <option value="Mobile" {{ $game->platform == 'Mobile' ? 'selected' : '' }}>Mobile</option>
                <option value="Console" {{ $game->platform == 'Console' ? 'selected' : '' }}>Console</option>
            </select>
            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-cyan-500/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </div>
        </div>
    </div>

    <div class="flex flex-col gap-2 relative">
        <label class="text-[11px] tracking-[2px] uppercase text-pink-400 font-bold flex items-center gap-2">
            <span class="w-1.5 h-1.5 rounded-full bg-pink-500 shadow-[0_0_5px_#ec4899]"></span>
            Max Player (Per Tim)
        </label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-pink-500/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
            <input type="number" name="max_player" value="{{ $game->max_player }}" min="1"
                   class="w-full bg-[#0b0c16] border border-pink-500/30 pl-12 pr-4 py-3 rounded-md text-pink-100 focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 focus:shadow-[0_0_15px_rgba(236,72,153,0.4)] transition-all font-medium tracking-wide">
        </div>
    </div>

    <div class="mt-4 flex justify-end">
        <button type="submit"
                class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-blue-600 to-cyan-500 text-white font-bold text-sm tracking-widest uppercase shadow-[0_0_20px_rgba(37,99,235,0.3)] hover:shadow-[0_0_30px_rgba(37,99,235,0.6)] hover:-translate-y-0.5 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            Update Game Data
        </button>
    </div>
</form>
    </div>

</div>
@endsection