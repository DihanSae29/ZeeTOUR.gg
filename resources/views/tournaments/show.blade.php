@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-8 py-12">

    <a href="{{ route('tournaments.index') }}" class="text-[10px] text-gray-500 hover:text-cyan-400 font-bold tracking-[0.2em] uppercase transition-all mb-8 inline-block">
        < Back to Master Tournaments
    </a>

    {{-- Header Turnamen --}}
    <div class="bg-[#0a0a0f] border border-gray-800 p-8 rounded-sm mb-8 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-cyan-500/10 blur-2xl rounded-full"></div>
        <div class="flex justify-between items-end relative z-10">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-purple-500/10 border border-purple-500/30 text-purple-400 text-[9px] font-black uppercase tracking-widest rounded-sm mb-3">
                    VERIFICATION PANEL
                </div>
                <h1 class="font-orbitron text-4xl font-black text-white uppercase tracking-wider mb-2">
                    {{ $tournament->nama_turnamen }}
                </h1>
                <p class="text-xs text-gray-500 font-mono tracking-widest uppercase">Target Slot: <span class="text-cyan-400">{{ $tournament->teams->count() }} / {{ $tournament->max_slot }}</span> Skuad</p>
            </div>
        </div>
    </div>

    {{-- Kotak Error Global (Nangkep error Tim & Match) --}}
    @if($errors->any())
        <div class="bg-red-500/5 border border-red-500/30 rounded-sm p-5 mb-6">
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <h4 class="text-red-500 text-[11px] font-bold uppercase tracking-[0.2em]">System Error Detected</h4>
            </div>
            <ul class="list-disc list-inside text-gray-400 text-xs ml-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Bypass Admin --}}
    <div class="bg-[#050508] border border-gray-800 p-6 rounded-sm mb-8 flex items-end gap-4">
        <div class="flex-grow">
            <label class="block text-[10px] text-gray-400 font-bold tracking-widest uppercase mb-3">System Override: Deploy Tim Manual</label>
            <form action="{{ route('tournaments.participants.add', $tournament->id_tournament ?? $tournament->id) }}" method="POST" class="flex gap-4">
                @csrf
                <select name="team_id" 
                    @if($availableTeams->isEmpty()) disabled @endif 
                    class="flex-grow bg-[#0a0a0f] border border-gray-800 focus:border-cyan-500 text-white px-4 py-3 text-xs tracking-wider outline-none transition-all @if($availableTeams->isEmpty()) opacity-50 cursor-not-allowed @else cursor-pointer @endif">
                    
                    @if($availableTeams->isEmpty())
                        <option value="" disabled selected>-- NO REINFORCEMENTS AVAILABLE (SEMUA TIM UDAH MASUK) --</option>
                    @else
                        <option value="" disabled selected>-- PILIH SKUAD YANG TERSEDIA --</option>
                        @foreach($availableTeams as $avTeam)
                            <option value="{{ $avTeam->id_team ?? $avTeam->id }}">{{ $avTeam->nama_tim }} ({{ $avTeam->singkatan }})</option>
                        @endforeach
                    @endif
                </select>

                <button type="submit" 
                    @if($availableTeams->isEmpty()) disabled @endif 
                    class="px-8 py-3 bg-cyan-500/10 border border-cyan-500/50 text-cyan-400 font-black uppercase text-[10px] tracking-widest transition-all @if($availableTeams->isEmpty()) opacity-50 cursor-not-allowed @else hover:bg-cyan-500 hover:text-white @endif">
                    Deploy
                </button>
            </form>
        </div>
    </div>

    {{-- Tabel Peserta --}}
    <div class="bg-[#050508] border border-gray-800 rounded-sm">
        <div class="px-6 py-4 border-b border-gray-800 bg-[#0a0a0f] flex justify-between items-center">
            <span class="text-[10px] font-bold tracking-[0.2em] uppercase text-cyan-500">// REGISTERED_TEAMS</span>
        </div>

        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-gray-800/50 text-[9px] text-gray-500 uppercase tracking-widest bg-[#08080c]">
                    <th class="p-5 font-bold">Nama Skuad</th>
                    <th class="p-5 font-bold text-center">Waktu Daftar</th>
                    <th class="p-5 font-bold text-center">Status</th>
                    <th class="p-5 font-bold text-right">Verifikasi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800/30">
                @forelse($tournament->teams as $team)
                    <tr class="hover:bg-[#0f0f15] transition-colors group">
                        <td class="p-5">
                            <span class="font-orbitron text-sm font-black text-white uppercase">{{ $team->nama_tim }}</span>
                        </td>
                        <td class="p-5 text-center text-xs font-mono text-gray-500">
                            {{ $team->pivot->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="p-5 text-center">
                            @if($team->pivot->status_pendaftaran == 'Pending')
                                <span class="px-3 py-1 text-[9px] font-black tracking-widest uppercase border border-yellow-500/30 text-yellow-400 bg-yellow-500/10 rounded-sm shadow-[0_0_10px_rgba(234,179,8,0.1)]">Pending</span>
                            @elseif($team->pivot->status_pendaftaran == 'Approved')
                                <span class="px-3 py-1 text-[9px] font-black tracking-widest uppercase border border-green-500/30 text-green-400 bg-green-500/10 rounded-sm shadow-[0_0_10px_rgba(34,197,94,0.1)]">Approved</span>
                            @else
                                <span class="px-3 py-1 text-[9px] font-black tracking-widest uppercase border border-red-500/30 text-red-400 bg-red-500/10 rounded-sm shadow-[0_0_10px_rgba(239,68,68,0.1)]">Rejected</span>
                            @endif
                        </td>
                        <td class="p-5 text-right">
                            @if($team->pivot->status_pendaftaran == 'Pending')
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Tombol Approve --}}
                                    <form action="{{ route('tournaments.participants.update', ['tournament' => $tournament->id_tournament ?? $tournament->id, 'team' => $team->id_team ?? $team->id]) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="Approved">
                                        <button type="submit" class="px-3 py-1.5 text-[10px] font-bold tracking-widest uppercase text-green-400 border border-green-400/30 rounded-sm hover:bg-green-400/10 transition-all">
                                            ACC
                                        </button>
                                    </form>

                                    {{-- Tombol Reject --}}
                                    <form action="{{ route('tournaments.participants.update', ['tournament' => $tournament->id_tournament ?? $tournament->id, 'team' => $team->id_team ?? $team->id]) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="Rejected">
                                        <button type="submit" class="px-3 py-1.5 text-[10px] font-bold tracking-widest uppercase text-red-400 border border-red-400/30 rounded-sm hover:bg-red-400/10 transition-all">
                                            Tolak
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="flex justify-end">
                                    <form action="{{ route('tournaments.participants.kick', ['tournament' => $tournament->id_tournament ?? $tournament->id, 'team' => $team->id_team ?? $team->id]) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="document.getElementById('modal-kick-{{ $team->id_team ?? $team->id }}').classList.remove('hidden')" class="px-3 py-1.5 text-[10px] font-bold tracking-widest uppercase text-red-500 border border-red-500/30 bg-red-500/10 rounded-sm hover:bg-red-500 hover:text-white transition-all">
                                            KICK SKUAD
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </td>
                        {{-- Modal Konfirmasi KICK --}}
                        <div id="modal-kick-{{ $team->id_team ?? $team->id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm transition-all duration-300">
                            <div class="relative bg-[#0b0b13] border border-gray-800 p-8 max-w-lg w-full text-left shadow-[0_0_40px_rgba(239,68,68,0.15)] rounded-sm">
                                {{-- Siku Hiasan Merah --}}
                                <div class="absolute top-[-1px] left-[-1px] w-4 h-4 border-t-2 border-l-2 border-red-500"></div>
                                <div class="absolute bottom-[-1px] right-[-1px] w-4 h-4 border-b-2 border-r-2 border-red-500"></div>

                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center border border-red-500/40 bg-red-500/10 rounded-sm">
                                        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    </div>
                                    <div class="pt-1">
                                        <h3 class="text-white text-2xl font-black uppercase tracking-wider">System Alert</h3>
                                        <p class="text-red-500 text-[10px] font-bold uppercase tracking-[0.2em] mt-1">Kick Protocol Initiated</p>
                                    </div>
                                </div>

                                <p class="text-gray-400 text-sm mt-6 mb-8 leading-relaxed whitespace-normal">
                                    Skuad <strong class="text-white">{{ $team->nama_tim }}</strong> akan didiskualifikasi dan dikeluarkan dari arena <strong class="text-white">{{ $tournament->nama_turnamen }}</strong> secara paksa.
                                </p>

                                <div class="flex justify-end gap-4">
                                    <button type="button" onclick="document.getElementById('modal-kick-{{ $team->id_team ?? $team->id }}').classList.add('hidden')" class="text-gray-500 hover:text-white px-6 py-2 text-[10px] font-bold tracking-widest uppercase transition-colors">
                                        Batalkan
                                    </button>
                                    <form action="{{ route('tournaments.participants.kick', ['tournament' => $tournament->id_tournament ?? $tournament->id, 'team' => $team->id_team ?? $team->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-sm text-[10px] font-black uppercase tracking-widest transition-colors shadow-[0_0_15px_rgba(239,68,68,0.4)]">
                                            Eksekusi Kick
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-10 text-center text-gray-500 text-[10px] tracking-widest uppercase font-bold">
                            // BELUM ADA SKUAD YANG MENDAFTAR //
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ========================================= --}}
    {{-- ARENA CONTROL: MATCH SCHEDULE MANAGER --}}
    {{-- ========================================= --}}

    <div class="mt-12 bg-[#050508] border border-gray-800 p-6 rounded-sm">
        <h3 class="text-pink-500 text-[11px] font-bold uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-pink-500 shadow-[0_0_8px_#ec4899]"></span>
            Arena Control: Set Match Schedule
        </h3>

        <form action="{{ route('tournaments.matches.store', $tournament->id_tournament ?? $tournament->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
            @csrf
            
            {{-- Tim Alpha --}}
            <div class="lg:col-span-1">
                <label class="block text-[9px] text-gray-500 font-bold tracking-widest uppercase mb-2">Tim Alpha</label>
                <select name="team_a_id" class="w-full bg-[#0a0a0f] border border-gray-800 focus:border-pink-500 text-white px-3 py-3 text-xs outline-none">
                    <option value="" disabled selected>-- Pilih Tim A --</option>
                    @foreach($approvedTeams as $at)
                        <option value="{{ $at->id_team ?? $at->id }}">{{ $at->nama_tim }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Tim Omega --}}
            <div class="lg:col-span-1">
                <label class="block text-[9px] text-gray-500 font-bold tracking-widest uppercase mb-2">Tim Omega</label>
                <select name="team_b_id" class="w-full bg-[#0a0a0f] border border-gray-800 focus:border-pink-500 text-white px-3 py-3 text-xs outline-none">
                    <option value="" disabled selected>-- Pilih Tim B --</option>
                    @foreach($approvedTeams as $at)
                        <option value="{{ $at->id_team ?? $at->id }}">{{ $at->nama_tim }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Waktu Tanding --}}
            <div class="lg:col-span-1">
                <label class="block text-[9px] text-gray-500 font-bold tracking-widest uppercase mb-2">Jadwal Tanding</label>
                <input type="datetime-local" name="waktu_tanding" class="w-full bg-[#0a0a0f] border border-gray-800 focus:border-pink-500 text-white px-3 py-2.5 text-xs outline-none" style="color-scheme: dark;">
            </div>

            {{-- Keterangan / Babak --}}
            <div class="lg:col-span-1">
                <label class="block text-[9px] text-gray-500 font-bold tracking-widest uppercase mb-2">Babak (Ex: Semi-Final)</label>
                <input type="text" name="keterangan" placeholder="Nama Babak" class="w-full bg-[#0a0a0f] border border-gray-800 focus:border-pink-500 text-white px-3 py-3 text-xs outline-none uppercase">
            </div>

            {{-- Tombol Submit --}}
            <div class="lg:col-span-1">
                <button type="submit" class="w-full px-4 py-3 bg-pink-500/10 border border-pink-500/50 text-pink-400 hover:bg-pink-500 hover:text-white font-black uppercase text-[10px] tracking-widest transition-all">
                    Deploy Match
                </button>
            </div>
        </form>
    </div>

    {{-- ========================================= --}}
    {{-- TABEL MATCH SCHEDULE --}}
    {{-- ========================================= --}}

    <div class="mt-8 bg-[#050508] border border-gray-800 rounded-sm mb-12">
        <div class="px-6 py-4 border-b border-gray-800 bg-[#0a0a0f] flex justify-between items-center">
            <span class="text-[10px] font-bold tracking-[0.2em] uppercase text-pink-500">MATCHES</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left whitespace-nowrap">
                <thead class="border-b border-gray-800/50 text-[9px] text-gray-500 uppercase tracking-widest bg-[#00000c]">
                    <tr>
                        <th class="p-5 font-bold">Waktu Tanding</th>
                        <th class="p-5 font-bold text-center">Pertandingan</th>
                        <th class="p-5 font-bold text-center">Babak</th>
                        <th class="p-5 font-bold text-center">Status</th>
                        <th class="p-5 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/30">
                    @forelse($tournament->matches as $match)
                        <tr class="hover:bg-[#0f0f15] transition-colors group">
                            {{-- Waktu Tanding --}}
                            <td class="p-5 text-xs font-mono text-gray-400">
                                {{ \Carbon\Carbon::parse($match->waktu_tanding)->format('d M Y, H:i') }} WIB
                            </td>
                            
                            {{-- Tim A vs Tim B (Smart Score Display) --}}
                            <td class="p-5 text-center">
                                <div class="flex items-center justify-center gap-3">
                                    <span class="font-orbitron font-black text-white text-sm w-16 text-right">{{ $match->teamA ? $match->teamA->singkatan : 'TBD' }}</span>
                                    
                                    {{-- Logika Penampil Skor --}}
                                    @if($match->status == 'Upcoming')
                                        <span class="text-[9px] text-gray-600 font-bold italic mx-2 bg-[#0a0a0f] px-2 py-1 rounded-sm border border-gray-800">VS</span>
                                    @else
                                        <span class="font-orbitron font-black text-pink-500 text-lg mx-2 drop-shadow-[0_0_5px_rgba(236,72,153,0.5)]">
                                            {{ $match->score_a }} - {{ $match->score_b }}
                                        </span>
                                    @endif

                                    <span class="font-orbitron font-black text-white text-sm w-16 text-left">{{ $match->teamB ? $match->teamB->singkatan : 'TBD' }}</span>
                                </div>
                            </td>

                            {{-- Babak --}}
                            <td class="p-5 text-center text-[10px] font-bold text-pink-500/80 uppercase tracking-widest">
                                {{ $match->keterangan }}
                            </td>

                            {{-- Status --}}
                            <td class="p-5 text-center">
                                @if($match->status == 'Upcoming')
                                    <span class="px-2 py-1 text-[9px] font-black tracking-widest uppercase border border-cyan-500/30 text-cyan-400 bg-cyan-500/10 rounded-sm">Upcoming</span>
                                @elseif($match->status == 'Live')
                                    <span class="px-2 py-1 text-[9px] font-black tracking-widest uppercase border border-red-500/30 text-red-400 bg-red-500/10 rounded-sm animate-pulse shadow-[0_0_10px_rgba(239,68,68,0.5)]">Live</span>
                                @else
                                    <span class="px-2 py-1 text-[9px] font-black tracking-widest uppercase border border-green-500/30 text-green-400 bg-green-500/10 rounded-sm">Completed</span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="p-5 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    
                                    {{-- Tombol Edit Info (Tim, Waktu, Babak) --}}
                                    <a href="{{ route('tournaments.matches.edit', $match->id_match ?? $match->id) }}" class="text-[10px] text-blue-500/70 hover:text-blue-500 font-bold tracking-widest uppercase transition-colors">
                                        Edit Info
                                    </a>

                                    <span class="text-gray-800">|</span>

                                    {{-- Tombol Edit Skor --}}
                                    <button type="button" 
                                        onclick="openScoreModal('{{ $match->id_match ?? $match->id }}', '{{ $match->teamA ? $match->teamA->singkatan : 'TBD' }}', '{{ $match->teamB ? $match->teamB->singkatan : 'TBD' }}', '{{ $match->score_a }}', '{{ $match->score_b }}', '{{ $match->status }}')"
                                        class="text-[10px] text-gray-500 hover:text-white font-bold tracking-widest uppercase transition-colors">
                                        Edit Skor
                                    </button>

                                    <span class="text-gray-800">|</span>

                                    {{-- Tombol Hapus Match (Panggil Modal) --}}
                                    <button type="button" 
                                        onclick="openDeleteModal('{{ route('tournaments.matches.destroy', $match->id_match ?? $match->id) }}')" 
                                        class="text-[10px] text-red-500/70 hover:text-red-500 font-bold tracking-widest uppercase transition-colors">
                                        HAPUS
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center">
                                <span class="text-[10px] font-bold tracking-[0.2em] uppercase text-gray-600">-- BELUM ADA JADWAL MATCH DI ARENA INI --</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- ========================================= --}}
    {{-- MODAL POP-UP EDIT SKOR --}}
    {{-- ========================================= --}}
    <div id="scoreModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/80 backdrop-blur-sm">
        <div class="bg-[#050508] border border-pink-500/50 p-6 rounded-sm w-full max-w-md shadow-[0_0_20px_rgba(236,72,153,0.2)]">
            
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-pink-500 text-[11px] font-bold uppercase tracking-[0.2em]">Update Skor Match</h3>
                <button type="button" onclick="closeScoreModal()" class="text-gray-500 hover:text-red-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            {{-- Form update ini action-nya bakal diisi sama JS --}}
            <form id="scoreForm" method="POST" action="">
                @csrf
                @method('PUT')
                
                <div class="flex items-center justify-between mb-6">
                    {{-- Input Skor Tim Alpha --}}
                    <div class="text-center w-2/5">
                        <h4 id="modalTeamA" class="font-orbitron font-black text-white text-lg mb-2">TBD</h4>
                        <input type="number" name="score_a" id="modalScoreA" value="0" min="0" class="w-full bg-[#0a0a0f] border border-gray-800 focus:border-pink-500 text-white text-center py-3 text-2xl font-black outline-none transition-colors">
                    </div>
                    
                    <div class="text-[10px] text-gray-600 font-bold italic">VS</div>

                    {{-- Input Skor Tim Omega --}}
                    <div class="text-center w-2/5">
                        <h4 id="modalTeamB" class="font-orbitron font-black text-white text-lg mb-2">TBD</h4>
                        <input type="number" name="score_b" id="modalScoreB" value="0" min="0" class="w-full bg-[#0a0a0f] border border-gray-800 focus:border-pink-500 text-white text-center py-3 text-2xl font-black outline-none transition-colors">
                    </div>
                </div>

                {{-- Status Pertandingan --}}
                <div class="mb-6">
                    <label class="block text-[9px] text-gray-500 font-bold tracking-widest uppercase mb-2">Status Match</label>
                    <select name="status" id="modalStatus" class="w-full bg-[#0a0a0f] border border-gray-800 focus:border-pink-500 text-white px-3 py-3 text-xs outline-none transition-colors">
                        <option value="Upcoming">UPCOMING (BELUM MAIN)</option>
                        <option value="Live">LIVE (SEDANG TANDING)</option>
                        <option value="Completed">COMPLETED (SELESAI)</option>
                    </select>
                </div>

                <button type="submit" class="w-full px-4 py-3 bg-pink-500/10 border border-pink-500 text-pink-400 hover:bg-pink-500 hover:text-white font-black uppercase text-[10px] tracking-widest transition-all">
                    Confirm Override
                </button>
            </form>
        </div>
    </div>

    {{-- Javascript buat ngatur buka-tutup Pop-up --}}
    <script>
        function openScoreModal(matchId, teamA, teamB, scoreA, scoreB, status) {
            // 1. Ubah URL rute sesuai ID match yang diklik
            document.getElementById('scoreForm').action = `/tournaments/matches/${matchId}/update`;
            
            // 2. Tembak data lama ke dalem Pop-up
            document.getElementById('modalTeamA').innerText = teamA;
            document.getElementById('modalTeamB').innerText = teamB;
            document.getElementById('modalScoreA').value = scoreA;
            document.getElementById('modalScoreB').value = scoreB;
            document.getElementById('modalStatus').value = status;
            
            // 3. Tampilkan Pop-up nya
            document.getElementById('scoreModal').classList.remove('hidden');
            document.getElementById('scoreModal').classList.add('flex');
        }

        function closeScoreModal() {
            // Sembunyiin lagi Pop-up nya
            document.getElementById('scoreModal').classList.add('hidden');
            document.getElementById('scoreModal').classList.remove('flex');
        }
    </script>

    {{-- ========================================= --}}
    {{-- MODAL POP-UP KONFIRMASI HAPUS MATCH --}}
    {{-- ========================================= --}}
    <div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/80 backdrop-blur-sm">
        <div class="bg-[#050508] border border-red-500/50 p-6 rounded-sm w-full max-w-sm shadow-[0_0_20px_rgba(239,68,68,0.2)] text-center">
            
            {{-- Ikon Tanda Seru --}}
            <svg class="w-12 h-12 text-red-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            
            <h3 class="text-red-500 text-lg font-black uppercase tracking-widest mb-2">WARNING SYSTEM!</h3>
            <p class="text-gray-400 text-xs mb-6">Yakin mau hapus jadwal match ini? Data skor dan riwayat pertempuran bakal musnah permanen dari arena.</p>

            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="flex gap-4">
                    <button type="button" onclick="closeDeleteModal()" class="flex-1 px-4 py-3 bg-[#0a0a0f] border border-gray-800 text-gray-400 hover:text-white font-bold uppercase text-[10px] tracking-widest transition-colors">
                        BATAL
                    </button>
                    <button type="submit" class="flex-1 px-4 py-3 bg-red-500/10 border border-red-500 text-red-400 hover:bg-red-500 hover:text-white font-black uppercase text-[10px] tracking-widest transition-all">
                        EKSEKUSI
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script Tambahan buat Buka/Tutup Modal Hapus --}}
    <script>
        function openDeleteModal(actionUrl) {
            // Isi action form dengan URL delete dari match yang diklik
            document.getElementById('deleteForm').action = actionUrl;
            
            // Tampilkan modal
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
        }

        function closeDeleteModal() {
            // Sembunyikan modal
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
        }
    </script>

@endsection