@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-8 py-12">

    {{-- Header --}}
    <div class="flex justify-between items-end mb-12">
        <div>
            <div class="inline-flex items-center gap-2 mb-3">
                <span class="inline-block w-8 h-[2px] bg-purple-500"></span>
                <span class="text-purple-500 text-[10px] font-black tracking-[0.4em] uppercase">Captain's HQ</span>
            </div>
            <h1 class="font-orbitron text-5xl font-black text-white uppercase tracking-wider glow-purple">YOUR TEAM</h1>
            <p class="text-gray-500 text-sm tracking-widest mt-2">Kelola tim dan susun roster terbaikmu untuk mendominasi turnamen.</p>
        </div>

        {{-- Tombol Create Your Team (header) — hanya muncul kalau belum punya tim --}}
        @if($teams->isEmpty())
        <a href="{{ route('teams.create') }}" class="group relative inline-flex items-center gap-3 px-8 py-4 text-white font-black text-[11px] uppercase tracking-[0.25em] transition-all duration-300 hover:-translate-y-0.5">
            {{-- Background gradient --}}
            <span class="absolute inset-0 bg-gradient-to-r from-pink-600 to-purple-600 shadow-[0_0_24px_rgba(236,72,153,0.45)] group-hover:shadow-[0_0_38px_rgba(236,72,153,0.75)] transition-all duration-300"></span>

            {{-- Corner frames --}}
            <span class="absolute top-0 left-0 w-3 h-3 border-t-2 border-l-2 border-white/40"></span>
            <span class="absolute bottom-0 right-0 w-3 h-3 border-b-2 border-r-2 border-white/40"></span>

            {{-- Icon + Text --}}
            <svg class="relative z-10 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            <span class="relative z-10">Create Your Team</span>
        </a>
        @endif
    </div>

   {{-- Container Tim Terpusat (Single Roster Focus) --}}
        <div class="max-w-4xl mx-auto mt-8 w-full">
         @forelse($teams as $team)
        <div class="relative bg-[#0a0a0f] border border-purple-500/20 rounded-md p-10 group hover:border-purple-500/50 transition-all shadow-[0_10px_40px_rgba(0,0,0,0.4)]">

            {{-- ISI KOTAK TIM (FULL DASHBOARD LAYOUT) --}}
            <div class="flex flex-col md:flex-row items-center md:items-stretch gap-8 relative z-10">
                
                {{-- KIRI: Logo Skuad --}}
                <div class="flex-shrink-0 relative">
                    {{-- Efek cahaya di belakang logo --}}
                    <div class="absolute inset-0 bg-pink-500/20 blur-2xl rounded-full"></div>
                    <div class="w-40 h-40 bg-purple-500/5 border border-purple-500/30 rounded-xl flex items-center justify-center overflow-hidden p-3 relative z-10 shadow-[0_0_20px_rgba(168,85,247,0.1)]">
                        @if($team->logo_path)
                            <img src="{{ asset('storage/' . $team->logo_path) }}" class="w-full h-full object-contain drop-shadow-[0_0_15px_rgba(236,72,153,0.5)]">
                        @else
                            <span class="text-5xl">🛡️</span>
                        @endif
                    </div>
                </div>

                {{-- TENGAH: Info Utama & Tombol --}}
                <div class="flex-grow flex flex-col justify-center border-r border-gray-800 pr-8">
                    <div class="text-[10px] text-pink-500 font-bold tracking-widest uppercase mb-1 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-pink-500 animate-pulse shadow-[0_0_5px_#ec4899]"></span>
                        Active Skuad
                    </div>
                    
                    <h2 class="font-orbitron text-4xl font-black text-white uppercase tracking-wider mb-3 drop-shadow-[0_0_10px_rgba(255,255,255,0.1)]">{{ $team->nama_tim }}</h2>
                    
                    <div class="inline-flex items-center gap-3 mb-6 flex-wrap">
                        {{-- Badge Game --}}
                        <div class="px-3 py-1.5 bg-purple-500/10 border border-purple-500/30 text-purple-400 text-[10px] font-bold tracking-widest uppercase rounded-sm">
                            <span class="text-white/40 mr-1">DIVISION:</span> 
                            {{ $team->game->nama_game ?? 'UNKNOWN' }}
                        </div>
                        {{-- Badge Kapten --}}
                        <div class="px-3 py-1.5 bg-cyan-500/10 border border-cyan-500/30 text-cyan-400 text-[10px] font-bold tracking-widest uppercase rounded-sm">
                            <span class="text-white/40 mr-1">CAPTAIN:</span> 
                            {{ Auth::user()->name }}
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mt-auto">
                        <a href="{{ route('teams.show', $team->id_team) }}" class="group relative px-6 py-2.5 bg-gradient-to-r from-pink-600 to-purple-600 hover:from-pink-500 hover:to-purple-500 text-white font-black text-[10px] uppercase tracking-[0.2em] transition-all duration-300 rounded-sm shadow-[0_0_15px_rgba(236,72,153,0.3)] hover:shadow-[0_0_30px_rgba(236,72,153,0.8)]">
                            <span class="relative z-10 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                Manage Roster
                            </span>
                        </a>
                        
                        <a href="{{ route('teams.edit', $team->id_team) }}" class="flex items-center gap-2 px-6 py-2.5 border border-gray-600 text-gray-400 hover:text-cyan-400 hover:border-cyan-400 font-bold text-[10px] uppercase tracking-[0.2em] transition-all duration-300 rounded-sm hover:shadow-[0_0_15px_rgba(34,211,238,0.2)]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit Info
                        </a>
                    </div>
                </div>

                {{-- KANAN: Statistik Skuad --}}
                <div class="flex-shrink-0 min-w-[220px] flex flex-col justify-center gap-4 pl-4">
                    {{-- Kotak Info 1: Total Anggota --}}
                    <div class="bg-[#050508] border border-gray-800/80 p-4 rounded-md relative overflow-hidden group">
                        <div class="absolute -right-4 -top-4 w-16 h-16 bg-pink-500/10 blur-xl rounded-full transition-all group-hover:bg-pink-500/20"></div>
                        <div class="text-[9px] text-gray-500 font-bold tracking-widest uppercase mb-1">Registered Agents</div>
                        <div class="font-orbitron text-2xl font-black text-white flex items-end gap-1">
                            {{-- Pake count() buat ngitung jumlah data roster yang nyangkut di tim ini --}}
                            {{ $team->players ? $team->players->count() : 0 }} 
                            <span class="text-xs text-gray-500 font-sans mb-1">/ 5</span>
                        </div>
                    </div>

                    {{-- Kotak Info 2: Tanggal Berdiri --}}
                    <div class="bg-[#050508] border border-gray-800/80 p-4 rounded-md relative overflow-hidden group">
                        <div class="absolute -right-4 -top-4 w-16 h-16 bg-cyan-500/10 blur-xl rounded-full transition-all group-hover:bg-cyan-500/20"></div>
                        <div class="text-[9px] text-gray-500 font-bold tracking-widest uppercase mb-1">Established Date</div>
                        <div class="text-sm font-bold text-white uppercase tracking-wider">
                            {{ $team->created_at ? $team->created_at->format('d M Y') : 'Unknown' }}
                        </div>
                    </div>
                </div>

            </div>
       @empty
        {{-- TAMPILAN KETIKA KOSONG (CYBERPUNK EMPTY STATE) --}}
        <div class="col-span-full relative bg-[#0a0a0f] border border-purple-500/20 p-16 flex flex-col items-center justify-center overflow-hidden rounded-sm group mt-4">
            
            {{-- Efek Radar / Glow Background --}}
            <div class="absolute inset-0 opacity-[0.03] bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-pink-500 via-transparent to-transparent"></div>
            
            {{-- Siku Hiasan Khas ZeETOUR --}}
            <div class="absolute top-0 left-0 w-12 h-12 border-t-2 border-l-2 border-pink-500/50"></div>
            <div class="absolute bottom-0 right-0 w-12 h-12 border-b-2 border-r-2 border-purple-500/50"></div>
            <div class="absolute top-0 right-0 w-4 h-4 border-t-2 border-r-2 border-purple-500/20"></div>
            <div class="absolute bottom-0 left-0 w-4 h-4 border-b-2 border-l-2 border-pink-500/20"></div>

            {{-- Icon Tech SVG (Gantiin Shield Emoji) --}}
            <div class="relative w-24 h-24 mb-8 flex items-center justify-center">
                <div class="absolute inset-0 bg-pink-500/20 blur-2xl rounded-full animate-pulse"></div>
                <svg class="w-16 h-16 text-pink-500 relative z-10 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"/>
                </svg>
            </div>

            {{-- Text Alert --}}
            <div class="text-center relative z-10">
                <h3 class="font-orbitron text-2xl text-white font-black mb-3 uppercase tracking-[0.3em] drop-shadow-[0_0_10px_rgba(236,72,153,0.5)]">System Alert: No Skuad</h3>
                <div class="inline-block px-4 py-1 border border-red-500/30 bg-red-500/10 text-red-400 text-[9px] font-black tracking-widest uppercase mb-6">
                    [ Tidak Ada Team ]
                </div>
                <p class="text-gray-400 text-xs tracking-widest uppercase mb-10 max-w-md mx-auto leading-relaxed">
                    Lu belum punya tim yang terdaftar di server. Buat tim sekarang untuk membuka akses pendaftaran turnamen.
                </p>
                
                {{-- Tombol Initialize --}}
                <a href="{{ route('teams.create') }}" class="relative inline-flex items-center justify-center px-10 py-4 bg-[#08090f] border border-pink-500 hover:bg-pink-500/10 text-pink-500 hover:text-white font-black text-[12px] uppercase tracking-[0.3em] transition-all overflow-hidden group hover:shadow-[0_0_30px_rgba(236,72,153,0.4)]">
                    <span class="absolute inset-0 w-full h-full -mt-1 opacity-20 bg-gradient-to-b from-transparent via-transparent to-pink-500"></span>
                    <span class="relative flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Initialize New Team
                    </span>
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection