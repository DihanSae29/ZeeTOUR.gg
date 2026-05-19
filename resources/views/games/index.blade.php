@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-8 py-12">

    {{-- Header (Bawaan Lu) --}}
    <div class="flex items-end justify-between mb-10">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-block w-6 h-0.5 bg-purple-400"></span>
                <span class="text-xs tracking-[4px] uppercase text-purple-400 font-semibold">Master Data</span>
            </div>
            <h1 class="font-orbitron text-4xl font-black text-white glow-purple m-0">GAME REGISTRY</h1>
            <p class="text-sm text-purple-900 mt-2">Kelola daftar game yang dipertandingkan di turnamen.</p>
        </div>
        <a href="{{ route('games.create') }}"
           class="btn-add-clip inline-flex items-center gap-2 px-7 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-bold text-sm tracking-widest uppercase no-underline shadow-[0_0_24px_rgba(168,85,247,0.5)] hover:shadow-[0_0_40px_rgba(168,85,247,0.8)] hover:-translate-y-0.5 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Tambah Game
        </a>
    </div>

    {{-- KOTAK STATISTIK (Upgraded Cyberpunk) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 mt-6">
        {{-- Stat 1: Total Game --}}
        <div class="relative bg-[#0a0a0f] border border-purple-500/20 p-6 rounded-sm overflow-hidden group hover:border-purple-500/50 transition-all duration-300 shadow-[0_0_15px_rgba(168,85,247,0.05)] hover:shadow-[0_0_30px_rgba(168,85,247,0.15)] hover:-translate-y-1">
            <div class="absolute top-0 right-0 w-24 h-24 bg-purple-500/10 blur-2xl rounded-full group-hover:bg-purple-500/20 transition-all"></div>
            <div class="text-[10px] text-gray-500 font-bold tracking-widest uppercase mb-2 flex items-center gap-2">
                <svg class="w-3 h-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                Total Game
            </div>
            <div class="font-orbitron text-4xl font-black text-white drop-shadow-[0_0_8px_rgba(255,255,255,0.2)]">
                {{ $games->count() }}
            </div>
        </div>

        {{-- Stat 2: Platform Aktif --}}
        <div class="relative bg-[#0a0a0f] border border-cyan-500/20 p-6 rounded-sm overflow-hidden group hover:border-cyan-500/50 transition-all duration-300 shadow-[0_0_15px_rgba(6,182,212,0.05)] hover:shadow-[0_0_30px_rgba(6,182,212,0.15)] hover:-translate-y-1">
            <div class="absolute top-0 right-0 w-24 h-24 bg-cyan-500/10 blur-2xl rounded-full group-hover:bg-cyan-500/20 transition-all"></div>
            <div class="text-[10px] text-gray-500 font-bold tracking-widest uppercase mb-2 flex items-center gap-2">
                <svg class="w-3 h-3 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Platform Aktif
            </div>
            <div class="font-orbitron text-4xl font-black text-white drop-shadow-[0_0_8px_rgba(255,255,255,0.2)]">
                {{ $games->pluck('platform')->unique()->count() }}
            </div>
        </div>

        {{-- Stat 3: Max Player Tertinggi --}}
        <div class="relative bg-[#0a0a0f] border border-pink-500/20 p-6 rounded-sm overflow-hidden group hover:border-pink-500/50 transition-all duration-300 shadow-[0_0_15px_rgba(236,72,153,0.05)] hover:shadow-[0_0_30px_rgba(236,72,153,0.15)] hover:-translate-y-1">
            <div class="absolute top-0 right-0 w-24 h-24 bg-pink-500/10 blur-2xl rounded-full group-hover:bg-pink-500/20 transition-all"></div>
            <div class="text-[10px] text-gray-500 font-bold tracking-widest uppercase mb-2 flex items-center gap-2">
                <svg class="w-3 h-3 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Max Player Tertinggi
            </div>
            <div class="font-orbitron text-4xl font-black text-white drop-shadow-[0_0_8px_rgba(255,255,255,0.2)]">
                {{ $games->max('max_player') ?? 0 }}
            </div>
        </div>
    </div>

    {{-- DATA GRID (Upgraded Cyberpunk) --}}
    <div class="relative bg-[#0a0a0f] border border-gray-800 rounded-sm">
        {{-- Siku Hiasan Container --}}
        <div class="absolute top-0 left-0 w-6 h-6 border-t-2 border-l-2 border-cyan-500/50"></div>
        <div class="absolute bottom-0 right-0 w-6 h-6 border-b-2 border-r-2 border-pink-500/50"></div>

        {{-- Header Data Grid --}}
        <div class="flex justify-between items-center p-5 border-b border-gray-800/80 bg-[#050508]/50">
            <div class="text-[10px] text-cyan-500 font-bold tracking-[0.2em] uppercase flex items-center gap-3">
                <span class="w-1.5 h-1.5 bg-cyan-500 animate-pulse rounded-full"></span> 
                // SYSTEM_DATA_LIST
            </div>
            <div class="text-[9px] bg-purple-500/10 border border-purple-500/30 text-purple-400 px-3 py-1.5 rounded-sm uppercase tracking-widest font-black">
                {{ $games->count() }} Entries
            </div>
        </div>

        {{-- Isi Tabel --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-800/50 text-[9px] text-gray-500 uppercase tracking-widest bg-[#08080c]">
                        <th class="p-5 font-bold w-24">VID</th>
                        <th class="p-5 font-bold">Nama Game</th>
                        <th class="p-5 font-bold">Platform</th>
                        <th class="p-5 font-bold">Max Player</th>
                        <th class="p-5 font-bold text-right pr-8">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/30">
                    @forelse($games as $game)
                    <tr class="hover:bg-[#0f0f15] transition-colors group">
                        
                        {{-- Kolom 1: VID (Garis hover gw pindahin ke dalem border sini biar ga ngerusak layout) --}}
                        <td class="p-5 text-xs font-mono text-gray-500 group-hover:text-cyan-400 border-l-2 border-transparent group-hover:border-cyan-500 transition-all w-24">
                            #{{ str_pad($game->id_game, 3, '0', STR_PAD_LEFT) }}
                        </td>
                        
                        {{-- Kolom 2: Nama Game --}}
                        <td class="p-5 font-orbitron text-sm font-black text-white tracking-wider group-hover:text-pink-400 transition-colors drop-shadow-[0_0_5px_rgba(255,255,255,0.1)]">
                            {{ $game->nama_game }}
                        </td>
                        
                        {{-- Kolom 3: Platform --}}
                        <td class="p-5">
                            @if(strtoupper($game->platform) == 'PC')
                                <span class="px-2.5 py-1 text-[9px] font-black tracking-widest uppercase border border-cyan-500/30 text-cyan-400 bg-cyan-500/10 rounded-sm shadow-[0_0_10px_rgba(6,182,212,0.1)]">PC</span>
                            @elseif(strtoupper($game->platform) == 'MOBILE')
                                <span class="px-2.5 py-1 text-[9px] font-black tracking-widest uppercase border border-orange-500/30 text-orange-400 bg-orange-500/10 rounded-sm shadow-[0_0_10px_rgba(249,115,22,0.1)]">MOBILE</span>
                            @else
                                <span class="px-2.5 py-1 text-[9px] font-black tracking-widest uppercase border border-gray-500/30 text-gray-400 bg-gray-500/10 rounded-sm">{{ $game->platform }}</span>
                            @endif
                        </td>
                        
                        {{-- Kolom 4: Max Player --}}
                        <td class="p-5 text-xs font-mono text-gray-400">
                            {{ $game->max_player }} <span class="text-[9px] font-sans uppercase tracking-widest text-gray-600 ml-1">Agents</span>
                        </td>
                        
                        {{-- Kolom 5: Aksi (Tombol dikotakin lagi ala Cyberpunk) --}}
                        <td class="p-5 text-right pr-8">
                            <div class="flex items-center justify-end gap-2 opacity-50 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('games.edit', $game->id_game) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-[10px] font-bold tracking-widest uppercase text-cyan-400 border border-cyan-400/30 rounded-sm hover:bg-cyan-400/10 hover:shadow-[0_0_10px_rgba(6,182,212,0.2)] transition-all">
                                    Edit
                                </a>
                                
                                <form id="delete-form-{{ $game->id_game }}" action="{{ route('games.destroy', $game->id_game) }}" method="POST" class="inline-block">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="button" onclick="showDeleteModal({{ $game->id_game }})" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-[10px] font-bold tracking-widest uppercase text-red-400 border border-red-400/30 rounded-sm hover:bg-red-400/10 hover:shadow-[0_0_10px_rgba(248,113,113,0.2)] transition-all cursor-pointer">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-10 text-center text-gray-500 text-[10px] tracking-widest uppercase font-bold">
                            // NO GAME DATA FOUND IN REGISTRY //
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Delete Modal Element (Bawaan Lu) --}}
<div id="deleteModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/80 backdrop-blur-sm transition-opacity">
    <div class="relative bg-[#08090f] border border-red-500/30 rounded-md p-8 max-w-md w-full shadow-[0_0_30px_rgba(248,113,113,0.15)] mx-4">
        <div class="absolute top-0 left-0 w-4 h-4 border-t-2 border-l-2 border-red-500"></div>
        <div class="absolute bottom-0 right-0 w-4 h-4 border-b-2 border-r-2 border-red-500"></div>

        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 rounded bg-red-500/10 flex items-center justify-center border border-red-500/30 text-red-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <h3 class="font-orbitron text-xl font-bold text-white tracking-wider">SYSTEM ALERT</h3>
                <p class="text-[10px] text-red-400 tracking-[0.2em] uppercase mt-1">Deletion Protocol Initiated</p>
            </div>
        </div>

        <p class="text-purple-100/70 text-sm mb-8 leading-relaxed">Data game ini akan dihapus secara permanen dari database ZeEtz Esports. Tindakan ini tidak dapat dibatalkan.</p>

        <div class="flex justify-end gap-3">
            <button type="button" onclick="hideDeleteModal()" class="px-5 py-2 text-xs font-bold tracking-widest uppercase text-purple-300 border border-purple-500/30 hover:bg-purple-500/10 transition-colors rounded-sm">
                Batalkan
            </button>
            <button type="button" id="confirmDeleteBtn" class="px-5 py-2 text-xs font-bold tracking-widest uppercase text-white bg-red-500 hover:bg-red-600 shadow-[0_0_15px_rgba(248,113,113,0.5)] transition-all rounded-sm">
                Eksekusi Hapus
            </button>
        </div>
    </div>
</div>

{{-- Script Eksekutor Modal (Bawaan Lu) --}}
<script>
    let currentFormId = null;

    function showDeleteModal(id) {
        currentFormId = 'delete-form-' + id;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function hideDeleteModal() {
        currentFormId = null;
        document.getElementById('deleteModal').classList.add('hidden');
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (currentFormId) {
            document.getElementById(currentFormId).submit();
        }
    });
</script>
@endsection