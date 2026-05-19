@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-8 py-12">
    
    {{-- Header Katalog --}}
    <div class="mb-14 text-center">
        <div class="inline-flex items-center gap-2 mb-3">
            <span class="inline-block w-8 h-[2px] bg-pink-500"></span>
            <span class="text-pink-500 text-[10px] font-black tracking-[0.4em] uppercase">Open Registration</span>
            <span class="inline-block w-8 h-[2px] bg-pink-500"></span>
        </div>
        <h1 class="font-orbitron text-5xl font-black text-white drop-shadow-[0_0_15px_rgba(168,85,247,0.4)] mb-4 uppercase tracking-wider">Tournament Catalog</h1>
        <p class="text-purple-200/50 text-sm tracking-widest">Pilih medan pertempuranmu dan daftarkan skuad terbaikmu sekarang.</p>
    </div>

    {{-- Grid Card Turnamen --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($tournaments as $tour)
        
        {{-- Card Item --}}
        <div class="relative bg-[#08090f] border border-purple-500/20 rounded-md overflow-hidden group hover:border-pink-500/50 transition-all duration-300 shadow-[0_0_20px_rgba(168,85,247,0.05)] hover:shadow-[0_0_30px_rgba(236,72,153,0.15)] flex flex-col">
            
            {{-- Siku Hiasan --}}
            <div class="absolute top-0 left-0 w-3 h-3 border-t border-l border-purple-500/50"></div>
            <div class="absolute bottom-0 right-0 w-3 h-3 border-b border-r border-purple-500/50"></div>

            {{-- Label Status --}}
            <div class="absolute top-0 right-0 px-4 py-1.5 bg-green-500/10 border-b border-l border-green-500/20 text-green-400 text-[9px] font-black tracking-widest uppercase rounded-bl-md">
                Slot Tersedia
            </div>

            <div class="p-8 flex-grow">
                {{-- Nama Game --}}
                <div class="text-[10px] text-pink-500 font-bold tracking-widest uppercase mb-2">
                    {{ $tour->game ? $tour->game->nama_game : 'All Games' }}
                </div>
                
                {{-- Judul Turnamen --}}
                <h3 class="font-orbitron text-2xl font-bold text-white mb-6 line-clamp-2 leading-snug">
                    {{ $tour->nama_turnamen }}
                </h3>

                {{-- Info Box --}}
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div class="bg-white/[0.02] border border-white/5 rounded p-3 text-center">
                        <div class="text-[9px] text-gray-500 uppercase tracking-widest mb-1">Max Slot</div>
                        <div class="text-white font-bold font-orbitron text-lg">{{ $tour->max_slot }} <span class="text-[10px] text-gray-600 tracking-normal">Tim</span></div>
                    </div>
                    <div class="bg-white/[0.02] border border-white/5 rounded p-3 text-center">
                        <div class="text-[9px] text-gray-500 uppercase tracking-widest mb-1">Prizepool</div>
                        <div class="text-pink-400 font-bold text-sm mt-1 whitespace-nowrap overflow-hidden text-ellipsis">{{ $tour->prizepool ?? 'TBA' }}</div>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi (Sticky di bawah) --}}
            @php
    $isRegistered = false;
    $statusPendaftaran = '';

    // Cek khusus kalau yang login adalah user biasa/kapten
    if(Auth::check()) {
        // Tarik semua ID tim yang dimiliki sama Kapten ini
        $myTeamIds = \App\Models\Team::where('captain_id', Auth::id())->pluck('id_team')->toArray();

        // Cek apakah ada di antara tim kapten ini yang nyangkut di turnamen yang lagi dilooping
        $registeredTeam = $tour->teams->whereIn('id_team', $myTeamIds)->first();

        // Kalau ketemu, catet statusnya
        if($registeredTeam) {
            $isRegistered = true;
            $statusPendaftaran = $registeredTeam->pivot->status_pendaftaran;
        }
    }
@endphp

{{-- Logika Penampilan Tombol Cyberpunk --}}
<div class="p-6 pt-0 mt-auto">
    @if($isRegistered)
        @if($statusPendaftaran == 'Pending')
            <button disabled class="block w-full py-3.5 bg-yellow-500/10 border border-yellow-500/30 text-yellow-500 text-[10px] font-black tracking-[0.2em] uppercase text-center cursor-not-allowed transition-all">
                Menunggu Verifikasi Admin
            </button>
        @elseif($statusPendaftaran == 'Approved')
            <button disabled class="block w-full py-3.5 bg-green-500/10 border border-green-500/30 text-green-400 text-[10px] font-black tracking-[0.2em] uppercase text-center cursor-not-allowed shadow-[0_0_15px_rgba(34,197,94,0.1)] transition-all">
                Skuad Terdaftar
            </button>
        @elseif($statusPendaftaran == 'Rejected')
            <button disabled class="block w-full py-3.5 bg-red-500/10 border border-red-500/30 text-red-500 text-[10px] font-black tracking-[0.2em] uppercase text-center cursor-not-allowed transition-all">
                Pendaftaran Ditolak
            </button>
        @endif
    @else
        {{-- Kalau belum daftar, cek dulu slotnya penuh atau nggak --}}
        @if($tour->teams->count() >= $tour->max_slot)
            <button disabled class="block w-full py-3.5 bg-[#050508] border border-gray-800 text-gray-600 text-[10px] font-black tracking-[0.2em] uppercase text-center cursor-not-allowed transition-all">
                Slot Penuh
            </button>
        @else
            <a href="{{ route('tournaments.enroll', $tour->id_tournament) }}" class="block w-full py-3.5 bg-purple-500/10 border border-purple-500/30 text-purple-400 hover:bg-purple-500 hover:text-white hover:shadow-[0_0_20px_rgba(168,85,247,0.4)] text-[10px] font-black tracking-[0.2em] uppercase text-center transition-all">
                Daftarkan Tim
            </a>
        @endif
    @endif
</div>
        </div>

        @empty
        <div class="col-span-full py-24 text-center border border-dashed border-purple-500/20 rounded-lg bg-purple-500/5">
            <span class="text-6xl mb-4 opacity-20 block">📡</span>
            <div class="font-orbitron text-2xl text-purple-900/50 mb-2 uppercase tracking-wider">No Incoming Signals</div>
            <p class="text-gray-500 text-sm tracking-widest">Belum ada turnamen yang membuka pendaftaran saat ini.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection