<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game; // 

class GameController extends Controller
{
    public function index()
    {
        // ngambil semua data dari tabel games
        $games = Game::all(); 
        
        // Kirim data ke file index.blade.php
        return view('games.index', compact('games'));
    }
   public function create()
{
    return view('games.create');
}

public function store(Request $request)
{
    // Validasi input biar data gak ngawi
    $request->validate([
        'nama_game'  => 'required|string|max:255',
        'platform'   => 'required',
        'max_player' => 'required|integer|min:1',
    ]);

    // Simpan ke database
    Game::create([
        'nama_game'  => $request->nama_game,
        'platform'   => $request->platform,
        'max_player' => $request->max_player,
    ]);

    // Balikin ke halaman utama dengan pesan sukses
    return redirect()->route('games.index')->with('success', 'Game berhasil ditambahkan!');
}

// Nampilin form edit dengan data lama
    public function edit($id)
    {
        $game = Game::findOrFail($id);
        return view('games.edit', compact('game'));
    }

    // Proses simpan perubahan data
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_game'  => 'required|string|max:255',
            'platform'   => 'required',
            'max_player' => 'required|integer|min:1',
        ]);

        $game = Game::findOrFail($id);
        $game->update([
            'nama_game'  => $request->nama_game,
            'platform'   => $request->platform,
            'max_player' => $request->max_player,
        ]);

        return redirect()->route('games.index')->with('success', 'Data game berhasil diupdate!');
    }

    // Proses hapus data
    public function destroy($id)
    {
        $game = Game::findOrFail($id);
        $game->delete();

        return redirect()->route('games.index')->with('success', 'Data game berhasil dihapus!');
    }
}