<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZeeTour.GG - Ultimate Esports Arena</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body class="bg-[#050508] text-gray-300 font-sans antialiased min-h-screen selection:bg-pink-500 selection:text-white">
    
    {{-- Navbar Public --}}
    <nav class="border-b border-gray-800/50 bg-[#00000c]/80 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <h1 class="text-2xl font-black text-white font-orbitron tracking-widest uppercase">
                        Zee<span class="text-pink-500 drop-shadow-[0_0_10px_rgba(236,72,153,0.8)]">Tour</span>.GG
                    </h1>
                </div>
                <div class="flex items-center gap-6">
                    @auth
                        <a href="{{ route('tournaments.index') }}" class="text-xs font-bold tracking-widest uppercase text-pink-500 hover:text-pink-400">ENTER DASHBOARD -></a>
                    @else
                        <a href="{{ route('login') }}" class="text-[10px] font-bold tracking-widest uppercase text-gray-400 hover:text-white transition-colors">LOGIN</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-pink-500/10 border border-pink-500/50 text-pink-400 hover:bg-pink-500 hover:text-white font-black uppercase text-[10px] tracking-widest transition-all">REGISTER</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <div class="relative py-24 overflow-hidden border-b border-gray-800">
        
    </div>
</body>
</html>