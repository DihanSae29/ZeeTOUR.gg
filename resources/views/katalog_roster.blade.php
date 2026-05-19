<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $team->nama_tim }} ROSTER - ZeeTOUR.GG</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body class="bg-[#050508] text-white font-sans antialiased min-h-screen relative overflow-x-hidden">

    {{-- Tombol Kembali --}}
    <a href="{{ route('landing') }}" class="fixed top-24 left-8 z-50 flex items-center gap-3 text-[10px] text-gray-500 hover:text-cyan-400 font-bold tracking-[0.2em] uppercase transition-all group hidden md:flex">
        <div class="w-8 h-8 rounded bg-[#0a0a0f] border border-gray-800 group-hover:border-cyan-500 group-hover:shadow-[0_0_15px_rgba(6,182,212,0.3)] flex items-center justify-center transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </div>
        Return
    </a>

    {{-- Efek Cahaya --}}
    <div class="fixed top-0 left-1/4 w-96 h-96 bg-purple-600/10 rounded-full blur-[150px] pointer-events-none"></div>
    <div class="fixed bottom-0 right-1/4 w-96 h-96 bg-cyan-600/10 rounded-full blur-[150px] pointer-events-none"></div>
    <div class="fixed inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px] pointer-events-none"></div>

    {{-- NAVBAR (Sama kayak landing page) --}}
    <nav class="border-b border-gray-800/80 bg-[#0a0a0f]/80 backdrop-blur-md sticky top-0 z-50 p-6 flex justify-between items-center shadow-[0_4px_30px_rgba(0,0,0,0.5)]">
        <h1 class="font-orbitron text-2xl font-black tracking-widest drop-shadow-[0_0_8px_rgba(255,255,255,0.2)]">
            ZeeTOUR<span class="text-cyan-500">.GG</span>
        </h1>
        <div>
            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('games.index') }}" class="px-5 py-2.5 bg-cyan-500/10 border border-cyan-500 text-cyan-400 font-bold text-[10px] uppercase tracking-widest rounded-sm hover:bg-cyan-500 hover:text-white transition-all">Admin Panel</a>
                @else
                    <a href="{{ route('my-teams.index') }}" class="px-5 py-2.5 bg-pink-500/10 border border-pink-500 text-pink-400 font-bold text-[10px] uppercase tracking-widest rounded-sm hover:bg-pink-500 hover:text-white transition-all">Captain's HQ</a>
                @endif
            @else
                <a href="{{ route('login') }}" class="text-gray-400 hover:text-white font-bold text-[10px] uppercase tracking-widest mr-6 transition-colors">Login</a>
                <a href="{{ route('register') }}" class="px-5 py-2.5 bg-purple-500/10 border border-purple-500 text-purple-400 font-bold text-[10px] uppercase tracking-widest rounded-sm hover:bg-purple-500 hover:text-white transition-all">Register Agent</a>
            @endauth
        </div>
    </nav>

    {{-- KONTEN UTAMA --}}
    <div class="max-w-5xl mx-auto px-8 py-12 relative z-10">
        
        {{-- Header Profil Tim --}}
        <div class="flex flex-col md:flex-row items-center gap-8 mb-12 bg-[#0a0a0f] border border-gray-800 p-8 rounded-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-cyan-500/10 blur-2xl rounded-full"></div>
            
            <div class="w-32 h-32 bg-[#050508] border-2 border-gray-800 rounded flex-shrink-0 p-2 flex items-center justify-center">
                @if($team->logo_path)
                    <img src="{{ asset('storage/' . $team->logo_path) }}" class="max-w-full max-h-full object-contain">
                @else
                    <span class="text-5xl">🛡️</span>
                @endif
            </div>

            <div class="text-center md:text-left flex-1">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-purple-500/10 border border-purple-500/30 text-purple-400 text-[9px] font-black uppercase tracking-widest rounded-sm mb-3">
                    {{ $team->game->nama_game ?? 'UNKNOWN DIVISION' }}
                </div>
                <h1 class="font-orbitron text-4xl font-black text-white uppercase tracking-wider mb-2 drop-shadow-[0_0_10px_rgba(255,255,255,0.1)]">
                    {{ $team->nama_tim }}
                </h1>
                <p class="text-xs text-gray-500 tracking-widest uppercase font-mono">Captain: <span class="text-cyan-400">{{ $team->captain->name ?? 'SYSTEM' }}</span> // Est: {{ $team->created_at->format('Y') }}</p>
            </div>
            
            <div class="text-center md:text-right border-t md:border-t-0 md:border-l border-gray-800 pt-6 md:pt-0 md:pl-8">
                <p class="text-[10px] text-gray-500 tracking-widest uppercase mb-2">Active Roster</p>
                <div class="font-orbitron text-5xl font-black text-white">{{ $team->players->count() }}<span class="text-2xl text-gray-600">/5</span></div>
            </div>
        </div>

        {{-- GRID PEMAIN (BISA DI-KLIK BUAT LIAT ID CARD) --}}
        <div class="flex items-center gap-2 mb-6">
            <span class="inline-block w-4 h-0.5 bg-cyan-400"></span>
            <span class="text-xs tracking-[4px] uppercase text-cyan-400 font-semibold">Verified Agents</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($team->players as $player)
                {{-- KARTU PEMAIN LU (Udah ditambahin onclick dan cursor-pointer) --}}
                <div onclick="document.getElementById('modal-idcard-{{ $player->id_player }}').classList.remove('hidden')" class="bg-[#0a0a0f] border border-gray-800 p-6 rounded-sm group hover:border-cyan-500/30 transition-all duration-300 relative cursor-pointer">
                    <div class="absolute top-0 left-0 w-3 h-3 border-t-2 border-l-2 border-cyan-500/50 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="absolute bottom-0 right-0 w-3 h-3 border-b-2 border-r-2 border-cyan-500/50 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    
                    <p class="text-gray-500 text-xs font-mono tracking-wider mb-4">{{ $player->nama_asli }}</p>
                    <h3 class="font-orbitron text-2xl font-black text-white uppercase tracking-wider mb-6 group-hover:text-cyan-400 transition-colors drop-shadow-[0_0_8px_rgba(6,182,212,0)] group-hover:drop-shadow-[0_0_8px_rgba(6,182,212,0.5)]">
                        "{{ $player->nickname }}"
                    </h3>
                    
                    <div class="flex items-center justify-between border-t border-gray-800/80 pt-4">
                        <span class="text-[9px] font-bold tracking-widest text-gray-500 uppercase">Specialist Role</span>
                        <span class="px-2.5 py-1 bg-white/5 text-gray-300 border border-gray-700 text-[9px] font-black tracking-widest uppercase rounded-sm">
                            {{ $player->role }}
                        </span>
                    </div>
                </div>

                {{-- ======================================================== --}}
                {{-- MODAL ID CARD MAUT (NGUMPET DI SINI)                     --}}
                {{-- ======================================================== --}}
                <div id="modal-idcard-{{ $player->id_player }}" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/90 backdrop-blur-md cursor-default" onclick="event.stopPropagation()">
                    {{-- Overlay Close --}}
                    <div class="absolute inset-0" onclick="document.getElementById('modal-idcard-{{ $player->id_player }}').classList.add('hidden')"></div>

                    {{-- ID CARD CONTAINER --}}
                    <div class="relative w-[500px] max-w-[90vw] bg-[#050508] border-2 border-gray-800 shadow-[0_0_50px_rgba(34,211,238,0.2)] rounded-sm overflow-hidden flex flex-col md:flex-row">
                        
                        {{-- Sisi Kiri: Foto --}}
                        <div class="w-full md:w-2/5 h-48 md:h-auto bg-gray-950 border-b md:border-b-0 md:border-r border-gray-800 relative overflow-hidden flex-shrink-0">
                            @if($player->photo)
                                <img src="{{ asset('storage/' . $player->photo) }}" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-800 font-black text-4xl">NO IMG</div>
                            @endif
                            <div class="absolute inset-0 bg-[linear-gradient(transparent_50%,rgba(0,0,0,0.3)_50%)] bg-[length:100%_4px] pointer-events-none"></div>
                            <div class="absolute bottom-2 left-2 bg-black/60 border border-cyan-500/50 p-1 rounded-sm">
                                <p class="text-[7px] text-cyan-400 font-mono leading-none">TEAM ASSIGNED</p>
                                <p class="text-[10px] text-white font-bold font-orbitron">{{ $team->nama_tim ?? 'UNKNOWN' }}</p>
                            </div>
                        </div>

                        {{-- Sisi Kanan: Biodata --}}
                        <div class="w-full md:w-3/5 p-6 relative">
                            <div class="mb-6">
                                <p class="text-[8px] font-mono text-cyan-500 tracking-[0.3em] uppercase mb-1">Validated Identity</p>
                                <h2 class="text-3xl font-black text-white font-orbitron leading-none tracking-tighter italic">"{{ $player->nickname }}"</h2>
                                <p class="text-[10px] text-gray-500 font-bold uppercase mt-1 tracking-widest">{{ $player->nama_asli }}</p>
                            </div>
                            <div class="space-y-3 mb-6">
                                <div>
                                    <p class="text-[8px] font-mono text-gray-600 uppercase">Role / Class</p>
                                    <p class="text-xs font-bold text-pink-500 uppercase tracking-tighter">{{ $player->role }}</p>
                                </div>
                                <div>
                                    <p class="text-[8px] font-mono text-gray-600 uppercase">Personal Motto</p>
                                    <p class="text-[10px] text-gray-300 italic leading-relaxed">"{{ $player->bio ?? 'No records found.' }}"</p>
                                </div>
                                <div>
                                    <p class="text-[8px] font-mono text-gray-600 uppercase">Network Access</p>
                                    <p class="text-[10px] text-cyan-400 font-bold">IG: {{ $player->instagram ?? '@restricted' }}</p>
                                </div>
                            </div>
                            <div class="pt-4 border-t border-gray-900 flex justify-between items-end">
                                <div>
                                    <p class="text-[7px] text-gray-600 font-mono uppercase">Enlistment Date</p>
                                    <p class="text-[9px] text-white font-bold">{{ $player->created_at ? $player->created_at->format('d.M.Y') : 'UNKNOWN' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[7px] text-gray-600 font-mono uppercase">Access Key</p>
                                    <p class="text-[9px] text-white font-mono tracking-tighter">ZEE-{{ $player->id_player }}-{{ rand(100,999) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="absolute top-0 left-0 w-4 h-4 border-t border-l border-cyan-500"></div>
                        <div class="absolute bottom-0 right-0 w-4 h-4 border-b border-r border-pink-500"></div>
                    </div>
                </div>

            @empty
                <div class="col-span-full border border-gray-800 border-dashed py-16 text-center bg-[#050508]/50 rounded-sm">
                    <span class="text-gray-500 font-mono text-sm tracking-widest uppercase">// NO AGENTS DEPLOYED YET //</span>
                </div>
            @endforelse
        </div>
    </div>

</body>
</html>