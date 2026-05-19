<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Player;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::with('captain', 'game')->get();

        // ═══ STATISTIK RINGKAS ═══
        $totalTeams   = $teams->count();
        $totalPlayers = Player::count();

        $popularGame = Team::with('game')
            ->select('game_id', DB::raw('count(*) as total'))
            ->whereNotNull('game_id')
            ->groupBy('game_id')
            ->orderByDesc('total')
            ->first();
        $popularGameName = $popularGame?->game?->nama_game ?? 'N/A';

        return view('teams.index', compact('teams', 'totalTeams', 'totalPlayers', 'popularGameName'));
    }

    public function create()
    {
        $users = User::all();
        $games = \App\Models\Game::all();
        return view('teams.create', compact('users', 'games'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tim'   => 'required|string|max:255',
            'singkatan' => 'required|string|max:10',
            'captain_id' => 'required|exists:users,id',
            'game_id'    => 'required|exists:games,id_game',
            'logo'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'nama_tim.required'   => 'Nama Skuad wajib diisi!',
            'singkatan.required' => 'Singkatan tim (Tag) wajib diisi!',
            'captain_id.required' => 'Pilih kaptennya dulu dari daftar!',
            'captain_id.exists'   => 'Data kapten tidak valid di sistem.',
            'game_id.required'    => 'Cabang game harus dipilih!',
            'logo.image'          => 'File logo harus berupa gambar!',
            'logo.max'            => 'Ukuran logo maksimal 2MB!',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        Team::create([
            'user_id' => Auth::id(),
            'nama_tim'   => $request->nama_tim,
            'captain_id' => $request->captain_id,
            'game_id'    => $request->game_id,
            'logo_path'  => $logoPath,
        ]);

       // LOGIKA REDIRECT: Kalau Admin balik ke Master, kalau Kapten lempar ke Markasnya
        if (Auth::user()->role === 'admin') {
            return redirect()->route('teams.index')->with('success', 'SKUAD BARU BERHASIL DIDAFTARKAN!');
        }
        
        return redirect()->route('my-teams.index')->with('success', 'SKUAD BARU BERHASIL DIINISIALISASI!');
    }

   public function edit($id)
    {
        $team = Team::where('id_team', $id)->firstOrFail();
        $games = \App\Models\Game::all();
        
        $users = \App\Models\User::all(); 

        // Proteksi: Kalau bukan admin DAN bukan pembuat tim DAN bukan kapten, tendang
        if (\Illuminate\Support\Facades\Auth::user()->role !== 'admin' && $team->user_id !== \Illuminate\Support\Facades\Auth::id() && $team->captain_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403, 'LU BUKAN PEMILIK ATAU KAPTEN TIM INI!');
        }

        // PASTIKAN 'users' DITAMBAHIN KE DALAM COMPACT()
        return view('teams.edit', compact('team', 'games', 'users'));
    }

    public function update(Request $request, $id)
    {

    
        $request->validate([
            'nama_tim'   => 'required|string|max:255',
            'singkatan' => 'required|string|max:10',
            'captain_id' => 'required|exists:users,id',
            'game_id'    => 'required|exists:games,id_game',
            'logo'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'nama_tim.required'   => 'Nama Skuad wajib diisi!',
            'singkatan.required' => 'Singkatan tim (Tag) wajib diisi!',
            'captain_id.required' => 'Pilih kaptennya dulu!',
            'captain_id.exists'   => 'Data kapten tidak valid.',
            'game_id.required' => 'Pilih cabang game-nya dulu!',
            'logo.image'          => 'File logo harus berupa gambar!',
            'logo.max'            => 'Ukuran logo maksimal 2MB!',
        ]);

        $team = Team::where('id_team', $id)->firstOrFail();
        // Proteksi: Kalau bukan admin DAN bukan pembuat tim DAN bukan kapten, tendang
        if (\Illuminate\Support\Facades\Auth::user()->role !== 'admin' && $team->user_id !== \Illuminate\Support\Facades\Auth::id() && $team->captain_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403, 'LU BUKAN PEMILIK ATAU KAPTEN TIM INI!');
        }

        $data = [
            'nama_tim'   => $request->nama_tim,
            'singkatan' => $request->singkatan,
            'captain_id' => $request->captain_id,
            'game_id'    => $request->game_id,
        ];

        if ($request->hasFile('logo')) {
            if ($team->logo_path) {
                Storage::disk('public')->delete($team->logo_path);
            }
            $data['logo_path'] = $request->file('logo')->store('logos', 'public');
        }

        if ($request->has('hapus_logo') && !$request->hasFile('logo')) {
            if ($team->logo_path) {
                Storage::disk('public')->delete($team->logo_path);
            }
            $data['logo_path'] = null;
        }

        $team->update($data);

        // LOGIKA PINTER
        if (\Illuminate\Support\Facades\Auth::user()->role === 'admin') {
            return redirect()->route('teams.index')->with('success', 'DATA SKUAD BERHASIL DI-UPDATE!');
        }
        
        return redirect()->route('my-teams.index')->with('success', 'INFO SKUAD BERHASIL DIUBAH!');
    }

    public function destroy($id)
    {
         $team = Team::where('id_team', $id)->firstOrFail();
        if ($team->logo_path) {
            Storage::disk('public')->delete($team->logo_path);
        }
        $team->delete();

        return redirect()->route('teams.index')->with('success', 'SKUAD BERHASIL DIBUBARKAN!');
    }

    public function show($id)
    {
        $team = Team::with('game', 'players', 'captain')->where('id_team', $id)->firstOrFail(); 
        return view('teams.show', compact('team'));
    }

    public function storePlayer(Request $request)
    {
        $request->validate([
            'team_id'   => 'required|exists:teams,id_team',
            'nickname'  => 'required|string|max:50',
            'nama_asli' => 'required|string|max:255',
            'role'      => 'required|string',
            'photo'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi foto
        ]);

        // Ambil semua inputan (termasuk bio & instagram)
        $data = $request->all();

        // Kalau ada file foto yang diupload, simpen ke folder storage
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('players', 'public');
        }

        Player::create($data);

        return back()->with('success', 'AGENT SUCCESSFULLY RECRUITED!');
    }
    public function updatePlayer(Request $request, $id)
    {
        // Cari pemainnya, dan sekalian ambil data timnya buat dicek
        $player = \App\Models\Player::where('id_player', $id)->firstOrFail();
        $team = $player->team;

        // Proteksi Lapis Baja
        if (\Illuminate\Support\Facades\Auth::user()->role !== 'admin' && $team->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403, 'LU GA PUNYA HAK NGEDIT DATA AGENT INI!');
        }

        // Validasi input
        $request->validate([
            'nickname'  => 'required|string|max:255',
            'nama_asli' => 'required|string|max:255',
            'role'      => 'required|string',
            'photo'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Siapin data yang mau diupdate
        $dataToUpdate = [
            'nickname'  => $request->nickname,
            'nama_asli' => $request->nama_asli,
            'role'      => $request->role,
            'bio'       => $request->bio,
            'instagram' => $request->instagram,
        ];

        // Kalo kaptennya milih foto baru di form edit
        if ($request->hasFile('photo')) {
            // Hapus foto lama kalo ada
            if ($player->photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($player->photo);
            }
            // Simpen foto baru
            $dataToUpdate['photo'] = $request->file('photo')->store('players', 'public');
        }

        // Simpan editan
        $player->update($dataToUpdate);

        return back()->with('success', 'DOSSIER AGENT BERHASIL DIUPDATE!');
    }

public function destroyPlayer($id)
    {
        $player = \App\Models\Player::where('id_player', $id)->firstOrFail();
        $team = $player->team; // Ngambil data tim dari relasi pemain

        // Proteksi: Kalau bukan admin DAN bukan kapten/pembuat tim, tendang
        if (\Illuminate\Support\Facades\Auth::user()->role !== 'admin' && $team->user_id !== \Illuminate\Support\Facades\Auth::id() && $team->captain_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403, 'LU GA PUNYA HAK NGE-KICK AGENT INI!');
        }

        $player->delete();

        return back()->with('success', 'AGENT BERHASIL DI-KICK DARI SKUAD!');
    }

// fungsi khusus buat nampilin Tim milik Kapten yang lagi login
    public function myTeams()
{
    // Cari tim di mana user yang login adalah KAPTEN-nya, ATAU dia yang bikin (user_id)
    $teams = \App\Models\Team::where('captain_id', \Illuminate\Support\Facades\Auth::id())
                             ->orWhere('user_id', \Illuminate\Support\Facades\Auth::id())
                             ->get();

    return view('teams.my_teams', compact('teams'));
}

    public function katalogPublik()
    {
        // ngambil semua data tim beserta nama gamenya buat dipamerin
        $teams = \App\Models\Team::with('game')->get(); 

        return view('katalog_publik', compact('teams'));
    }

    public function rosterPublik($id)
    {
        $team = \App\Models\Team::with(['players', 'game'])->findOrFail($id); 

        return view('katalog_roster', compact('team'));
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

}
