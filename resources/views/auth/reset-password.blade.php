<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESET SECURITY KEY - ZeeTOUR.GG</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body class="bg-[#050508] text-white font-sans antialiased min-h-screen flex items-center justify-center relative overflow-hidden py-10">

    {{-- Ambient Glow --}}
    <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-cyan-600/20 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-1/4 left-1/4 w-96 h-96 bg-purple-600/20 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px] pointer-events-none"></div>

    {{-- MAIN CONTAINER --}}
    <div class="w-full max-w-md relative z-10 p-10 bg-[#0a0a0f]/90 backdrop-blur-sm border border-cyan-500/30 shadow-[0_0_50px_rgba(6,182,212,0.15)] rounded-sm group hover:border-cyan-500/50 transition-colors duration-500">
        
        {{-- Siku Hiasan --}}
        <div class="absolute top-0 left-0 w-8 h-8 border-t-2 border-l-2 border-cyan-500/80"></div>
        <div class="absolute bottom-0 right-0 w-8 h-8 border-b-2 border-r-2 border-purple-500/80"></div>

        {{-- Header Logo --}}
        <div class="text-center mb-10">
            <h1 class="font-orbitron text-4xl font-black tracking-widest drop-shadow-[0_0_10px_rgba(255,255,255,0.2)]">
                ZeeTOUR<span class="text-cyan-500">.GG</span>
            </h1>
            <div class="text-[10px] text-purple-400 font-bold tracking-[0.3em] mt-2 uppercase flex items-center justify-center gap-2">
                <span class="w-1.5 h-1.5 bg-purple-400 rounded-full animate-pulse"></span>
                Key Replacement
            </div>
        </div>

        {{-- FORM RESET PASSWORD --}}
        <form method="POST" action="{{ route('password.store') }}" class="space-y-6" novalidate>
            @csrf

            {{-- Token Rahasia dari Email --}}
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            {{-- Input Email (Readonly/Pre-filled biasanya) --}}
            <div>
                <label class="block text-[10px] text-gray-400 font-bold tracking-widest uppercase mb-2">Target Account (Email)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-cyan-500/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <input type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus class="w-full bg-[#050508] border border-gray-800 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500/50 text-white pl-11 pr-4 py-3 text-sm tracking-wider transition-all outline-none" placeholder="agent@zeetour.gg">
                </div>
                @error('email')
                    <p class="text-red-500 text-[10px] font-mono tracking-widest mt-2 flex items-center gap-1 animate-pulse">
                        <span class="text-red-600">>></span> ERROR: {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Input Password Baru --}}
            <div>
                <label class="block text-[10px] text-gray-400 font-bold tracking-widest uppercase mb-2">New Security Key</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-purple-500/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <input type="password" name="password" required autocomplete="new-password" class="w-full bg-[#050508] border border-gray-800 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 text-white pl-11 pr-4 py-3 text-sm tracking-wider transition-all outline-none" placeholder="Enter new password">
                </div>
                @error('password')
                    <p class="text-red-500 text-[10px] font-mono tracking-widest mt-2 flex items-center gap-1 animate-pulse">
                        <span class="text-red-600">>></span> ERROR: {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Konfirmasi Password Baru --}}
            <div>
                <label class="block text-[10px] text-gray-400 font-bold tracking-widest uppercase mb-2">Verify New Key</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-purple-500/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <input type="password" name="password_confirmation" required autocomplete="new-password" class="w-full bg-[#050508] border border-gray-800 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 text-white pl-11 pr-4 py-3 text-sm tracking-wider transition-all outline-none" placeholder="Re-type new password">
                </div>
            </div>

            {{-- Tombol Eksekusi --}}
            <button type="submit" class="w-full relative group overflow-hidden rounded-sm p-[1px] mt-4">
                <span class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-purple-500 opacity-70 group-hover:opacity-100 transition-opacity duration-300"></span>
                <div class="relative bg-[#0a0a0f] px-8 py-3 transition-all duration-300 group-hover:bg-opacity-0">
                    <span class="relative text-[11px] font-black tracking-[0.2em] uppercase text-white group-hover:drop-shadow-[0_0_8px_rgba(255,255,255,1)]">
                        Execute Key Reset
                    </span>
                </div>
            </button>
        </form>
    </div>

</body>
</html>