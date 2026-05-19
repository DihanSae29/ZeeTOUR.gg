<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PASSWORD RECOVERY - ZeeTOUR.GG</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body class="bg-[#050508] text-white font-sans antialiased min-h-screen flex items-center justify-center relative overflow-hidden">

    {{-- Ambient Glow --}}
    <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-pink-600/20 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-1/4 left-1/4 w-96 h-96 bg-cyan-600/20 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px] pointer-events-none"></div>

    {{-- MAIN CONTAINER --}}
    <div class="w-full max-w-md relative z-10 p-10 bg-[#0a0a0f]/90 backdrop-blur-sm border border-purple-500/30 shadow-[0_0_50px_rgba(168,85,247,0.15)] rounded-sm group hover:border-purple-500/50 transition-colors duration-500">
        
        {{-- Siku Hiasan --}}
        <div class="absolute top-0 left-0 w-8 h-8 border-t-2 border-l-2 border-pink-500/80"></div>
        <div class="absolute bottom-0 right-0 w-8 h-8 border-b-2 border-r-2 border-cyan-500/80"></div>

        {{-- Header Logo --}}
        <div class="text-center mb-8">
            <h1 class="font-orbitron text-4xl font-black tracking-widest drop-shadow-[0_0_10px_rgba(255,255,255,0.2)]">
                ZeeTOUR<span class="text-purple-500">.GG</span>
            </h1>
            <div class="text-[10px] text-pink-400 font-bold tracking-[0.3em] mt-2 uppercase flex items-center justify-center gap-2">
                <span class="w-1.5 h-1.5 bg-pink-400 rounded-full animate-pulse"></span>
                Recovery Protocol
            </div>
        </div>

        <div class="text-[11px] text-gray-400 mb-6 leading-relaxed text-center font-mono tracking-wide">
            Forgot your security key? Enter your registered agent email below. The system will dispatch a recovery link to reset your credentials.
        </div>

        {{-- Session Status (Notif Hijau kalau email berhasil dikirim) --}}
        @if (session('status'))
            <div class="mb-6 bg-green-500/10 border border-green-500/50 p-3 flex items-start gap-3">
                <svg class="w-4 h-4 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div class="text-[11px] text-green-400 tracking-wider font-mono">SYSTEM MSG: {{ session('status') }}</div>
            </div>
        @endif

        {{-- FORM RECOVERY (Udah dipasang novalidate) --}}
        <form method="POST" action="{{ route('password.email') }}" class="space-y-6" novalidate>
            @csrf

            {{-- Input Email --}}
            <div>
                <label class="block text-[10px] text-gray-400 font-bold tracking-widest uppercase mb-2">Registered Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-cyan-500/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full bg-[#050508] border border-gray-800 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500/50 text-white pl-11 pr-4 py-3 text-sm tracking-wider transition-all outline-none" placeholder="agent@zeetour.gg">
                </div>
                {{-- KOTAK ERROR CUSTOM EMAIL --}}
                @error('email')
                    <p class="text-red-500 text-[10px] font-mono tracking-widest mt-2 flex items-center gap-1 animate-pulse">
                        <span class="text-red-600">>></span> SYSTEM ERROR: {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="flex items-center justify-between mt-8">
                <a href="{{ route('login') }}" class="text-[10px] text-gray-500 hover:text-cyan-400 font-bold tracking-widest uppercase transition-colors">
                    < Cancel
                </a>
                <button type="submit" class="relative group overflow-hidden rounded-sm p-[1px]">
                    <span class="absolute inset-0 bg-gradient-to-r from-purple-500 to-pink-500 opacity-70 group-hover:opacity-100 transition-opacity duration-300"></span>
                    <div class="relative bg-[#0a0a0f] px-6 py-2.5 transition-all duration-300 group-hover:bg-opacity-0">
                        <span class="relative text-[10px] font-black tracking-[0.2em] uppercase text-white group-hover:drop-shadow-[0_0_8px_rgba(255,255,255,1)]">
                            Dispatch Link
                        </span>
                    </div>
                </button>
            </div>
        </form>
    </div>

</body>
</html>