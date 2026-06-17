<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    // Menampilkan form biodata
    public function create()
    {
        return view('auth.biodata');
    }

    // Menyimpan data form biodata
    public function store(Request $request)
    {
        $request->validate([
            'store_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'instagram' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'threads' => 'nullable|string|max:255',
            'other_social' => 'nullable|string|max:255',
        ]);

        // Simpan data ke tabel stores
        Store::create([
            'user_id' => auth()->id(),
            'name' => $request->store_name,
            'phone' => $request->phone,
            'instagram' => $request->instagram,
            'tiktok' => $request->tiktok,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'threads' => $request->threads,
            'other_social' => $request->other_social,
        ]);

        // Arahkan ke dashboard setelah simpan
        return redirect()->route('dashboard')->with('status', 'Selamat datang! Data toko berhasil disimpan.');
    }
}
