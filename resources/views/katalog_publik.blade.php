<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PUBLIC CATALOG - ZeETOUR.GG</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body class="bg-[#050508] text-white font-sans antialiased min-h-screen relative overflow-x-hidden">

    {{-- Efek Cahaya Background --}}
    <div class="fixed top-0 left-1/4 w-96 h-96 bg-purple-600/10 rounded-full blur-[150px] pointer-events-none"></div>
    <div class="fixed bottom-0 right-1/4 w-96 h-96 bg-cyan-600/10 rounded-full blur-[150px] pointer-events-none"></div>
    <div class="fixed inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px] pointer-events-none"></div>

    {{-- NAVBAR --}}
    <nav class="border-b border-gray-800/80 bg-[#0a0a0f]/80 backdrop-blur-md sticky top-0 z-50 p-6 flex justify-between items-center shadow-[0_4px_30px_rgba(0,0,0,0.5)]">
        <h1 class="font-orbitron text-2xl font-black tracking-widest drop-shadow-[0_0_8px_rgba(255,255,255,0.2)]">
            ZeETOUR<span class="text-cyan-500">.GG</span>
        </h1>
        
        <div>
            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('games.index') }}" class="px-5 py-2.5 bg-cyan-500/10 border border-cyan-500 text-cyan-400 font-bold text-[10px] uppercase tracking-widest rounded-sm hover:bg-cyan-500 hover:text-white transition-all shadow-[0_0_15px_rgba(6,182,212,0.2)]">Admin Panel</a>
                @else
                    <a href="{{ route('my-teams.index') }}" class="px-5 py-2.5 bg-pink-500/10 border border-pink-500 text-pink-400 font-bold text-[10px] uppercase tracking-widest rounded-sm hover:bg-pink-500 hover:text-white transition-all shadow-[0_0_15px_rgba(236,72,153,0.2)]">Captain's HQ</a>
                @endif
            @else
                <a href="{{ route('login') }}" class="text-gray-400 hover:text-white font-bold text-[10px] uppercase tracking-widest mr-6 transition-colors">Login</a>
                <a href="{{ route('register') }}" class="px-5 py-2.5 bg-purple-500/10 border border-purple-500 text-purple-400 font-bold text-[10px] uppercase tracking-widest rounded-sm hover:bg-purple-500 hover:text-white transition-all shadow-[0_0_15px_rgba(168,85,247,0.2)]">Register Agent</a>
            @endauth
        </div>
    </nav>

    {{-- KONTEN UTAMA --}}
    <div class="max-w-6xl mx-auto px-8 py-12 relative z-10">
        
        {{-- Header Simetris --}}
        <div class="flex flex-col items-center justify-center text-center mb-10">
            <div class="flex items-center gap-2 mb-2">
                <span class="inline-block w-6 h-0.5 bg-cyan-400"></span>
                <span class="text-xs tracking-[4px] uppercase text-cyan-400 font-semibold">Tim</span>
                <span class="inline-block w-6 h-0.5 bg-cyan-400"></span>
            </div>
            <h1 class="font-orbitron text-4xl md:text-5xl font-black text-white uppercase tracking-wider drop-shadow-[0_0_15px_rgba(255,255,255,0.2)] mb-3">
                Registered Skuad
            </h1>
            <p class="text-sm text-gray-400 tracking-widest">Jelajahi daftar tim esports yang siap bertanding di turnamen.</p>
        </div>

      
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-[#0a0a0f] border border-pink-500/30 border-t-2 border-t-pink-500 rounded p-5 relative overflow-hidden group hover:shadow-[0_0_20px_rgba(236,72,153,0.15)] transition-all">
                <div class="absolute -right-4 -top-4 w-16 h-16 bg-pink-500/10 blur-xl rounded-full"></div>
                <div class="text-[11px] tracking-[2px] uppercase text-pink-500 font-semibold mb-1 flex items-center gap-2">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Total Skuad
                </div>
                <div class="font-orbitron text-3xl font-bold text-white">{{ $teams->count() }}</div>
            </div>
            
            <div class="bg-[#0a0a0f] border border-cyan-500/30 border-t-2 border-t-cyan-500 rounded p-5 relative overflow-hidden group hover:shadow-[0_0_20px_rgba(6,182,212,0.15)] transition-all">
                <div class="absolute -right-4 -top-4 w-16 h-16 bg-cyan-500/10 blur-xl rounded-full"></div>
                <div class="text-[11px] tracking-[2px] uppercase text-cyan-500 font-semibold mb-1 flex items-center gap-2">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Total Agents
                </div>
                <div class="font-orbitron text-3xl font-bold text-white">{{ \App\Models\Player::count() }}</div>
            </div>

            <div class="bg-[#0a0a0f] border border-purple-500/30 border-t-2 border-t-purple-500 rounded p-5 relative overflow-hidden group hover:shadow-[0_0_20px_rgba(168,85,247,0.15)] transition-all">
                <div class="absolute -right-4 -top-4 w-16 h-16 bg-purple-500/10 blur-xl rounded-full"></div>
                <div class="text-[11px] tracking-[2px] uppercase text-purple-500 font-semibold mb-1 flex items-center gap-2">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    Divisi Game
                </div>
                <div class="font-orbitron text-3xl font-bold text-white">{{ \App\Models\Game::count() }}</div>
            </div>
        </div>

        {{-- GRID KARTU TIM (Simetris & Full Width) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($teams as $team)
                <a href="{{ route('katalog.roster', $team) }}" class="block bg-[#0a0a0f] border border-gray-800 p-6 rounded-sm group hover:border-cyan-500/50 hover:bg-[#0f0f15] transition-all duration-300 relative overflow-hidden w-full cursor-pointer">
                    {{-- Siku Hiasan Kartu ala Gambar 2 --}}
                    <div class="absolute top-0 left-0 w-4 h-4 border-t-2 border-l-2 border-cyan-500/80 opacity-50 group-hover:opacity-100 transition-opacity"></div>
                    <div class="absolute bottom-0 right-0 w-4 h-4 border-b-2 border-r-2 border-pink-500/80 opacity-50 group-hover:opacity-100 transition-opacity"></div>

                    <div class="flex items-center gap-4 mb-6">
                        {{-- Logo Tim Kecil --}}
                        <div class="w-16 h-16 bg-[#050508] border border-gray-800 rounded flex-shrink-0 p-1 flex items-center justify-center group-hover:border-cyan-500/30 transition-colors">
                            @if($team->logo_path)
                                <img src="{{ asset('storage/' . $team->logo_path) }}" class="max-w-full max-h-full object-contain">
                            @else
                                <span class="text-2xl">🛡️</span>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-orbitron text-xl font-bold text-white uppercase tracking-wider group-hover:text-cyan-400 transition-colors">{{ $team->nama_tim }}</h3>
                            <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest mt-1">Est: {{ $team->created_at->format('Y') }}</p>
                        </div>
                    </div>

                    <div class="flex justify-between items-end border-t border-gray-800/50 pt-4 mt-auto">
                        <div>
                            <p class="text-[9px] text-gray-500 tracking-widest uppercase mb-1.5">Division</p>
                            <span class="px-2.5 py-1 bg-purple-500/10 border border-purple-500/30 text-purple-400 text-[9px] font-black uppercase tracking-widest rounded-sm">
                                {{ $team->game->nama_game ?? 'UNKNOWN' }}
                            </span>
                        </div>
                        <div class="text-right">
                            <p class="text-[9px] text-gray-500 tracking-widest uppercase mb-1">Agents</p>
                            <span class="font-mono text-cyan-400 font-bold text-sm">{{ $team->players ? $team->players->count() : 0 }}</span>
                            <span class="text-[10px] text-gray-600">/ 5</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full border border-gray-800 border-dashed py-20 text-center bg-[#050508]/50 rounded-sm">
                    <span class="text-gray-500 font-mono text-sm tracking-widest uppercase">// NO SQUADS REGISTERED YET //</span>
                </div>
            @endforelse
        </div>
        
    </div>

    {{-- ======================================================== --}}
    {{-- SECTION: PUBLIC TOURNAMENTS & LIVE MATCHES               --}}
    {{-- ======================================================== --}}
    <div class="max-w-6xl mx-auto px-8 py-16 mt-4 relative z-10">

        {{-- Divider --}}
        <div class="relative flex items-center gap-4 mb-16">
            <div class="flex-1 h-[1px] bg-gradient-to-r from-transparent to-cyan-500/40"></div>
            <div class="flex items-center gap-2 px-4 py-1.5 border border-cyan-500/30 bg-cyan-500/5 rounded-sm">
                <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-pulse"></span>
                <span class="font-orbitron text-[9px] font-black tracking-[0.3em] text-cyan-400 uppercase whitespace-nowrap">Live Arena</span>
            </div>
            <div class="flex-1 h-[1px] bg-gradient-to-l from-transparent to-cyan-500/40"></div>
        </div>

        {{-- Section Header --}}
        <div class="mb-12">
            <div class="flex items-center gap-3 mb-3">
                <div class="flex gap-1">
                    <span class="w-1 h-6 bg-pink-500 rounded-sm"></span>
                    <span class="w-1 h-6 bg-pink-500/50 rounded-sm"></span>
                    <span class="w-1 h-6 bg-pink-500/20 rounded-sm"></span>
                </div>
                <span class="text-[10px] font-black tracking-[0.4em] text-pink-500/70 uppercase font-orbitron">Tournament Feed</span>
            </div>
            <h2 class="font-orbitron text-3xl md:text-4xl font-black text-white uppercase tracking-wider leading-none">
                Public <span class="text-pink-500" style="text-shadow: 0 0 20px rgba(236,72,153,0.5)">Tournaments</span>
                <span class="block text-2xl md:text-3xl text-gray-400 mt-1">&amp; Live Matches</span>
            </h2>
        </div>

        {{-- Tournament List --}}
        <div class="flex flex-col gap-10">
            @forelse($tournaments as $turnamen)

            <div class="relative">
                {{-- Tournament Header --}}
                <div class="flex items-center gap-4 mb-4">
                    <div class="flex items-center gap-3 flex-1">
                        <div class="w-8 h-8 flex items-center justify-center bg-pink-500/10 border border-pink-500/30 rounded-sm flex-shrink-0">
                            <svg class="w-4 h-4 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        </div>
                        <div>
                            <a href="{{ route('arena.show', $turnamen->id_tournament) }}" class="font-orbitron text-sm font-black text-white uppercase tracking-widest hover:text-cyan-400 transition-colors block cursor-pointer">
                                {{ $turnamen->nama_turnamen }}
                            </a>
                            @if($turnamen->game)
                            <span class="text-[9px] text-gray-500 tracking-widest uppercase">{{ $turnamen->game->nama_game }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-[9px] font-mono text-gray-600 tracking-wider">{{ $turnamen->matches->count() }} Match</span>
                        <span class="px-2.5 py-1 bg-green-500/10 border border-green-500/30 text-green-400 text-[9px] font-black uppercase tracking-widest rounded-sm">Active Arena</span>
                    </div>
                </div>

                {{-- Tournament Box --}}
                <div class="relative bg-[#0a0a0f]/80 border border-gray-800/60 rounded-sm overflow-hidden">
                    {{-- Corner accents --}}
                    <div class="absolute top-0 left-0 w-5 h-5 border-t-2 border-l-2 border-pink-500/60"></div>
                    <div class="absolute bottom-0 right-0 w-5 h-5 border-b-2 border-r-2 border-cyan-500/60"></div>

                    {{-- Top bar accent --}}
                    <div class="h-[2px] bg-gradient-to-r from-pink-500/80 via-purple-500/50 to-transparent"></div>

                    @if($turnamen->matches->count() > 0)
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($turnamen->matches as $match)

                        {{-- Match Card --}}
                        <div class="relative bg-[#050508] border rounded-sm overflow-hidden transition-all duration-300
                            {{ $match->status == 'Live'
                                ? 'border-red-500/50 shadow-[0_0_20px_rgba(239,68,68,0.12)]'
                                : ($match->status == 'Completed'
                                    ? 'border-gray-800/40'
                                    : 'border-gray-800 hover:border-cyan-500/30') }}">

                            {{-- Status bar atas --}}
                            <div class="h-[2px]
                                {{ $match->status == 'Live'
                                    ? 'bg-red-500'
                                    : ($match->status == 'Completed'
                                        ? 'bg-gray-700'
                                        : 'bg-cyan-500/40') }}">
                            </div>

                            <div class="p-4">
                                {{-- Baris atas: tanggal + babak --}}
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-[9px] font-mono text-gray-600 tracking-wider">
                                        {{ \Carbon\Carbon::parse($match->waktu_tanding)->format('d M · H:i') }}
                                    </span>
                                    <span class="text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded-sm
                                        {{ $match->status == 'Live'
                                            ? 'text-red-400 border border-red-500/30 bg-red-500/10'
                                            : 'text-pink-500/80 border border-gray-800 bg-transparent' }}">
                                        {{ $match->keterangan }}
                                    </span>
                                </div>

                                {{-- Area VS / Skor --}}
                                <div class="flex items-center justify-between gap-2">
                                    {{-- Tim A --}}
                                    <div class="flex-1 text-right">
                                        <span class="font-orbitron font-black text-white text-xs tracking-wide block truncate
                                            {{ $match->status == 'Completed' && $match->score_a > $match->score_b ? 'text-cyan-400' : '' }}">
                                            {{ $match->teamA ? $match->teamA->singkatan : 'TBD' }}
                                        </span>
                                    </div>
                                {{-- Badge Tengah --}}
                                <div class="flex-shrink-0 w-auto px-2 flex justify-center">
                                    @if($match->status == 'Upcoming')
                                        <span class="font-orbitron font-black text-[10px] text-cyan-400 tracking-widest px-2 py-1 bg-cyan-950/20 border border-cyan-500/30 rounded-sm whitespace-nowrap">VS</span>
                                    @elseif($match->status == 'Live')
                                        <span class="font-orbitron font-black text-sm text-red-400 tracking-widest px-2 py-0.5 bg-red-500/10 border border-red-500/40 rounded-sm animate-pulse whitespace-nowrap">
                                            {{ $match->score_a }} - {{ $match->score_b }}
                                        </span>
                                    @else
                                        <span class="font-orbitron font-black text-sm text-pink-400 tracking-widest px-2 py-0.5 bg-pink-950/10 border border-pink-500/20 rounded-sm whitespace-nowrap" style="text-shadow: 0 0 8px rgba(236,72,153,0.5)">
                                            {{ $match->score_a }} - {{ $match->score_b }}
                                        </span>
                                    @endif
                                </div>

                                    {{-- Tim B --}}
                                    <div class="flex-1 text-left">
                                        <span class="font-orbitron font-black text-white text-xs tracking-wide block truncate
                                            {{ $match->status == 'Completed' && $match->score_b > $match->score_a ? 'text-cyan-400' : '' }}">
                                            {{ $match->teamB ? $match->teamB->singkatan : 'TBD' }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Footer status --}}
                                @if($match->status == 'Live')
                                <div class="mt-4 pt-3 border-t border-red-950/50 flex justify-center">
                                    <span class="inline-flex items-center gap-1.5 text-[8px] font-black tracking-[0.2em] uppercase text-red-400">
                                        <span class="relative flex h-2 w-2">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                                        </span>
                                        Live Now
                                    </span>
                                </div>
                                @elseif($match->status == 'Completed')
                                <div class="mt-4 pt-3 border-t border-gray-900/50 flex justify-center">
                                    <span class="text-[8px] font-mono font-bold tracking-widest uppercase text-gray-700">Match Concluded</span>
                                </div>
                                @else
                                <div class="mt-4 pt-3 border-t border-gray-900/50 flex justify-center">
                                    <span class="text-[8px] font-mono font-bold tracking-widest uppercase text-gray-700">Scheduled</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        @endforeach
                    </div>
                    @else
                    <div class="py-12 text-center">
                        <p class="text-[10px] font-mono text-gray-700 font-bold tracking-widest uppercase">// Arena Streams Currently Offline //</p>
                    </div>
                    @endif
                </div>
            </div>

            @empty
            <div class="py-20 text-center border border-dashed border-cyan-900/30 rounded-sm bg-[#0a0a0f]/30 relative">
                <div class="absolute top-0 left-0 w-3 h-3 border-t border-l border-cyan-900"></div>
                <div class="absolute bottom-0 right-0 w-3 h-3 border-b border-r border-cyan-900"></div>
                <p class="text-gray-600 font-orbitron text-xs tracking-[0.2em] uppercase">// No Operational Tournaments At This Moment //</p>
            </div>
            @endforelse
        </div>
    </div>

</body>
</html>