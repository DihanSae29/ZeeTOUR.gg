@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="mb-12">
        <a href="{{ Auth::user()->role === 'admin' ? route('teams.index') : route('my-teams.index') }}"
           class="flex items-center gap-2 text-[10px] font-bold tracking-widest uppercase text-gray-500 hover:text-pink-500 transition-colors no-underline mb-6">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            BACK TO TEAMS
        </a>

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="text-5xl font-orbitron font-black text-white tracking-tighter uppercase leading-none">
                    {{ $team->nama_tim }}
                </h1>
                <div class="flex items-center gap-4 mt-4">
                    <span class="px-3 py-1 bg-cyan-500/10 border border-cyan-500/50 text-cyan-400 text-[10px] font-bold tracking-[0.3em] uppercase">
                        Active Skuad
                    </span>
                    <span class="text-gray-500 text-xs font-mono italic">
                        Established: {{ $team->created_at->format('Y') }}
                    </span>
                </div>
            </div>
            <div class="bg-gradient-to-br from-[#0f111a] to-[#0b0c16] border-l-4 border-cyan-500 p-6 rounded-r-md min-w-[280px] shadow-[10px_10px_30px_rgba(0,0,0,0.5)]">
                <p class="text-[9px] font-orbitron text-cyan-500/60 tracking-[0.4em] uppercase mb-1">Squad Captain</p>
                <h3 class="text-xl font-bold text-white tracking-wide uppercase">{{ $team->captain->name ?? 'Unknown' }}</h3>
                <p class="text-[10px] text-gray-500 font-mono">{{ $team->captain->email ?? '' }}</p>
            </div>
        </div>
    </div>

    {{-- Header roster + tombol recruit --}}
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-3">
            <span class="text-white font-orbitron text-sm tracking-widest uppercase">Squad Members</span>
            <span class="px-2 py-0.5 bg-white/5 border border-white/10 text-cyan-400 text-[10px] font-bold font-mono rounded">
                {{ $team->players->count() }} / {{ $team->game->max_player ?? '?' }}
            </span>
        </div>
        <button onclick="openAddModal()"
            class="inline-flex items-center gap-2 px-6 py-2 border border-cyan-500/50 text-cyan-400 text-[10px] font-bold tracking-widest uppercase hover:bg-cyan-500/10 transition-all">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Recruit Agent
        </button>
    </div>

    {{-- Grid player --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($team->players as $player)
            <div onclick="document.getElementById('modal-idcard-{{ $player->id_player }}').classList.remove('hidden')"
                 class="group relative bg-[#0b0c10] border border-white/5 p-6 rounded-sm overflow-hidden hover:border-cyan-500/50 transition-all duration-500 cursor-pointer">
                <div class="absolute top-0 right-0 p-2 opacity-5 group-hover:opacity-20 transition-opacity">
                    <i class="fas fa-id-card text-6xl text-white"></i>
                </div>
                <div class="relative z-10">
                    <p class="text-cyan-500 font-mono text-[10px] mb-1">PLAYER_DOSSIER_{{ $player->id_player }}</p>
                    <h4 class="text-2xl font-orbitron font-bold text-white tracking-widest uppercase mb-1 group-hover:text-cyan-400 transition-colors">
                        "{{ $player->nickname }}"
                    </h4>
                    <p class="text-gray-400 text-xs font-medium tracking-wider mb-6">{{ $player->nama_asli }}</p>
                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-white/5">
                        <span class="text-[10px] font-bold tracking-widest text-gray-500 uppercase">Specialist Role</span>
                        <span class="px-2 py-0.5 bg-white/5 text-white text-[10px] font-bold tracking-widest uppercase rounded">
                            {{ $player->role }}
                        </span>
                    </div>
                    <div class="flex gap-2 mt-4 pt-4 border-t border-white/5">
                        <button onclick="event.stopPropagation(); openEditModal(
                                {{ $player->id_player }},
                                '{{ addslashes($player->nickname) }}',
                                '{{ addslashes($player->nama_asli) }}',
                                '{{ $player->role }}',
                                '{{ addslashes($player->bio ?? '') }}',
                                '{{ addslashes($player->instagram ?? '') }}',
                                '{{ $player->photo ?? '' }}'
                            )"
                            class="flex-1 py-1.5 text-[10px] font-bold tracking-widest uppercase border border-cyan-500/30 text-cyan-400 hover:bg-cyan-500/10 transition-all">
                            Edit
                        </button>
                        <button onclick="event.stopPropagation(); deletePlayer({{ $player->id_player }}, '{{ addslashes($player->nickname) }}')"
                            class="flex-1 py-1.5 text-[10px] font-bold tracking-widest uppercase border border-red-500/30 text-red-400 hover:bg-red-500/10 transition-all">
                            Hapus
                        </button>
                    </div>
                </div>

                {{-- ID Card Modal --}}
                <div id="modal-idcard-{{ $player->id_player }}" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/90 backdrop-blur-md cursor-default" onclick="event.stopPropagation()">
                    <div class="absolute inset-0" onclick="document.getElementById('modal-idcard-{{ $player->id_player }}').classList.add('hidden')"></div>
                    <div class="relative w-[500px] bg-[#050508] border-2 border-gray-800 shadow-[0_0_50px_rgba(34,211,238,0.2)] rounded-sm overflow-hidden flex">
                        <div class="w-2/5 bg-gray-950 border-r border-gray-800 relative overflow-hidden">
                            @if($player->photo)
                                <img src="{{ asset('storage/' . $player->photo) }}" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-800 font-black text-4xl min-h-[240px]">NO IMG</div>
                            @endif
                            <div class="absolute inset-0 bg-[linear-gradient(transparent_50%,rgba(0,0,0,0.3)_50%)] bg-[length:100%_4px] pointer-events-none"></div>
                            <div class="absolute bottom-2 left-2 bg-black/60 border border-cyan-500/50 p-1 rounded-sm">
                                <p class="text-[7px] text-cyan-400 font-mono leading-none">TEAM ASSIGNED</p>
                                <p class="text-[10px] text-white font-bold font-orbitron">{{ $team->nama_tim }}</p>
                            </div>
                        </div>
                        <div class="w-3/5 p-6 relative">
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

                <div class="absolute bottom-0 left-0 w-0 h-1 bg-cyan-500 group-hover:w-full transition-all duration-500"></div>
            </div>
        @empty
            <div class="col-span-full py-20 border-2 border-dashed border-white/5 rounded-md flex flex-col items-center justify-center">
                <div class="text-white/10 font-orbitron text-4xl mb-4 font-black tracking-widest italic">ROSTER_EMPTY</div>
                <p class="text-gray-500 text-sm">No registered combatants found in this squad.</p>
            </div>
        @endforelse
    </div>
</div>

{{-- ═══════════════════════════════════════════════════ --}}
{{-- MODAL: ADD PLAYER                                   --}}
{{-- ═══════════════════════════════════════════════════ --}}
<div id="modal-add" class="hidden fixed inset-0 z-[200] flex items-center justify-center bg-black/80 backdrop-blur-md">
    <div class="absolute inset-0" onclick="closeAddModal()"></div>
    <div class="relative w-full max-w-lg mx-4 bg-[#0a0a0f] border border-gray-800 rounded-sm shadow-[0_0_40px_rgba(6,182,212,0.1)] overflow-hidden">
        {{-- Corner accents --}}
        <div class="absolute top-0 left-0 w-5 h-5 border-t-2 border-l-2 border-cyan-500/70"></div>
        <div class="absolute bottom-0 right-0 w-5 h-5 border-b-2 border-r-2 border-pink-500/70"></div>

        {{-- Header --}}
        <div class="flex items-center justify-between px-7 pt-7 pb-5 border-b border-gray-800/60">
            <div>
                <p class="text-[9px] tracking-[0.4em] text-cyan-500/60 font-bold uppercase mb-1">Roster Management</p>
                <h2 class="font-orbitron text-xl font-black text-white tracking-widest uppercase">Recruit New Agent</h2>
            </div>
            <button onclick="closeAddModal()" class="text-gray-600 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="form-add" action="{{ route('players.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="team_id" value="{{ $team->id_team }}">

            <div class="px-7 py-5 flex flex-col gap-5 max-h-[65vh] overflow-y-auto">

                {{-- Nickname --}}
                <div class="flex flex-col gap-1.5">
                    <label class="flex items-center gap-2 text-[10px] font-bold tracking-[0.2em] uppercase text-cyan-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-cyan-500 shadow-[0_0_5px_#06b6d4]"></span>
                        Nickname <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nickname" id="add_nickname" placeholder="e.g. S1MPLE"
                           class="w-full bg-[#050508] border border-gray-800 focus:border-cyan-500 text-white px-4 py-2.5 text-sm tracking-wider outline-none transition-all placeholder-gray-700">
                </div>

                {{-- Nama Lengkap --}}
                <div class="flex flex-col gap-1.5">
                    <label class="flex items-center gap-2 text-[10px] font-bold tracking-[0.2em] uppercase text-cyan-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-cyan-500 shadow-[0_0_5px_#06b6d4]"></span>
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_asli" id="add_nama" placeholder="Nama asli pemain"
                           class="w-full bg-[#050508] border border-gray-800 focus:border-cyan-500 text-white px-4 py-2.5 text-sm tracking-wider outline-none transition-all placeholder-gray-700">
                </div>

                {{-- Specialist Role --}}
                <div class="flex flex-col gap-1.5">
                    <label class="flex items-center gap-2 text-[10px] font-bold tracking-[0.2em] uppercase text-cyan-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-cyan-500 shadow-[0_0_5px_#06b6d4]"></span>
                        Specialist Role <span class="text-red-500">*</span>
                    </label>
                    <select name="role" id="add_role"
                            class="w-full bg-[#050508] border border-gray-800 focus:border-cyan-500 text-white px-4 py-2.5 text-sm tracking-wider uppercase outline-none transition-all appearance-none">
                    </select>
                </div>

                {{-- Photo Upload --}}
                <div class="flex flex-col gap-1.5 border-t border-gray-800/60 pt-4">
                    <label class="flex items-center gap-2 text-[10px] font-bold tracking-[0.2em] uppercase text-pink-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-pink-500 shadow-[0_0_5px_#ec4899]"></span>
                        Agent Photo <span class="text-gray-600 normal-case font-normal tracking-normal">(opsional)</span>
                    </label>
                    <label for="add_photo" class="flex flex-col items-center justify-center gap-2 border border-dashed border-gray-700 hover:border-pink-500/50 transition-colors py-6 cursor-pointer bg-[#050508]" id="add-photo-label">
                        <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span class="text-[11px] text-gray-500 tracking-widest" id="add-photo-text">Upload foto agent</span>
                        <span class="text-[9px] text-gray-700 tracking-widest uppercase">PNG · JPG · WEBP · MAX 2MB</span>
                    </label>
                    <input type="file" id="add_photo" name="photo" accept="image/*" class="hidden"
                           onchange="previewFile(this, 'add-photo-text', 'add-photo-label')">
                </div>

                {{-- Motto / Bio --}}
                <div class="flex flex-col gap-1.5">
                    <label class="flex items-center gap-2 text-[10px] font-bold tracking-[0.2em] uppercase text-cyan-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-cyan-500/60"></span>
                        Motto / Bio
                    </label>
                    <textarea name="bio" id="add_bio" rows="2" placeholder="Agent motto..."
                              class="w-full bg-[#050508] border border-gray-800 focus:border-cyan-500 text-white px-4 py-2.5 text-sm outline-none transition-all resize-none placeholder-gray-700"></textarea>
                </div>

                {{-- Instagram --}}
                <div class="flex flex-col gap-1.5">
                    <label class="flex items-center gap-2 text-[10px] font-bold tracking-[0.2em] uppercase text-cyan-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-cyan-500/60"></span>
                        Instagram
                    </label>
                    <input type="text" name="instagram" id="add_instagram" placeholder="@nickname"
                           class="w-full bg-[#050508] border border-gray-800 focus:border-cyan-500 text-white px-4 py-2.5 text-sm outline-none transition-all placeholder-gray-700">
                </div>

                {{-- Error box --}}
                <div id="add-error-box" class="hidden bg-red-500/5 border border-red-500/30 px-4 py-3 rounded-sm">
                    <ul id="add-error-list" class="list-disc list-inside text-red-400 text-[11px] tracking-wider space-y-1 font-mono"></ul>
                </div>
            </div>

            {{-- Footer Buttons --}}
            <div class="flex justify-end gap-3 px-7 py-5 border-t border-gray-800/60">
                <button type="button" onclick="closeAddModal()"
                        class="px-6 py-2.5 border border-gray-700 text-gray-500 hover:text-white hover:border-gray-500 text-[10px] font-black uppercase tracking-[0.2em] transition-all">
                    ABORT
                </button>
                <button type="button" onclick="submitAddForm()"
                        class="px-8 py-2.5 bg-cyan-500/10 border border-cyan-500 text-cyan-400 hover:bg-cyan-500 hover:text-white text-[10px] font-black uppercase tracking-[0.2em] transition-all shadow-[0_0_15px_rgba(6,182,212,0.2)]">
                    EXECUTE RECRUIT
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════ --}}
{{-- MODAL: EDIT PLAYER                                  --}}
{{-- ═══════════════════════════════════════════════════ --}}
<div id="modal-edit" class="hidden fixed inset-0 z-[200] flex items-center justify-center bg-black/80 backdrop-blur-md">
    <div class="absolute inset-0" onclick="closeEditModal()"></div>
    <div class="relative w-full max-w-lg mx-4 bg-[#0a0a0f] border border-gray-800 rounded-sm shadow-[0_0_40px_rgba(6,182,212,0.1)] overflow-hidden">
        {{-- Corner accents --}}
        <div class="absolute top-0 left-0 w-5 h-5 border-t-2 border-l-2 border-cyan-500/70"></div>
        <div class="absolute bottom-0 right-0 w-5 h-5 border-b-2 border-r-2 border-pink-500/70"></div>

        {{-- Header --}}
        <div class="flex items-center justify-between px-7 pt-7 pb-5 border-b border-gray-800/60">
            <div>
                <p class="text-[9px] tracking-[0.4em] text-cyan-500/60 font-bold uppercase mb-1">Roster Management</p>
                <h2 class="font-orbitron text-xl font-black text-white tracking-widest uppercase">Update Agent</h2>
            </div>
            <button onclick="closeEditModal()" class="text-gray-600 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="form-edit" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="px-7 py-5 flex flex-col gap-5 max-h-[65vh] overflow-y-auto">

                {{-- Nickname --}}
                <div class="flex flex-col gap-1.5">
                    <label class="flex items-center gap-2 text-[10px] font-bold tracking-[0.2em] uppercase text-cyan-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-cyan-500 shadow-[0_0_5px_#06b6d4]"></span>
                        Nickname <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nickname" id="edit_nickname"
                           class="w-full bg-[#050508] border border-gray-800 focus:border-cyan-500 text-white px-4 py-2.5 text-sm tracking-wider outline-none transition-all">
                </div>

                {{-- Nama Lengkap --}}
                <div class="flex flex-col gap-1.5">
                    <label class="flex items-center gap-2 text-[10px] font-bold tracking-[0.2em] uppercase text-cyan-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-cyan-500 shadow-[0_0_5px_#06b6d4]"></span>
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_asli" id="edit_nama_asli"
                           class="w-full bg-[#050508] border border-gray-800 focus:border-cyan-500 text-white px-4 py-2.5 text-sm tracking-wider outline-none transition-all">
                </div>

                {{-- Role --}}
                <div class="flex flex-col gap-1.5">
                    <label class="flex items-center gap-2 text-[10px] font-bold tracking-[0.2em] uppercase text-cyan-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-cyan-500 shadow-[0_0_5px_#06b6d4]"></span>
                        Specialist Role <span class="text-red-500">*</span>
                    </label>
                    <select name="role" id="edit_role"
                            class="w-full bg-[#050508] border border-gray-800 focus:border-cyan-500 text-white px-4 py-2.5 text-sm tracking-wider uppercase outline-none transition-all appearance-none">
                    </select>
                </div>

                {{-- Photo --}}
                <div class="flex flex-col gap-2 border-t border-gray-800/60 pt-4">
                    <label class="flex items-center gap-2 text-[10px] font-bold tracking-[0.2em] uppercase text-red-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                        Update Agent Photo <span class="text-gray-600 normal-case font-normal tracking-normal">(kosongkan jika tidak ganti)</span>
                    </label>

                    {{-- Current photo preview --}}
                    <div id="edit-current-photo" class="hidden items-center gap-4 bg-[#050508] border border-gray-800 px-4 py-3">
                        <img id="edit-photo-preview" src="" alt="" class="w-12 h-12 object-cover rounded-sm border border-gray-700">
                        <div class="flex-1 min-w-0">
                            <p class="text-[9px] text-gray-600 tracking-widest uppercase mb-0.5">Foto Saat Ini</p>
                            <p id="edit-photo-name" class="text-[11px] text-gray-400 font-mono truncate"></p>
                        </div>
                    </div>

                    <label for="edit_photo" class="flex flex-col items-center justify-center gap-2 border border-dashed border-gray-700 hover:border-pink-500/50 transition-colors py-5 cursor-pointer bg-[#050508]" id="edit-photo-label">
                        <svg class="w-7 h-7 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span class="text-[11px] text-gray-500 tracking-widest" id="edit-photo-text">Upload foto baru untuk mengganti</span>
                        <span class="text-[9px] text-gray-700 tracking-widest uppercase">PNG · JPG · WEBP · MAX 2MB</span>
                    </label>
                    <input type="file" id="edit_photo" name="photo" accept="image/*" class="hidden"
                           onchange="previewFile(this, 'edit-photo-text', 'edit-photo-label')">
                </div>

                {{-- Bio --}}
                <div class="flex flex-col gap-1.5">
                    <label class="flex items-center gap-2 text-[10px] font-bold tracking-[0.2em] uppercase text-cyan-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-cyan-500/60"></span>
                        Motto / Bio
                    </label>
                    <textarea name="bio" id="edit_bio" rows="2"
                              class="w-full bg-[#050508] border border-gray-800 focus:border-cyan-500 text-white px-4 py-2.5 text-sm outline-none transition-all resize-none"></textarea>
                </div>

                {{-- Instagram --}}
                <div class="flex flex-col gap-1.5">
                    <label class="flex items-center gap-2 text-[10px] font-bold tracking-[0.2em] uppercase text-cyan-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-cyan-500/60"></span>
                        Instagram
                    </label>
                    <input type="text" name="instagram" id="edit_instagram"
                           class="w-full bg-[#050508] border border-gray-800 focus:border-cyan-500 text-white px-4 py-2.5 text-sm outline-none transition-all">
                </div>

                {{-- Error box --}}
                <div id="edit-error-box" class="hidden bg-red-500/5 border border-red-500/30 px-4 py-3 rounded-sm">
                    <ul id="edit-error-list" class="list-disc list-inside text-red-400 text-[11px] tracking-wider space-y-1 font-mono"></ul>
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex justify-end gap-3 px-7 py-5 border-t border-gray-800/60">
                <button type="button" onclick="closeEditModal()"
                        class="px-6 py-2.5 border border-gray-700 text-gray-500 hover:text-white hover:border-gray-500 text-[10px] font-black uppercase tracking-[0.2em] transition-all">
                    ABORT
                </button>
                <button type="button" onclick="submitEditForm()"
                        class="px-8 py-2.5 bg-cyan-500/10 border border-cyan-500 text-cyan-400 hover:bg-cyan-500 hover:text-white text-[10px] font-black uppercase tracking-[0.2em] transition-all shadow-[0_0_15px_rgba(6,182,212,0.2)]">
                    SAVE
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const gameName = "{{ $team->game->nama_game ?? '' }}";

// ── Role options helper ──
function buildRoleOptions(selectedRole = '') {
    let roles = [];
    const g = gameName.toLowerCase();
    if (g.includes('valorant'))
        roles = ['Duelist','Initiator','Controller','Sentinel','IGL'];
    else if (g.includes('mobile legends') || g.includes('mlbb'))
        roles = ['Jungler','Roamer','Midlaner','Gold Lane','EXP Lane'];
    else
        roles = ['Player','Sub'];

    return roles.map(r =>
        `<option value="${r}" ${r === selectedRole ? 'selected' : ''}>${r}</option>`
    ).join('');
}

// ── File preview helper ──
function previewFile(input, textId, labelId) {
    const file = input.files[0];
    if (file) {
        document.getElementById(textId).textContent = file.name;
        document.getElementById(labelId).classList.add('border-pink-500/50');
    }
}

// ── ADD MODAL ──
function openAddModal() {
    document.getElementById('add_role').innerHTML = buildRoleOptions();
    document.getElementById('add_nickname').value = '';
    document.getElementById('add_nama').value = '';
    document.getElementById('add_bio').value = '';
    document.getElementById('add_instagram').value = '';
    document.getElementById('add-photo-text').textContent = 'Upload foto agent';
    document.getElementById('add-error-box').classList.add('hidden');
    document.getElementById('modal-add').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeAddModal() {
    document.getElementById('modal-add').classList.add('hidden');
    document.body.style.overflow = '';
}
function submitAddForm() {
    const nick = document.getElementById('add_nickname').value.trim();
    const nama = document.getElementById('add_nama').value.trim();
    const errorBox = document.getElementById('add-error-box');
    const errorList = document.getElementById('add-error-list');
    let errors = [];
    if (!nick) errors.push('Nickname wajib diisi.');
    if (!nama) errors.push('Nama Lengkap wajib diisi.');
    if (errors.length) {
        errorList.innerHTML = errors.map(e => `<li>${e}</li>`).join('');
        errorBox.classList.remove('hidden');
        return;
    }
    errorBox.classList.add('hidden');
    document.getElementById('form-add').submit();
}

// ── EDIT MODAL ──
function openEditModal(id, nickname, nama_asli, currentRole, bio, instagram, photoPath) {
    document.getElementById('form-edit').action = `/teams/players/${id}`;
    document.getElementById('edit_nickname').value = nickname;
    document.getElementById('edit_nama_asli').value = nama_asli;
    document.getElementById('edit_role').innerHTML = buildRoleOptions(currentRole);
    document.getElementById('edit_bio').value = bio;
    document.getElementById('edit_instagram').value = instagram;
    document.getElementById('edit-photo-text').textContent = 'Upload foto baru untuk mengganti';
    document.getElementById('edit-error-box').classList.add('hidden');

    const photoContainer = document.getElementById('edit-current-photo');
    if (photoPath) {
        document.getElementById('edit-photo-preview').src = `/storage/${photoPath}`;
        document.getElementById('edit-photo-name').textContent = photoPath.split('/').pop();
        photoContainer.classList.remove('hidden');
        photoContainer.classList.add('flex');
    } else {
        photoContainer.classList.add('hidden');
        photoContainer.classList.remove('flex');
    }

    document.getElementById('modal-edit').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeEditModal() {
    document.getElementById('modal-edit').classList.add('hidden');
    document.body.style.overflow = '';
}
function submitEditForm() {
    const nick = document.getElementById('edit_nickname').value.trim();
    const nama = document.getElementById('edit_nama_asli').value.trim();
    const errorBox = document.getElementById('edit-error-box');
    const errorList = document.getElementById('edit-error-list');
    let errors = [];
    if (!nick) errors.push('Nickname wajib diisi.');
    if (!nama) errors.push('Nama Lengkap wajib diisi.');
    if (errors.length) {
        errorList.innerHTML = errors.map(e => `<li>${e}</li>`).join('');
        errorBox.classList.remove('hidden');
        return;
    }
    errorBox.classList.add('hidden');
    document.getElementById('form-edit').submit();
}

// ── DELETE ──
function deletePlayer(id, nickname) {
    Swal.fire({
        title: 'TERMINATE AGENT?',
        html: `Lu yakin mau ngeluarin <span class="text-red-500 font-black">${nickname}</span> dari skuad?`,
        background: '#0a0a0f',
        color: '#f87171',
        buttonsStyling: false,
        customClass: {
            popup: 'border border-red-500/30 shadow-[0_0_40px_rgba(239,68,68,0.15)] rounded-sm',
            title: 'font-orbitron font-black tracking-[0.2em] uppercase mt-4 text-red-500',
            actions: 'flex gap-4 w-full justify-end px-8 pb-8 mt-4',
            confirmButton: 'px-8 py-2.5 bg-red-500/10 border border-red-500 text-red-400 hover:bg-red-500 hover:text-white text-[10px] font-black uppercase tracking-[0.2em] transition-all',
            cancelButton: 'px-6 py-2.5 border border-gray-700 text-gray-500 hover:text-white hover:border-gray-500 text-[10px] font-black uppercase tracking-[0.2em] transition-all',
        },
        showCancelButton: true,
        confirmButtonText: 'EXECUTE TERMINATION',
        cancelButtonText: 'ABORT'
    }).then((result) => {
        if (result.isConfirmed) {
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = `/teams/players/${id}`;
            form.innerHTML = `
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    });
}

// Close modal on ESC
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        closeAddModal();
        closeEditModal();
    }
});
</script>
@endsection