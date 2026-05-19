@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">
    
    <div class="mb-10">
        <a href="{{ route('tournaments.index') }}" class="text-pink-500 hover:text-white text-xs font-bold tracking-widest uppercase mb-4 inline-block transition">< Kembali ke Daftar</a>
        <h1 class="text-4xl font-black uppercase tracking-wider text-white drop-shadow-[0_0_10px_rgba(255,255,255,0.2)]">Tambah Turnamen</h1>
        <p class="text-gray-500 mt-2 text-sm">Buat data turnamen baru untuk diselenggarakan.</p>
    </div>

    <div class="relative bg-[#0d0d18] border border-gray-800 rounded-lg p-8">
        <div class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-pink-500 to-purple-500"></div>

        @if ($errors->any())
        <div class="mb-8 bg-red-900/10 border border-red-500/30 rounded p-5 shadow-[0_0_15px_rgba(239,68,68,0.1)]">
            <div class="flex items-center gap-3 mb-3">
                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <span class="text-red-500 text-xs font-black tracking-[0.2em] uppercase">System Error Detected</span>
            </div>
            <ul class="list-disc list-inside text-red-400 text-xs space-y-1 ml-1 opacity-80">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    
        <form action="{{ route('tournaments.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-2 gap-6">
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-pink-500 text-[10px] font-black uppercase tracking-widest mb-2">Nama Turnamen *</label>
                    <input type="text" name="nama_turnamen" value="{{ old('nama_turnamen') }}" class="w-full bg-black/50 border {{ $errors->has('nama_turnamen') ? 'border-red-500 focus:ring-red-500' : 'border-gray-800 focus:border-pink-500 focus:ring-pink-500' }} text-white text-sm rounded px-4 py-3 focus:outline-none focus:ring-1 transition placeholder-gray-700" placeholder="Contoh: ZeETOUR Valorant Cup 2026">
                    @error('nama_turnamen')
                        <span class="text-red-500 text-[10px] font-bold mt-1 block tracking-wider">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label class="block text-pink-500 text-[10px] font-black uppercase tracking-widest mb-2">Pilih Game *</label>
                    <select name="game_id" class="w-full bg-black/50 border {{ $errors->has('game_id') ? 'border-red-500 focus:ring-red-500' : 'border-gray-800 focus:border-pink-500 focus:ring-pink-500' }} text-white text-sm rounded px-4 py-3 focus:outline-none focus:ring-1 transition appearance-none">
                        <option value="" disabled {{ old('game_id') ? '' : 'selected' }} class="text-gray-500">-- Pilih Game --</option>
                        @foreach($games as $game)
                            <option value="{{ $game->id_game }}" {{ old('game_id') == $game->id_game ? 'selected' : '' }} class="bg-gray-900">{{ $game->nama_game }}</option>
                        @endforeach
                    </select>
                    @error('game_id')
                        <span class="text-red-500 text-[10px] font-bold mt-1 block tracking-wider">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-pink-500 text-[10px] font-black uppercase tracking-widest mb-2">Maksimal Tim (Slot) *</label>
                    <input type="number" name="max_slot" value="{{ old('max_slot') }}" class="w-full bg-black/50 border {{ $errors->has('max_slot') ? 'border-red-500 focus:ring-red-500' : 'border-gray-800 focus:border-pink-500 focus:ring-pink-500' }} text-white text-sm rounded px-4 py-3 focus:outline-none focus:ring-1 transition placeholder-gray-700" placeholder="Contoh: 16">
                    @error('max_slot')
                        <span class="text-red-500 text-[10px] font-bold mt-1 block tracking-wider">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-pink-500 text-[10px] font-black uppercase tracking-widest mb-2">Prizepool</label>
                    <input type="text" name="prizepool" value="{{ old('prizepool') }}" class="w-full bg-black/50 border border-gray-800 text-white text-sm rounded px-4 py-3 focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition placeholder-gray-700" placeholder="Contoh: Rp 10.000.000">
                    @error('prizepool')
                        <span class="text-red-500 text-[10px] font-bold mt-1 block tracking-wider">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-pink-500 text-[10px] font-black uppercase tracking-widest mb-2">Tanggal Mulai</label>
                    <input type="date" name="start_date" value="{{ old('start_date') }}" class="w-full bg-black/50 border {{ $errors->has('start_date') ? 'border-red-500 focus:ring-red-500' : 'border-gray-800 focus:border-pink-500 focus:ring-pink-500' }} text-white text-sm rounded px-4 py-3 focus:outline-none focus:ring-1 transition text-gray-400">
                    @error('start_date')
                        <span class="text-red-500 text-[10px] font-bold mt-1 block tracking-wider">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-pink-500 text-[10px] font-black uppercase tracking-widest mb-2">Tanggal Selesai</label>
                    <input type="date" name="end_date" value="{{ old('end_date') }}" class="w-full bg-black/50 border {{ $errors->has('end_date') ? 'border-red-500 focus:ring-red-500' : 'border-gray-800 focus:border-pink-500 focus:ring-pink-500' }} text-white text-sm rounded px-4 py-3 focus:outline-none focus:ring-1 transition text-gray-400">
                    @error('end_date')
                        <span class="text-red-500 text-[10px] font-bold mt-1 block tracking-wider">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-gradient-to-r from-pink-500 to-purple-600 px-8 py-3 rounded text-xs font-black tracking-widest shadow-[0_0_15px_rgba(236,72,153,0.4)] hover:shadow-[0_0_25px_rgba(236,72,153,0.7)] transition-all uppercase text-white">
                    Simpan Turnamen
                </button>
            </div>
        </form>
    </div>
</div>
@endsection