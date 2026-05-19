@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    
    <div class="mb-10 border-l-4 border-pink-500 pl-4">
        <h2 class="text-3xl font-black text-white font-orbitron uppercase tracking-wider">
            COMBAT <span class="text-pink-500">LOGS</span>
        </h2>
        <p class="text-gray-500 text-[10px] mt-2 uppercase tracking-widest">Jadwal pertempuran dan riwayat skor tim lu</p>
    </div>

    <div class="bg-[#050508] border border-gray-800 rounded-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left whitespace-nowrap">
                <thead class="border-b border-gray-800/50 text-[9px] text-gray-500 uppercase tracking-widest bg-[#00000c]">
                    <tr>
                        <th class="p-5 font-bold">Turnamen</th>
                        <th class="p-5 font-bold text-center">Jadwal & Babak</th>
                        <th class="p-5 font-bold text-center">Pertandingan</th>
                        <th class="p-5 font-bold text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/30">
                    @forelse($matches as $match)
                        <tr class="hover:bg-[#0f0f15] transition-colors group">
                            {{-- Nama Turnamen --}}
                            <td class="p-5">
                                <span class="text-xs font-black text-white uppercase tracking-wider">{{ $match->tournament->nama_turnamen ?? 'UNKNOWN TOURNAMENT' }}</span>
                            </td>
                            
                            {{-- Waktu & Babak --}}
                            <td class="p-5 text-center">
                                <div class="text-[10px] font-mono text-gray-400 mb-1">
                                    {{ \Carbon\Carbon::parse($match->waktu_tanding)->format('d M Y, H:i') }} WIB
                                </div>
                                <div class="text-[9px] font-bold text-pink-500/80 uppercase tracking-widest">
                                    [{{ $match->keterangan }}]
                                </div>
                            </td>
                            
                            {{-- Smart Score Display --}}
                            <td class="p-5 text-center">
                                <div class="flex items-center justify-center gap-3">
                                    <span class="font-orbitron font-black text-white text-sm w-16 text-right">{{ $match->teamA ? $match->teamA->singkatan : 'TBD' }}</span>
                                    
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-12 text-center">
                                <span class="text-[10px] font-bold tracking-[0.2em] uppercase text-gray-600">-- TIM LU BELUM PUNYA JADWAL TANDING SAMA SEKALI --</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection