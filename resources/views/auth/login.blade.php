<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SYSTEM LOGIN - ZeeTOUR.GG</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Import font khas lu (Orbitron buat judul) --}}
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body class="bg-[#050508] text-white font-sans antialiased min-h-screen flex items-center justify-center relative overflow-hidden">

    {{-- Tombol Kembali ke Landing Page --}}
    <a href="{{ url('/') }}" class="absolute top-8 left-8 z-50 flex items-center gap-3 text-[10px] text-gray-500 hover:text-cyan-400 font-bold tracking-[0.2em] uppercase transition-all group">
        <div class="w-8 h-8 rounded bg-[#0a0a0f] border border-gray-800 group-hover:border-cyan-500 group-hover:shadow-[0_0_15px_rgba(6,182,212,0.3)] flex items-center justify-center transition-all">
            <svg class="w-4 h-4 text-gray-500 group-hover:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </div>
        Return
    </a>

    {{-- Efek Cahaya Background (Ambient Glow) --}}
    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-pink-600/20 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-cyan-600/20 rounded-full blur-[120px] pointer-events-none"></div>

    {{-- Grid Background Pattern (Opsional, bikin kesan digital) --}}
    <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px] pointer-events-none"></div>

    {{-- KOTAK LOGIN UTAMA --}}
    <div class="w-full max-w-md relative z-10 p-10 bg-[#0a0a0f]/90 backdrop-blur-sm border border-purple-500/30 shadow-[0_0_50px_rgba(168,85,247,0.15)] rounded-sm group hover:border-purple-500/50 transition-colors duration-500">
        
        {{-- Siku Hiasan ala UI Game --}}
        <div class="absolute top-0 left-0 w-8 h-8 border-t-2 border-l-2 border-cyan-500/80"></div>
        <div class="absolute bottom-0 right-0 w-8 h-8 border-b-2 border-r-2 border-pink-500/80"></div>

        {{-- Header Logo --}}
        <div class="text-center mb-10">
            <h1 class="font-orbitron text-4xl font-black tracking-widest drop-shadow-[0_0_10px_rgba(255,255,255,0.2)]">
                ZeeTOUR<span class="text-pink-500">.GG</span>
            </h1>
            <div class="text-[10px] text-cyan-400 font-bold tracking-[0.3em] mt-2 uppercase flex items-center justify-center gap-2">
                <span class="w-1.5 h-1.5 bg-cyan-400 rounded-full animate-pulse"></span>
                System Authorization
            </div>
        </div>

        {{-- Alert Error kalau Password Salah --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-500/10 border border-red-500/50 p-3 flex items-start gap-3">
                <svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <div class="text-[11px] text-red-400 tracking-wider font-mono">Access Denied. Cek lagi email/password lu.</div>
            </div>
        @endif

        {{-- FORM LOGIN --}}
        {{-- Tambahin novalidate di sini --}}
        <form method="POST" action="{{ route('login') }}" class="space-y-6" novalidate>
            @csrf

            {{-- Input Email --}}
            <div>
                <label class="block text-[10px] text-gray-400 font-bold tracking-widest uppercase mb-2">User Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-cyan-500/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full bg-[#050508] border border-gray-800 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500/50 text-white pl-11 pr-4 py-3 text-sm tracking-wider transition-all outline-none" placeholder="agent@zeetour.gg">
                </div>
                @error('email')
                    <p class="text-red-500 text-[10px] font-mono tracking-widest mt-2 flex items-center gap-1 animate-pulse">
                        <span class="text-red-600">>></span> SYSTEM ERROR: {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Input Password --}}
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-[10px] text-gray-400 font-bold tracking-widest uppercase">Security Key</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-[10px] text-cyan-500 hover:text-pink-500 font-bold tracking-wider transition-colors">Forgot Key?</a>
                    @endif
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-pink-500/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <input type="password" name="password" required autocomplete="current-password" class="w-full bg-[#050508] border border-gray-800 focus:border-pink-500 focus:ring-1 focus:ring-pink-500/50 text-white pl-11 pr-4 py-3 text-sm tracking-wider transition-all outline-none" placeholder="••••••••">
                </div>
                @error('password')
                    <p class="text-red-500 text-[10px] font-mono tracking-widest mt-2 flex items-center gap-1 animate-pulse">
                        <span class="text-red-600">>></span> SYSTEM ERROR: {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Remember Me --}}
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 bg-[#050508] border-gray-800 rounded text-cyan-500 focus:ring-cyan-500 focus:ring-offset-[#0a0a0f]">
                <label for="remember_me" class="ml-2 block text-[10px] text-gray-500 tracking-widest uppercase cursor-pointer hover:text-gray-300">
                    Keep me connected
                </label>
            </div>

            {{-- Tombol Login --}}
            <button type="submit" class="w-full relative group overflow-hidden rounded-sm p-[1px]">
                <span class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-pink-500 opacity-70 group-hover:opacity-100 transition-opacity duration-300"></span>
                <div class="relative bg-[#0a0a0f] px-8 py-3 transition-all duration-300 group-hover:bg-opacity-0">
                    <span class="relative text-[11px] font-black tracking-[0.2em] uppercase text-white group-hover:drop-shadow-[0_0_8px_rgba(255,255,255,1)]">
                        Initialize Login
                    </span>
                </div>
            </button>
        </form>

        {{-- Link ke Register --}}
        <div class="mt-8 text-center border-t border-gray-800/50 pt-6">
            <p class="text-[10px] text-gray-500 tracking-widest uppercase">
                Belum punya credentials? 
                <a href="{{ route('register') }}" class="text-pink-500 hover:text-cyan-400 font-black ml-1 transition-colors">Register Agent</a>
            </p>
        </div>

    </div>

</body>
</html>