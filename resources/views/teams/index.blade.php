@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">

    {{-- ══════════════════════════════════════════
         HEADER
    ══════════════════════════════════════════ --}}
    <div class="flex items-center justify-between mb-10">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="h-[1px] w-8 bg-pink-500"></div>
                <span class="text-[10px] font-orbitron tracking-[0.3em] text-pink-500 uppercase shadow-[0_0_10px_rgba(236,72,153,0.5)]">Master Data</span>
            </div>
            <h1 class="text-4xl font-orbitron font-black text-white tracking-widest uppercase">
                Team Roster
            </h1>
            <p class="text-pink-100/50 text-sm mt-2 font-light tracking-wide">Kelola daftar tim esports yang akan bertanding di ZeEtz Esports.</p>
        </div>

        <a href="{{ route('teams.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-pink-600 to-purple-600 text-white font-bold text-sm tracking-widest uppercase rounded-sm shadow-[0_0_20px_rgba(236,72,153,0.3)] hover:shadow-[0_0_30px_rgba(236,72,153,0.6)] hover:-translate-y-0.5 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Tim
        </a>
    </div>

    {{-- ══════════════════════════════════════════
         STAT CARDS
    ══════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-10">

        {{-- Card: Total Tim --}}
        <div class="relative bg-[#08090f] border border-pink-500/20 rounded-md px-6 py-5 shadow-[0_0_20px_rgba(236,72,153,0.05)] overflow-hidden group hover:border-pink-500/40 transition-all">
            <div class="absolute top-0 left-0 w-5 h-5 border-t-2 border-l-2 border-pink-500/60 rounded-tl-md"></div>
            <div class="absolute bottom-0 right-0 w-5 h-5 border-b-2 border-r-2 border-pink-500/60 rounded-br-md"></div>
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-pink-500/5 rounded-full group-hover:bg-pink-500/10 transition-all"></div>
            <div class="flex items-center gap-4 relative z-10">
                <div class="w-12 h-12 rounded-sm bg-pink-500/10 border border-pink-500/30 flex items-center justify-center shadow-[0_0_10px_rgba(236,72,153,0.2)]">
                    <svg class="w-6 h-6 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-orbitron tracking-[0.2em] text-pink-500/70 uppercase mb-1">Total Tim</p>
                    <p class="text-3xl font-orbitron font-black text-white">{{ $totalTeams }} <span class="text-sm font-normal text-pink-400/70 tracking-widest">Skuad</span></p>
                </div>
            </div>
        </div>

        {{-- Card: Total Player --}}
        <div class="relative bg-[#08090f] border border-cyan-500/20 rounded-md px-6 py-5 shadow-[0_0_20px_rgba(6,182,212,0.05)] overflow-hidden group hover:border-cyan-500/40 transition-all">
            <div class="absolute top-0 left-0 w-5 h-5 border-t-2 border-l-2 border-cyan-500/60 rounded-tl-md"></div>
            <div class="absolute bottom-0 right-0 w-5 h-5 border-b-2 border-r-2 border-cyan-500/60 rounded-br-md"></div>
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-cyan-500/5 rounded-full group-hover:bg-cyan-500/10 transition-all"></div>
            <div class="flex items-center gap-4 relative z-10">
                <div class="w-12 h-12 rounded-sm bg-cyan-500/10 border border-cyan-500/30 flex items-center justify-center shadow-[0_0_10px_rgba(6,182,212,0.2)]">
                    <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-orbitron tracking-[0.2em] text-cyan-500/70 uppercase mb-1">Total Player</p>
                    <p class="text-3xl font-orbitron font-black text-white">{{ $totalPlayers }} <span class="text-sm font-normal text-cyan-400/70 tracking-widest">Agents</span></p>
                </div>
            </div>
        </div>

        {{-- Card: Game Paling Populer --}}
        <div class="relative bg-[#08090f] border border-purple-500/20 rounded-md px-6 py-5 shadow-[0_0_20px_rgba(168,85,247,0.05)] overflow-hidden group hover:border-purple-500/40 transition-all">
            <div class="absolute top-0 left-0 w-5 h-5 border-t-2 border-l-2 border-purple-500/60 rounded-tl-md"></div>
            <div class="absolute bottom-0 right-0 w-5 h-5 border-b-2 border-r-2 border-purple-500/60 rounded-br-md"></div>
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-purple-500/5 rounded-full group-hover:bg-purple-500/10 transition-all"></div>
            <div class="flex items-center gap-4 relative z-10">
                <div class="w-12 h-12 rounded-sm bg-purple-500/10 border border-purple-500/30 flex items-center justify-center shadow-[0_0_10px_rgba(168,85,247,0.2)]">
                    <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] font-orbitron tracking-[0.2em] text-purple-500/70 uppercase mb-1">Game Populer</p>
                    <p class="text-xl font-orbitron font-black text-white truncate">{{ $popularGameName }}</p>
                </div>
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════════
         TABEL
    ══════════════════════════════════════════ --}}


    <div class="relative bg-[#08090f] border border-pink-500/20 rounded-md shadow-[0_0_30px_rgba(236,72,153,0.05)]">
        <div class="absolute top-0 left-0 w-8 h-8 border-t-2 border-l-2 border-pink-500/80 rounded-tl-md"></div>
        <div class="absolute bottom-0 right-0 w-8 h-8 border-b-2 border-r-2 border-pink-500/80 rounded-br-md"></div>

        <table class="w-full text-left border-collapse relative z-10">
            <thead>
                <tr class="border-b border-pink-500/20 bg-pink-500/5">
                    <th class="px-5 py-5 text-[10px] font-orbitron tracking-[0.2em] text-pink-500 uppercase font-bold w-16">Logo</th>
                    <th class="px-5 py-5 text-[10px] font-orbitron tracking-[0.2em] text-pink-500 uppercase font-bold w-20">#ID</th>
                    <th class="px-5 py-5 text-[10px] font-orbitron tracking-[0.2em] text-pink-500 uppercase font-bold">Nama Tim</th>
                    <th class="px-5 py-5 text-[10px] font-orbitron tracking-[0.2em] text-pink-500 uppercase font-bold">Kapten</th>
                    <th class="px-5 py-5 text-[10px] font-orbitron tracking-[0.2em] text-pink-500 uppercase font-bold">Divisi</th>
                    <th class="px-5 py-5 text-[10px] font-orbitron tracking-[0.2em] text-pink-500 uppercase font-bold text-center w-48">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($teams as $team)
                <tr class="border-b border-pink-500/10 hover:bg-pink-500/5 transition-colors group">

                    {{-- LOGO --}}
                    <td class="px-5 py-4">
                        @if($team->logo_path)
                            <img src="{{ Storage::url($team->logo_path) }}"
                                 alt="Logo {{ $team->nama_tim }}"
                                 class="w-10 h-10 object-contain rounded-sm border border-pink-500/20 bg-[#0b0c16] p-0.5">
                        @else
                            <div class="w-10 h-10 rounded-sm border border-pink-500/20 bg-[#0b0c16] flex items-center justify-center text-pink-500/30">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                    </td>

                    {{-- ID --}}
                    <td class="px-5 py-4">
                        <span class="text-sm font-bold text-pink-500/50 group-hover:text-pink-400 transition-colors font-orbitron">
                            #{{ sprintf('%03d', $team->id_team) }}
                        </span>
                    </td>

                    {{-- NAMA TIM --}}
                    <td class="px-5 py-4">
                        <span class="font-orbitron text-white tracking-wider font-bold text-base">{{ $team->nama_tim }}</span>
                    </td>

                    {{-- KAPTEN --}}
                    <td class="px-5 py-4">
                        <span class="inline-block px-3 py-1 text-[11px] font-bold tracking-widest uppercase text-cyan-400 bg-cyan-500/10 border border-cyan-500/30 rounded-sm">
                            <i class="fas fa-user-shield mr-1"></i> {{ $team->captain ? $team->captain->name : 'Tanpa Kapten' }}
                        </span>
                    </td>

                    {{-- DIVISI/GAME --}}
                    <td class="px-5 py-4">
                        @if($team->game)
                        <span class="inline-block px-3 py-1 text-[11px] font-bold tracking-widest uppercase text-purple-400 bg-purple-500/10 border border-purple-500/30 rounded-sm">
                            {{ $team->game->nama_game }}
                        </span>
                        @else
                        <span class="text-pink-500/30 text-sm">-</span>
                        @endif
                    </td>

                    {{-- AKSI --}}
                    <td class="px-5 py-4">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('teams.edit', $team->id_team) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-[11px] font-bold tracking-widest uppercase text-blue-400 border border-blue-400/30 rounded-sm hover:bg-blue-400/10 transition-all">
                                Edit
                            </a>
                            <a href="{{ route('teams.show', $team->id_team) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-[11px] font-bold tracking-widest uppercase text-cyan-400 border border-cyan-400/30 rounded-sm hover:bg-cyan-400/10 transition-all">
                                Roster
                            </a>
                            <form action="{{ route('teams.destroy', $team->id_team) }}" method="POST" class="inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn-delete inline-flex items-center gap-1.5 px-3 py-1.5 text-[11px] font-bold tracking-widest uppercase text-red-400 border border-red-400/30 rounded-sm hover:bg-red-400/10 transition-all cursor-pointer">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-7 py-20 text-center">
                        <div class="text-pink-500/30 font-orbitron text-xl mb-2 font-black tracking-widest">NO TEAMS REGISTERED</div>
                        <div class="text-pink-400/50 text-sm">Belum ada skuad yang mendaftar ke turnamen.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            let form = this.closest('form');
            Swal.fire({
                title: 'BUBARKAN SKUAD?',
                text: "Data tim yang dihapus tidak bisa dikembalikan ke roster!",
                icon: 'warning',
                showCancelButton: true,
                background: '#0b0c16',
                color: '#ffffff',
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#374151',
                confirmButtonText: 'YA, BUBARKAN!',
                cancelButtonText: 'BATAL',
                customClass: {
                    popup: 'border border-red-500/50 shadow-[0_0_20px_rgba(239,68,68,0.2)]',
                    title: 'font-orbitron tracking-widest',
                }
            }).then((result) => {
                if (result.isConfirmed) { form.submit(); }
            });
        });
    });
</script>
@endsection
