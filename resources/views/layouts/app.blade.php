<!DOCTYPE html>
<html lang="en" data-theme="dracula">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <title>Master Data Game – ZeEtz Esports</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Rajdhani:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Rajdhani', sans-serif; }
        .font-orbitron { font-family: 'Orbitron', monospace; }
        .glow-purple { text-shadow: 0 0 30px rgba(192,132,252,0.5); }
        .btn-add-clip { clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 0 100%); }
        .platform-clip { clip-path: polygon(6px 0%, 100% 0%, calc(100% - 6px) 100%, 0% 100%); }
        .corner-tl { border-top: 2px solid #a855f7; border-left: 2px solid #a855f7; }
        .corner-br { border-bottom: 2px solid #a855f7; border-right: 2px solid #a855f7; }
        .nav-active { color: #f472b6; text-shadow: 0 0 12px rgba(232,121,249,0.7); }
        .nav-inactive { color: #c4b5fd; }
        .nav-inactive:hover { color: #f472b6; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-[#08090f] min-h-screen text-base-content"
      style="background-image: radial-gradient(ellipse 80% 40% at 50% -10%, rgba(168,85,247,0.18) 0%, transparent 70%),
             repeating-linear-gradient(0deg,transparent,transparent 39px,rgba(168,85,247,0.04) 39px,rgba(168,85,247,0.04) 40px),
             repeating-linear-gradient(90deg,transparent,transparent 39px,rgba(168,85,247,0.04) 39px,rgba(168,85,247,0.04) 40px)">

   {{-- Navbar --}}
    <nav class="sticky top-0 z-50 border-b border-purple-500/20 bg-[#08090f]/85 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-8 w-full h-16 flex items-center justify-between">
            
            {{-- BAGIAN KIRI: Logo ZeETOUR --}}
            <a href="{{ route('katalog') }}" class="font-orbitron text-xl font-black tracking-widest text-white no-underline">
                ZeETOUR<span class="text-purple-400">.</span>GG
            </a>

            {{-- BAGIAN KANAN: Menu & Akun --}}
            <div class="flex gap-8 items-center">
                
                {{-- LOGIKA PEMISAHAN ALAM BAKA (ADMIN) & ALAM DUNIA (KAPTEN) --}}
                @if(Auth::check() && Auth::user()->role == 'admin')
                    
                    {{-- KHUSUS MATA ADMIN --}}
                    <a href="{{ route('games.index') }}" class="text-sm font-bold tracking-widest uppercase transition-colors no-underline {{ request()->routeIs('games.*') ? 'nav-active' : 'nav-inactive' }}">Master Games</a>
                    <a href="{{ route('teams.index') }}" class="text-sm font-bold tracking-widest uppercase transition-colors no-underline {{ request()->routeIs('teams.*') ? 'nav-active' : 'nav-inactive' }}">Master Teams</a>
                    <a href="{{ route('tournaments.index') }}" class="text-sm font-bold tracking-widest uppercase transition-colors no-underline {{ request()->routeIs('tournaments.*') ? 'nav-active' : 'nav-inactive' }}">Master Tournaments</a>
                
                @else
                    
                    {{-- KHUSUS MATA KAPTEN / USER --}}
        <a href="{{ route('katalog') }}" class="text-[11px] font-bold tracking-widest uppercase transition-all duration-300 no-underline {{ request()->routeIs('katalog') ? 'text-pink-500 drop-shadow-[0_0_8px_rgba(236,72,153,0.8)]' : 'text-gray-500 hover:text-white' }}">
            Tournaments
        </a>
        
        {{-- MENU TEAMS --}}
        <a href="{{ route('my-teams.index') }}" class="text-[11px] font-bold tracking-widest uppercase transition-all duration-300 no-underline {{ request()->routeIs('my-teams.index') ? 'text-pink-500 drop-shadow-[0_0_8px_rgba(236,72,153,0.8)]' : 'text-gray-500 hover:text-white' }}">
            Teams
        </a>
        
        <a href="{{ route('kapten.matches') }}" class="text-xs font-bold tracking-widest uppercase transition-colors {{ request()->routeIs('kapten.matches') ? 'text-pink-500 drop-shadow-[0_0_8px_rgba(236,72,153,0.8)]' : 'text-gray-500 hover:text-white' }}">
            MATCHES
        </a>
                
                @endif
                
                {{-- Indikator Login & Logout --}}
                @auth
                    <div class="border-l border-purple-500/30 pl-8 ml-2 flex items-center gap-5">
                        <span class="text-[10px] text-purple-300 font-bold tracking-widest uppercase bg-purple-500/10 px-3 py-1.5 rounded border border-purple-500/30">
                            {{ Auth::user()->name }} 
                            <span class="text-pink-500 ml-1">[{{ strtoupper(Auth::user()->role) }}]</span>
                        </span>
                        
                        <form method="POST" action="{{ route('logout') }}" class="m-0 p-0 flex items-center">
                            @csrf
                            <button type="submit" class="text-[10px] text-red-400 hover:text-red-300 font-bold tracking-widest uppercase cursor-pointer transition-all bg-transparent border-0 p-0">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <div class="border-l border-purple-500/30 pl-8 ml-2">
                        <a href="{{ route('login') }}" class="text-xs text-pink-500 hover:text-white font-bold tracking-widest uppercase transition">Login / Register</a>
                    </div>
                @endauth
            </div>
            
        </div>
    </nav>
    {{-- Flash success --}}
    @if (session('success'))
    <div class="max-w-6xl mx-auto px-8 pt-8">
        <div class="relative bg-green-500/10 border border-green-500/50 rounded-md p-4 flex items-center justify-between shadow-[0_0_20px_rgba(34,197,94,0.15)] overflow-hidden">
            <div class="absolute inset-0 bg-[repeating-linear-gradient(45deg,transparent,transparent_10px,rgba(34,197,94,0.03)_10px,rgba(34,197,94,0.03)_20px)]"></div>
            <div class="flex items-center gap-3 relative z-10">
                <div class="w-8 h-8 flex items-center justify-center bg-green-500/20 border border-green-500/50 rounded text-green-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <span class="font-orbitron text-green-400 font-bold tracking-widest text-sm uppercase">
                    {{ session('success') }}
                </span>
            </div>
            <button type="button" onclick="this.parentElement.parentElement.style.display='none'" class="relative z-10 text-green-400/50 hover:text-green-400 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>
    @endif

    {{-- JEMBATAN BREEZE & ZEETOUR --}}
    <main>
        @isset($header)
            <header class="bg-purple-900/20 shadow border-b border-purple-500/20">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-white">
                    {{ $header }}
                </div>
            </header>
        @endisset
        
        {{ $slot ?? '' }}

        @yield('content')
    </main>

</body>
</html>