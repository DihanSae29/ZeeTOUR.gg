@extends('layouts.app') {{-- Sesuaikan dengan layout lu --}}

@section('content')
<div class="max-w-3xl mx-auto px-8 py-16">

    <a href="{{ url('/katalog') }}" class="text-[10px] text-gray-500 hover:text-cyan-400 font-bold tracking-[0.2em] uppercase transition-all mb-8 inline-block">
        < Cancel Deployment
    </a>

    <div class="bg-[#0a0a0f] border border-cyan-500/30 p-8 rounded-sm relative overflow-hidden shadow-[0_0_30px_rgba(6,182,212,0.1)]">
        {{-- Siku Hiasan --}}
        <div class="absolute top-0 left-0 w-8 h-8 border-t-2 border-l-2 border-cyan-500/80"></div>
        <div class="absolute bottom-0 right-0 w-8 h-8 border-b-2 border-r-2 border-pink-500/80"></div>

        <div class="text-center mb-10">
            <h2 class="font-orbitron text-3xl font-black text-white uppercase tracking-widest drop-shadow-[0_0_10px_rgba(255,255,255,0.2)]">
                DEPLOY SQUAD
            </h2>
            <p class="text-[11px] text-cyan-400 font-mono tracking-widest mt-2 uppercase">Target: {{ $tournament->nama_turnamen }}</p>
        </div>

        {{-- Alert kalau ada Error (Slot penuh / Dobel daftar) --}}
        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/50 p-4 mb-6 rounded-sm text-red-400 text-xs font-mono tracking-wider">
                >> {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('tournaments.enroll.store', $tournament->id_tournament ?? $tournament->id) }}" method="POST">
            @csrf
            
            <div class="mb-8">
                <label class="block text-[10px] text-gray-400 font-bold tracking-widest uppercase mb-3">Pilih Skuad yang Akan Bertanding</label>
                
                @if($myTeams->count() > 0)
                    <div class="relative">
                        <select name="team_id" required class="w-full bg-[#050508] border border-gray-800 focus:border-cyan-500 text-white px-4 py-4 text-sm tracking-wider outline-none appearance-none cursor-pointer">
                            <option value="" disabled selected>-- PILIH SKUAD LU --</option>
                            @foreach($myTeams as $team)
                                <option value="{{ $team->id_team ?? $team->id }}">{{ $team->nama_tim }} ({{ $team->players->count() }}/5 Agents)</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-cyan-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                @else
                    <div class="bg-gray-900/50 border border-gray-800 p-6 text-center">
                        <p class="text-sm text-gray-500 mb-4">Lu belum punya skuad yang divisi game-nya cocok buat turnamen ini.</p>
                        <a href="{{ route('my-teams.index') }}" class="px-4 py-2 bg-pink-500/10 border border-pink-500 text-pink-400 text-[10px] font-bold uppercase tracking-widest rounded-sm hover:bg-pink-500 hover:text-white transition-all">
                            Bikin Skuad Baru
                        </a>
                    </div>
                @endif
            </div>

            @if($myTeams->count() > 0)
                <button type="submit" class="w-full relative group overflow-hidden rounded-sm p-[1px]">
                    <span class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-purple-500 opacity-70 group-hover:opacity-100 transition-opacity duration-300"></span>
                    <div class="relative bg-[#0a0a0f] px-8 py-4 transition-all duration-300 group-hover:bg-opacity-0">
                        <span class="relative text-[12px] font-black tracking-[0.2em] uppercase text-white group-hover:drop-shadow-[0_0_8px_rgba(255,255,255,1)]">
                            CONFIRM DEPLOYMENT
                        </span>
                    </div>
                </button>
            @endif
        </form>

    </div>
</div>
@endsection