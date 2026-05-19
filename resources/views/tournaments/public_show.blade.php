<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arena Leaderboard - ZeeTOUR.GG</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body class="bg-[#050508] text-white font-sans antialiased min-h-screen relative overflow-x-hidden">

     {{-- NAVBAR --}}
    <nav class="border-b border-gray-800/80 bg-[#0a0a0f]/80 backdrop-blur-md sticky top-0 z-50 p-6 flex justify-between items-center shadow-[0_4px_30px_rgba(0,0,0,0.5)]">
        <h1 class="font-orbitron text-2xl font-black tracking-widest drop-shadow-[0_0_8px_rgba(255,255,255,0.2)]">
            ZeeTOUR<span class="text-cyan-500">.GG</span>
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
    
        <div class="max-w-6xl mx-auto px-4 py-12 relative z-10">
            
            {{-- Tombol Back --}}
            <a href="{{ route('landing') }}" class="text-pink-500 hover:text-pink-400 text-[10px] font-bold tracking-widest uppercase mb-8 flex items-center gap-2 w-fit">
                <span class="text-lg leading-none">«</span> RETURN TO ARENA
            </a>

            {{-- Header Turnamen --}}
            <div class="mb-12 border-l-4 border-cyan-500 pl-4">
                <h2 class="text-3xl font-black text-white font-orbitron uppercase tracking-wider">
                    {{ $tournament->nama_turnamen }}
                </h2>
                <p class="text-gray-500 text-[10px] mt-2 font-mono uppercase tracking-widest">// OFFICIAL TOURNAMENT STANDINGS & LEADERBOARD</p>
            </div>

            {{-- Tabel Leaderboard Klasemen --}}
            <div class="bg-[#0a0a0f]/80 border border-gray-800 shadow-[0_0_20px_rgba(0,0,0,0.5)] rounded-sm overflow-hidden mb-12 relative group">
                {{-- Siku Hiasan --}}
                <div class="absolute top-0 left-0 w-4 h-4 border-t-2 border-l-2 border-cyan-500/50"></div>
                <div class="absolute bottom-0 right-0 w-4 h-4 border-b-2 border-r-2 border-pink-500/50"></div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left whitespace-nowrap">
                        <thead class="bg-[#050508] border-b border-gray-800">
                            <tr>
                                <th class="p-4 text-center text-[10px] font-bold text-cyan-400 tracking-widest uppercase w-16">RANK</th>
                                <th class="p-4 text-[10px] font-bold text-gray-400 tracking-widest uppercase">TEAM SQUAD</th>
                                <th class="p-4 text-center text-[10px] font-bold text-gray-400 tracking-widest uppercase w-16" title="Played">Match</th>
                                <th class="p-4 text-center text-[10px] font-bold text-green-400 tracking-widest uppercase w-16" title="Won">W</th>
                                <th class="p-4 text-center text-[10px] font-bold text-red-400 tracking-widest uppercase w-16" title="Lost">L</th>
                                <th class="p-4 text-center text-[10px] font-bold text-gray-400 tracking-widest uppercase w-20" title="Map Difference (Won - Lost)">+/-</th>
                                <th class="p-4 text-center text-xs font-black text-pink-500 tracking-widest uppercase w-20">PTS</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800/50">
                            @forelse($leaderboard as $index => $row)
                                <tr class="hover:bg-[#101018] transition-colors {{ $index === 0 ? 'bg-cyan-950/10' : '' }}">
                                    <td class="p-4 text-center font-orbitron font-black text-white text-lg">
                                        @if($index === 0)
                                            <span class="text-yellow-400 drop-shadow-[0_0_5px_rgba(250,204,21,0.8)]">1</span>
                                        @else
                                            <span class="text-gray-500">{{ $index + 1 }}</span>
                                        @endif
                                    </td>
                                    <td class="p-4 font-black text-white uppercase tracking-wider">
                                        {{ $row['team']->nama_tim }}
                                        @if($index === 0)
                                            <span class="ml-2 px-2 py-0.5 text-[8px] bg-yellow-500/20 text-yellow-500 border border-yellow-500/50 rounded-sm uppercase tracking-widest font-mono">Top</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-center font-mono text-gray-400">{{ $row['play'] }}</td>
                                    <td class="p-4 text-center font-mono text-green-400">{{ $row['win'] }}</td>
                                    <td class="p-4 text-center font-mono text-red-400">{{ $row['lose'] }}</td>
                                    <td class="p-4 text-center font-mono {{ $row['map_diff'] > 0 ? 'text-cyan-400' : ($row['map_diff'] < 0 ? 'text-red-400' : 'text-gray-500') }}">
                                        {{ $row['map_diff'] > 0 ? '+' : '' }}{{ $row['map_diff'] }}
                                    </td>
                                    <td class="p-4 text-center font-orbitron font-black text-pink-500 text-lg drop-shadow-[0_0_5px_rgba(236,72,153,0.5)]">
                                        {{ $row['points'] }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-10 text-center text-gray-600 font-mono text-[10px] tracking-widest uppercase">
                                        // BELUM ADA PERTANDINGAN YANG SELESAI DI TURNAMEN INI //
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</body>
</html>