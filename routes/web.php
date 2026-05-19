<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Import semua Controller Lu
use App\Http\Controllers\GameController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TournamentController;
use App\Models\Tournament;

// Rute Public Arena (Landing Page)
Route::get('/', [App\Http\Controllers\TournamentController::class, 'publicArena'])->name('landing');
Route::get('/squad/{id}', [App\Http\Controllers\TeamController::class, 'rosterPublik'])->name('katalog.roster');
// Rute Detail Turnamen Publik (Nampilin Leaderboard)
Route::get('/arena/{id}', [App\Http\Controllers\TournamentController::class, 'publicShow'])->name('arena.show');

Route::get('/dashboard', function () {
    // Cek apakah user yang login punya role 'admin'
    if (Auth::user()->role === 'admin') {
        // Admin langsung mendarat di Master Tournaments
        return redirect()->route('games.index'); 
    }

    // Kalau bukan admin (berarti kapten), lempar ke Katalog
    return redirect()->route('katalog');
})->middleware(['auth', 'verified'])->name('dashboard');

// ==========================================
// 1. ROUTE BAWAAN BREEZE (Buat Login/Register)
// ==========================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==========================================
// 2. ROUTE KATALOG TURNAMEN (Buat Kapten)
// ==========================================
Route::get('/katalog', function () {
    $tournaments = Tournament::where('status', 'Registration')->with('game')->get();
    return view('tournaments.katalog', compact('tournaments'));
})->middleware('auth')->name('katalog');

Route::get('/my-teams', [App\Http\Controllers\TeamController::class, 'myTeams'])
    ->middleware('auth')
    ->name('my-teams.index');

Route::get('/teams/create', [App\Http\Controllers\TeamController::class, 'create'])
    ->middleware('auth')
    ->name('teams.create');

Route::post('/teams', [App\Http\Controllers\TeamController::class, 'store'])
    ->middleware('auth')
    ->name('teams.store');

    // Rute untuk nampilin detail tim (Roster)
Route::get('/teams/{id}/roster', [App\Http\Controllers\TeamController::class, 'show'])
    ->middleware('auth')
    ->name('teams.show');

// Rute untuk nambah, ngedit, dan ngapus anggota (Agent)
Route::post('/teams/players', [App\Http\Controllers\TeamController::class, 'storePlayer'])
    ->middleware('auth')
    ->name('players.store');

Route::put('/teams/players/{id}', [App\Http\Controllers\TeamController::class, 'updatePlayer'])
    ->middleware('auth')
    ->name('players.update');

Route::delete('/teams/players/{id}', [App\Http\Controllers\TeamController::class, 'destroyPlayer'])
    ->middleware('auth')
    ->name('players.destroy');

    // Rute Edit & Update (Bebas buat Kapten & Admin)
Route::get('/teams/{id}/edit', [App\Http\Controllers\TeamController::class, 'edit'])
    ->middleware('auth')
    ->name('teams.edit');

Route::put('/teams/{id}', [App\Http\Controllers\TeamController::class, 'update'])
    ->middleware('auth')
    ->name('teams.update');

Route::get('/tournaments/{id}/enroll', [App\Http\Controllers\TournamentController::class, 'enrollForm'])->name('tournaments.enroll');
Route::post('/tournaments/{id}/enroll', [App\Http\Controllers\TournamentController::class, 'enrollStore'])->name('tournaments.enroll.store');

// Rute Halaman Matches Khusus Kapten
Route::get('/my-matches', [App\Http\Controllers\TournamentController::class, 'myMatches'])->name('kapten.matches');




// ==========================================
// 3. ROUTE LAMA ZEETOUR (ADMIN PANEL)
// Semua rute di bawah ini dijaga oleh satpam 'admin'
// ==========================================
Route::middleware(['auth', 'admin'])->group(function () {

    // --- ROUTE UNTUK GAMES ---
    Route::get('/games/create', [GameController::class, 'create'])->name('games.create');
    Route::post('/games', [GameController::class, 'store'])->name('games.store');
    Route::get('/games', [GameController::class, 'index'])->name('games.index');
    Route::get('/games/{id}/edit', [GameController::class, 'edit'])->name('games.edit');
    Route::put('/games/{id}', [GameController::class, 'update'])->name('games.update');
    Route::delete('/games/{id}', [GameController::class, 'destroy'])->name('games.destroy');

    // --- ROUTE UNTUK TEAMS ---
    Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');

    Route::delete('/teams/{id}', [TeamController::class, 'destroy'])->name('teams.destroy');
    Route::get('/teams/{id}', [TeamController::class, 'show'])->name('teams.show');

    // --- ROUTE UNTUK PLAYERS ---
    Route::post('/players', [TeamController::class, 'storePlayer'])->name('players.store');
    Route::put('/players/{id}', [TeamController::class, 'updatePlayer'])->name('players.update');
    Route::delete('/players/{id}', [TeamController::class, 'destroyPlayer'])->name('players.destroy');

    // --- ROUTE UNTUK TOURNAMENTS (ADMIN PANEL) ---
    // Pakai Route::resource biar otomatis ngebikin ke-7 rutenya
    Route::resource('tournaments', TournamentController::class);

    // Rute buat Admin ACC atau Tolak pendaftaran tim
    Route::patch('/tournaments/{tournament}/participants/{team}', [App\Http\Controllers\TournamentController::class, 'updateStatus'])->name('tournaments.participants.update');
    // Rute Admin Bypass Add & Kick Tim
    Route::post('/tournaments/{tournament}/participants/add', [App\Http\Controllers\TournamentController::class, 'addParticipantManual'])->name('tournaments.participants.add');
    Route::delete('/tournaments/{tournament}/participants/{team}/kick', [App\Http\Controllers\TournamentController::class, 'kickParticipant'])->name('tournaments.participants.kick');

    // Rute Bikin Jadwal Match
    Route::post('/tournaments/{tournament}/matches/add', [App\Http\Controllers\TournamentController::class, 'storeMatch'])->name('tournaments.matches.store');
    // Rute Update Skor & Status Match
    Route::put('/tournaments/matches/{match}/update', [App\Http\Controllers\TournamentController::class, 'updateMatch'])->name('tournaments.matches.update');

        // Rute Hapus Match
    Route::delete('/tournaments/matches/{match}/delete', [App\Http\Controllers\TournamentController::class, 'destroyMatch'])->name('tournaments.matches.destroy');
    // Rute Edit Jadwal Match (Info, Tim, Waktu)
    Route::get('/tournaments/matches/{match}/edit', [App\Http\Controllers\TournamentController::class, 'editMatch'])->name('tournaments.matches.edit');
    Route::put('/tournaments/matches/{match}/update-info', [App\Http\Controllers\TournamentController::class, 'updateMatchInfo'])->name('tournaments.matches.update_info');

}); // <-- INI PENUTUP SATPAMNYA

require __DIR__.'/auth.php';