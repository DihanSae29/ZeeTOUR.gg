@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    
    {{-- Container ini yang bikin posisinya di TENGAH layar --}}
    <div class="max-w-3xl mx-auto">
        
        {{-- Tombol Back Keren --}}
        <a href="{{ route('tournaments.show', $match->tournament_id) }}" class="text-pink-500 hover:text-pink-400 text-[10px] font-bold tracking-widest uppercase mb-8 flex items-center gap-2 transition-colors w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Arena
        </a>

        {{-- Judul Halaman --}}
        <div class="mb-8 border-l-4 border-pink-500 pl-4">
            <h2 class="text-3xl font-black text-white font-orbitron uppercase tracking-wider">
                EDIT <span class="text-pink-500">MATCH INFO</span>
            </h2>
            <p class="text-gray-500 text-[10px] mt-2 uppercase tracking-widest">Override parameter jadwal dan tim yang bertanding</p>
        </div>

        {{-- Form Container --}}
        <div class="bg-[#050508] border border-gray-800 p-8 rounded-sm shadow-[0_0_30px_rgba(0,0,0,0.5)]">
            <form action="{{ route('tournaments.matches.update_info', $match->id_match ?? $match->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    {{-- Tim Alpha --}}
                    <div>
                        <label class="block text-[10px] text-gray-400 font-bold tracking-widest uppercase mb-3">Tim Alpha</label>
                        <select name="team_a_id" class="w-full bg-[#0a0a0f] border border-gray-800 focus:border-pink-500 text-white px-4 py-3 text-xs outline-none transition-colors">
                            <option value="">-- Kosongkan (TBD) --</option>
                            @foreach($approvedTeams as $at)
                                <option value="{{ $at->id_team ?? $at->id }}" {{ $match->team_a_id == ($at->id_team ?? $at->id) ? 'selected' : '' }}>
                                    {{ $at->nama_tim }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tim Omega --}}
                    <div>
                        <label class="block text-[10px] text-gray-400 font-bold tracking-widest uppercase mb-3">Tim Omega</label>
                        <select name="team_b_id" class="w-full bg-[#0a0a0f] border border-gray-800 focus:border-pink-500 text-white px-4 py-3 text-xs outline-none transition-colors">
                            <option value="">-- Kosongkan (TBD) --</option>
                            @foreach($approvedTeams as $at)
                                <option value="{{ $at->id_team ?? $at->id }}" {{ $match->team_b_id == ($at->id_team ?? $at->id) ? 'selected' : '' }}>
                                    {{ $at->nama_tim }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-[10px] text-gray-400 font-bold tracking-widest uppercase mb-3">Jadwal Tanding</label>
                    <input type="datetime-local" name="waktu_tanding" value="{{ date('Y-m-d\TH:i', strtotime($match->waktu_tanding)) }}" class="w-full bg-[#0a0a0f] border border-gray-800 focus:border-pink-500 text-white px-4 py-3 text-sm outline-none transition-colors" style="color-scheme: dark;">
                </div>

                <div class="mb-8">
                    <label class="block text-[10px] text-gray-400 font-bold tracking-widest uppercase mb-3">Babak (Keterangan)</label>
                    <input type="text" name="keterangan" value="{{ $match->keterangan }}" class="w-full bg-[#0a0a0f] border border-gray-800 focus:border-pink-500 text-white px-4 py-3 text-sm outline-none uppercase transition-colors">
                </div>

                <button type="submit" class="w-full px-6 py-4 bg-pink-500/10 border border-pink-500/50 text-pink-400 hover:bg-pink-500 hover:text-white font-black uppercase text-xs tracking-widest transition-all">
                    System Override: Save Info
                </button>
            </form>
        </div>
        
    </div>
</div>
@endsection