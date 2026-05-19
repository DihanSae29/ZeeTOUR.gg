@extends('layouts.app') 

@section('content')
<div class="max-w-6xl mx-auto px-6 py-12">
    
    <div class="flex justify-between items-end mb-10">
        <div>
            <div class="flex items-center gap-4 mb-3">
                <div class="h-[1px] w-8 bg-pink-500"></div>
                <span class="text-pink-500 text-[10px] font-black tracking-[0.3em] uppercase bg-pink-500/10 border border-pink-500/30 px-3 py-1 rounded-sm">Master Data</span>
            </div>
            <h1 class="font-orbitron text-4xl font-black text-white glow-purple m-0">TOURNAMENTS</h1>
            <p class="text-gray-500 mt-2 text-sm">Kelola daftar turnamen esports yang akan diselenggarakan di ZeETOUR.</p>
        </div>
        
        <a href="{{ route('tournaments.create') }}" class="bg-gradient-to-r from-pink-500 to-purple-600 px-6 py-3 rounded text-xs font-black tracking-widest shadow-[0_0_15px_rgba(236,72,153,0.4)] hover:shadow-[0_0_25px_rgba(236,72,153,0.7)] transition-all uppercase flex items-center gap-2">
            <span>+</span> Tambah Turnamen
        </a>
    </div>

    {{-- PEMBUNGKUS FRAME TABEL --}}
    <div class="relative bg-white/[0.02] border border-purple-500/20 rounded-md overflow-hidden">
        {{-- Siku-siku pojok --}}
        <div class="absolute top-0 left-0 w-5 h-5 corner-tl"></div>
        <div class="absolute bottom-0 right-0 w-5 h-5 corner-br"></div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-pink-500 text-[10px] font-black uppercase tracking-[0.2em] border-b border-gray-800/80">
                    <tr>
                        <th class="p-6">Nama Turnamen</th>
                        <th class="p-6">Game</th>
                        <th class="p-6 text-center">Slot</th>
                        <th class="p-6 text-center">Status</th>
                        <th class="p-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-400">
                    @forelse ($tournaments as $tour)
                    <tr class="border-b border-gray-800/50 hover:bg-white/5 transition duration-200">
                        <td class="p-6 font-bold text-white">{{ $tour->nama_turnamen }}</td>
                        <td class="p-6">{{ $tour->game ? $tour->game->nama_game : 'Game N/A' }}</td>
                        <td class="p-6 text-center">
                            <span class="bg-blue-500/10 text-blue-400 border border-blue-500/20 px-2 py-1 rounded text-xs font-mono">
                                <span class="text-white font-bold">{{ $tour->teams->count() }}</span> / {{ $tour->max_slot }}
                            </span>
                        </td>
                        <td class="p-6 text-center">
                            <span class="px-3 py-1 rounded text-[10px] uppercase font-black tracking-wider
                                {{ $tour->status == 'Registration' ? 'bg-green-500/10 text-green-400 border border-green-500/30 shadow-[0_0_10px_rgba(74,222,128,0.2)]' : '' }}
                                {{ $tour->status == 'Ongoing' ? 'bg-yellow-500/10 text-yellow-400 border border-yellow-500/30' : '' }}
                                {{ $tour->status == 'Completed' ? 'bg-gray-500/10 text-gray-400 border border-gray-500/30' : '' }}">
                                {{ $tour->status }}
                            </span>
                        </td>
                        
                        <td class="p-6 text-right">
                            {{-- TOMBOL AKSI BER-FRAME --}}
                         <div class="flex items-center justify-end gap-2 relative z-10">
    {{-- Tombol EDIT --}}
    <a href="{{ route('tournaments.edit', $tour->id_tournament) }}" class="px-4 py-1.5 border border-gray-800 text-gray-400 text-[10px] font-black uppercase tracking-widest rounded-sm hover:border-blue-500/50 hover:text-blue-400 transition-all">
        Edit
    </a>

    {{-- Tombol PARTISIPAN --}}
    <a href="{{ route('tournaments.show', $tour->id_tournament ?? $tour->id) }}" class="px-4 py-1.5 border border-cyan-500/30 bg-cyan-500/10 text-cyan-400 text-[10px] font-black uppercase tracking-widest rounded-sm hover:bg-cyan-500 hover:text-white transition-all">
        Partisipan
    </a>

    {{-- Tombol HAPUS (Trigger Modal) --}}
    <button type="button" onclick="document.getElementById('modal-delete-{{ $tour->id_tournament }}').classList.remove('hidden')" class="px-4 py-1.5 border border-gray-800 text-gray-400 text-[10px] font-black uppercase tracking-widest rounded-sm hover:border-red-500/50 hover:text-red-500 transition-all">
        Hapus
    </button>
</div>

                            <div id="modal-delete-{{ $tour->id_tournament }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm">
                                
                                <div class="relative bg-[#0b0b13] border border-gray-800 p-8 max-w-lg w-full text-left shadow-[0_0_40px_rgba(239,68,68,0.15)] rounded-sm">
                                    <div class="absolute top-[-1px] left-[-1px] w-4 h-4 border-t-2 border-l-2 border-red-500"></div>
                                    <div class="absolute bottom-[-1px] right-[-1px] w-4 h-4 border-b-2 border-r-2 border-red-500"></div>

                                    <div class="flex items-start gap-4">
                                        <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center border border-red-500/40 bg-red-500/10 rounded-sm">
                                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        </div>
                                        <div class="pt-1">
                                            <h3 class="text-white text-2xl font-black uppercase tracking-wider">System Alert</h3>
                                            <p class="text-red-500 text-[10px] font-bold uppercase tracking-[0.2em] mt-1">Deletion Protocol Initiated</p>
                                        </div>
                                    </div>

                                    <p class="text-gray-400 text-sm mt-6 mb-8 leading-relaxed whitespace-normal">
                                        Data turnamen <strong class="text-white">{{ $tour->nama_turnamen }}</strong> ini akan dihapus secara permanen dari database ZeETOUR. Tindakan ini tidak dapat dibatalkan.
                                    </p>

                                    <div class="flex justify-end gap-4">
                                        <button type="button" onclick="document.getElementById('modal-delete-{{ $tour->id_tournament }}').classList.add('hidden')" class="px-6 py-2 border border-gray-800 hover:border-gray-600 text-gray-400 hover:text-white rounded-sm text-[10px] font-black uppercase tracking-widest transition cursor-pointer">
                                            Batalkan
                                        </button>
                                        
                                        <form action="{{ route('tournaments.destroy', $tour->id_tournament) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-sm text-[10px] font-black uppercase tracking-widest shadow-[0_0_15px_rgba(239,68,68,0.4)] transition cursor-pointer">
                                                Eksekusi Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-20 text-center relative">
                            <div class="text-pink-500/40 font-black text-2xl uppercase tracking-[0.3em] mb-2">No Tournaments Registered</div>
                            <div class="text-gray-500 text-xs tracking-wider">Belum ada turnamen yang mendaftar ke sistem.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection