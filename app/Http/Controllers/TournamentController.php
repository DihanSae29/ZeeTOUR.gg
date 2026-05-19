<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\Game; // Pastiin ini ada biar bisa ngambil data game
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    /**
     * Nampilin halaman daftar turnamen
     */
    public function index()
    {
        // Ambil semua turnamen, bawa juga data game-nya (relasi), urutin dari yang terbaru
        $tournaments = Tournament::with('game')->latest()->get();
        
        // Lempar datanya ke file view 'tournaments.index'
        return view('tournaments.index', compact('tournaments'));
    }

    /**
     * Nampilin form buat bikin turnamen baru
     */
    public function create()
    {
        // Ambil semua data game buat ditaruh di pilihan dropdown
        $games = Game::all(); 
        
        return view('tournaments.create', compact('games'));
    }

    /**
     * Proses nyimpen data dari form ke database
     */
    public function store(Request $request)
    {
        // 1. Validasi data yang masuk dari form
        $request->validate([
            'nama_turnamen' => 'required|string|max:255',
            'game_id'       => 'required|exists:games,id_game',
            'max_slot'      => 'required|integer',
            'prizepool'     => 'nullable|string|max:255',
            'start_date'    => 'nullable|date',
            'end_date'      => 'nullable|date|after_or_equal:start_date',
        ]);

        // 2. Simpan ke database
        Tournament::create([
            'nama_turnamen' => $request->nama_turnamen,
            'game_id'       => $request->game_id,
            'max_slot'      => $request->max_slot,
            'prizepool'     => $request->prizepool,
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
            'status'        => 'Registration', // Otomatis statusnya pendaftaran
        ]);

        // 3. Balikin ke halaman index (tabel) dengan pesan sukses
        return redirect()->route('tournaments.index')->with('success', 'Turnamen berhasil dibuat!');
    }

    /**
     * Nampilin detail satu turnamen (Opsional)
     */
    // 1. Nampilin Detail Turnamen & Daftar Tim yang daftar
    public function show($id)
    {
        // Narik turnamen beserta tim dan jadwal match-nya
        $tournament = \App\Models\Tournament::with(['teams', 'matches.teamA', 'matches.teamB'])->findOrFail($id);
        
        $registeredTeamIds = $tournament->teams->pluck('id_team')->toArray(); 
        
        $availableTeams = \App\Models\Team::where('game_id', $tournament->game_id)
                                          ->whereNotIn('id_team', $registeredTeamIds)
                                          ->get();

        // Ambil tim yang UDAH APPROVED doang buat dimasukin ke jadwal
        $approvedTeams = $tournament->teams()->wherePivot('status_pendaftaran', 'Approved')->get();

        return view('tournaments.show', compact('tournament', 'availableTeams', 'approvedTeams'));
    }

    public function addParticipantManual(\Illuminate\Http\Request $request, $id)
    {
        // Tambahin pesan custom di parameter kedua validate
        $request->validate([
            'team_id' => 'required'
        ], [
            'team_id.required' => 'Pilih skuadnya dulu dari daftar sebelum di-deploy!'
        ]);

        $tournament = \App\Models\Tournament::findOrFail($id);

        if (!$tournament->teams()->where('team_tournament.team_id', $request->team_id)->exists()) {
            $tournament->teams()->attach($request->team_id, ['status_pendaftaran' => 'Approved']);
        }

        return back()->with('success', 'SYSTEM OVERRIDE: Skuad berhasil diterjunkan paksa oleh Admin!');
    }

    // Fungsi Admin Kick Tim
    public function kickParticipant($tournament_id, $team_id)
    {
        $tournament = \App\Models\Tournament::findOrFail($tournament_id);
        
        // Hapus data tim dari pivot table turnamen ini
        $tournament->teams()->detach($team_id);

        return back()->with('success', 'SYSTEM OVERRIDE: Skuad berhasil di-kick dari arena!');
    }

    // Fungsi Admin Bikin Jadwal Match
    public function storeMatch(\Illuminate\Http\Request $request, $id)
    {
        $request->validate([
            'team_a_id' => 'required|different:team_b_id',
            'team_b_id' => 'required|different:team_a_id',
            'waktu_tanding' => 'required|date',
            'keterangan' => 'required|string|max:100',
        ], [
            'team_a_id.different' => 'Woy, masa timnya disuruh ngelawan diri sendiri?!',
            'team_b_id.different' => 'Woy, masa timnya disuruh ngelawan diri sendiri?!',
            'waktu_tanding.required' => 'Waktu tanding wajib diisi!',
            'keterangan.required' => 'Babaknya diisi dong (Misal: Grand Final, Grup A)'
        ]);

        \App\Models\TournamentMatch::create([
            'tournament_id' => $id,
            'team_a_id' => $request->team_a_id,
            'team_b_id' => $request->team_b_id,
            'waktu_tanding' => $request->waktu_tanding,
            'keterangan' => $request->keterangan,
            'status' => 'Upcoming',
        ]);

        return back()->with('success', 'MATCH SCHEDULED: Jadwal pertempuran berhasil dibuat!');
    }

    // 2. Fungsi eksekusi tombol ACC / Tolak
    public function updateStatus(\Illuminate\Http\Request $request, $tournament_id, $team_id)
    {
        $tournament = \App\Models\Tournament::findOrFail($tournament_id);
        
        // Update kolom 'status_pendaftaran' di tabel pivot
        $tournament->teams()->updateExistingPivot($team_id, [
            'status_pendaftaran' => $request->status
        ]);

        return back()->with('success', 'SYSTEM UPDATE: Status pendaftaran tim berhasil diubah!');
    }

    /**
     * Nampilin form buat edit turnamen
     */
   public function edit(string $id)
    {
        // Cari turnamen yang mau diedit berdasarkan ID
        $tournament = Tournament::findOrFail($id);
        
        // Ambil data game buat dropdown
        $games = Game::all(); 
        
        // Lempar ke halaman edit
        return view('tournaments.edit', compact('tournament', 'games'));
    }

    public function update(Request $request, string $id)
    {
        // 1. Validasi data
        $request->validate([
            'nama_turnamen' => 'required|string|max:255',
            'game_id'       => 'required|exists:games,id_game',
            'max_slot'      => 'required|integer',
            'prizepool'     => 'nullable|string|max:255',
            'start_date'    => 'nullable|date',
            'end_date'      => 'nullable|date|after_or_equal:start_date',
            'status'        => 'required|in:Registration,Ongoing,Completed', // Status wajib divalidasi
        ]);

        // 2. Cari data aslinya
        $tournament = Tournament::findOrFail($id);

        // 3. Timpa sama data baru dari form
        $tournament->update([
            'nama_turnamen' => $request->nama_turnamen,
            'game_id'       => $request->game_id,
            'max_slot'      => $request->max_slot,
            'prizepool'     => $request->prizepool,
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
            'status'        => $request->status, // Update statusnya juga
        ]);

        // 4. Balikin ke index
        return redirect()->route('tournaments.index')->with('success', 'Data Turnamen berhasil di-update, Kapten!');
    }

    /**
     * Proses ngapus data turnamen
     */
   public function destroy(string $id)
    {
        // Cari data turnamen berdasarkan ID
        $tournament = Tournament::findOrFail($id);
        
        // Eksekusi mati (Hapus dari database)
        $tournament->delete();

        // Balikin ke halaman index bawa pesan sukses
        return redirect()->route('tournaments.index')->with('success', 'Turnamen berhasil dihapus dari sistem!');
    }

    // Nampilin form pilih tim
    public function enrollForm($id)
    {
        $tournament = \App\Models\Tournament::findOrFail($id);

        // Ubah 'user_id' jadi 'captain_id'
        $myTeams = \App\Models\Team::where('captain_id', \Illuminate\Support\Facades\Auth::id())
                                   ->where('game_id', $tournament->game_id)
                                   ->get();

        return view('tournaments.enroll', compact('tournament', 'myTeams'));
    }

    // Proses simpan data pendaftaran ke Pivot Table
    public function enrollStore(\Illuminate\Http\Request $request, $id)
    {
        $request->validate([
            'team_id' => 'required'
        ]);

        $tournament = \App\Models\Tournament::findOrFail($id);
        $teamId = $request->team_id;

        // 1. Cek apakah tim ini udah pernah daftar di turnamen ini (Biar ga dobel)
        if ($tournament->teams()->where('team_tournament.team_id', $teamId)->exists()) {
            return back()->with('error', 'SYSTEM REJECTED: Skuad ini sudah terdaftar di turnamen ini!');
        }

        // 2. Cek apakah slot turnamen masih ada
        if ($tournament->teams()->count() >= $tournament->max_slot) {
            return back()->with('error', 'SYSTEM REJECTED: Slot turnamen sudah penuh!');
        }

        // 3. Simpan ke database (Pivot Table) dengan status 'Pending'
        $tournament->teams()->attach($teamId, ['status_pendaftaran' => 'Pending']);

        // Ganti 'katalog.index' dengan nama rute katalog lu
        return redirect('/katalog')->with('success', 'PENDAFTARAN BERHASIL! Menunggu verifikasi Admin.'); 
    }

    // Fungsi Update Skor Modal
    public function updateMatch(\Illuminate\Http\Request $request, $id)
    {
        $request->validate([
            'score_a' => 'required|integer|min:0',
            'score_b' => 'required|integer|min:0',
            'status' => 'required|in:Upcoming,Live,Completed'
        ]);

        $match = \App\Models\TournamentMatch::findOrFail($id);
        
        $match->update([
            'score_a' => $request->score_a,
            'score_b' => $request->score_b,
            'status' => $request->status,
        ]);

        return back()->with('success', 'SYSTEM UPDATE: Skor dan Status Match berhasil diubah!');
    }

    // Fungsi Admin Hapus Match
    public function destroyMatch($id)
    {
        $match = \App\Models\TournamentMatch::findOrFail($id);
        $match->delete();

        return back()->with('success', 'MATCH PURGED: Jadwal pertandingan berhasil dihapus dari arena!');
    }

    // Nampilin Halaman Edit Match
    public function editMatch($id)
    {
        $match = \App\Models\TournamentMatch::with('tournament')->findOrFail($id);
        
        // Ambil tim yang approved di turnamen ini buat pilihan dropdown
        $approvedTeams = $match->tournament->teams()->wherePivot('status_pendaftaran', 'Approved')->get();
        
        return view('tournaments.edit_match', compact('match', 'approvedTeams'));
    }

    // Nyimpen Editan Match
    public function updateMatchInfo(\Illuminate\Http\Request $request, $id)
    {
        $request->validate([
            'team_a_id' => 'required|different:team_b_id',
            'team_b_id' => 'required|different:team_a_id',
            'waktu_tanding' => 'required|date',
            'keterangan' => 'required|string|max:100',
        ], [
            'team_a_id.different' => 'Timnya nggak boleh sama woy!',
            'team_b_id.different' => 'Timnya nggak boleh sama woy!',
        ]);

        $match = \App\Models\TournamentMatch::findOrFail($id);
        
        $match->update([
            'team_a_id' => $request->team_a_id,
            'team_b_id' => $request->team_b_id,
            'waktu_tanding' => $request->waktu_tanding,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('tournaments.show', $match->tournament_id)->with('success', 'MATCH INFO: Jadwal berhasil diperbarui!');
    }

    // Nampilin Jadwal Tempur Khusus Kapten
    // Nampilin Jadwal Tempur Khusus Kapten (BULLETPROOF VERSION)
    public function myMatches()
    {
        // 1. Ambil semua data tim punya kapten yang lagi login
        $teams = \App\Models\Team::where('user_id', auth()->id())->get();
        
        // 2. Ekstrak ID tim-nya 
        $myTeamIds = $teams->map(function($team) {
            return $team->id_team ?? $team->id;
        })->toArray();

        // 3. Tarik jadwal match
        $matches = \App\Models\TournamentMatch::with(['tournament', 'teamA', 'teamB'])
                    ->where(function($query) use ($myTeamIds) {
                        $query->whereIn('team_a_id', $myTeamIds)
                              ->orWhereIn('team_b_id', $myTeamIds);
                    })
                    ->orderBy('waktu_tanding', 'asc')
                    ->get();

        return view('matches.index', compact('matches'));
    }

    // Nampilin Public Arena (Halaman Depan buat Tamu)
    public function publicArena()
    {
    
        $teams = \App\Models\Team::latest()->get(); 
        $totalSkuad = $teams->count();
        
        // Cek nama model player dan game lu, kalo beda ganti ya (misal: \App\Models\User kalo ga pake Player)
        $totalAgents = \App\Models\Player::count(); 
        $totalDivisi = \App\Models\Game::count();   

        $tournaments = \App\Models\Tournament::with(['matches' => function($query) {
            $query->orderBy('waktu_tanding', 'asc');
        }, 'matches.teamA', 'matches.teamB'])->latest()->get();

    
        return view('katalog_publik', compact('teams', 'totalSkuad', 'totalAgents', 'totalDivisi', 'tournaments'));
    }

    // Halaman Detail Turnamen & Leaderboard (Publik)
    public function publicShow($id)
    {
        // Tarik data turnamen beserta match-nya
        $tournament = \App\Models\Tournament::with(['matches.teamA', 'matches.teamB'])->findOrFail($id);

        // Siapin keranjang buat klasemen
        $standings = [];

        // HANYA hitung pertandingan yang udah kelar (Completed)
        $completedMatches = $tournament->matches->where('status', 'Completed');

        foreach ($completedMatches as $match) {
            $scoreA = (int) $match->score_a;
            $scoreB = (int) $match->score_b;

            // Daftarin tim ke keranjang kalau belum ada
            foreach (['team_a_id' => 'teamA', 'team_b_id' => 'teamB'] as $colId => $rel) {
                if ($match->$colId && !isset($standings[$match->$colId])) {
                    $standings[$match->$colId] = [
                        'team' => $match->$rel, 'play' => 0, 'win' => 0, 'lose' => 0,
                        'map_won' => 0, 'map_lost' => 0, 'points' => 0
                    ];
                }
            }

            // Hitung Stat Tim Alpha
            if ($match->team_a_id) {
                $standings[$match->team_a_id]['play']++;
                $standings[$match->team_a_id]['map_won'] += $scoreA;
                $standings[$match->team_a_id]['map_lost'] += $scoreB;
                if ($scoreA > $scoreB) {
                    $standings[$match->team_a_id]['win']++;
                    $standings[$match->team_a_id]['points'] += 3; 
                } else {
                    $standings[$match->team_a_id]['lose']++; 
                }
            }

            // Hitung Stat Tim Omega
            if ($match->team_b_id) {
                $standings[$match->team_b_id]['play']++;
                $standings[$match->team_b_id]['map_won'] += $scoreB;
                $standings[$match->team_b_id]['map_lost'] += $scoreA;
                if ($scoreB > $scoreA) {
                    $standings[$match->team_b_id]['win']++;
                    $standings[$match->team_b_id]['points'] += 3; 
                } else {
                    $standings[$match->team_b_id]['lose']++; 
                }
            }
        }

        // Hitung Selisih Skor (Map Diff) dan ngurutin dari Poin paling tinggi
        $leaderboard = collect($standings)->map(function ($item) {
            $item['map_diff'] = $item['map_won'] - $item['map_lost'];
            return $item;
        })->sortByDesc('map_diff')->sortByDesc('points')->values();

        return view('tournaments.public_show', compact('tournament', 'leaderboard'));
    }

}