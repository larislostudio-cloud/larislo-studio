<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VendorController extends Controller
{
    /**
     * Dashboard Vendor (Statistik penjualan).
     */
    public function dashboard()
    {
        $user = auth()->user();

        $totalSales = $user->sales()->count(); // Relasi sales
        $totalRevenue = $user->sales()->sum('vendor_earning'); // Penghasilan bersih
        $myTemplates = $user->templates()->count();

        return view('marketplace.vendor.dashboard', compact('totalSales', 'totalRevenue', 'myTemplates'));
    }

    /**
     * Menampilkan daftar template milik user yang login.
     */
    public function myProducts()
    {
        $templates = Template::where('user_id', auth()->id())
                        ->latest()
                        ->paginate(10);

        return view('marketplace.vendor.my-products', compact('templates'));
    }

    /**
     * Form upload template baru.
     */
    public function create()
    {
        return view('marketplace.vendor.create');
    }

    /**
     * Simpan template baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'type'        => 'required|in:caption,image,video,prompt',
            'price'       => 'required|integer|min:0',
            'description' => 'required|string',
            'file'        => 'required|file', // File template (json/txt/image)
            'thumbnail'   => 'required|image', // Gambar preview
        ]);

        // Simpan file template (private storage)
        $filePath = $request->file('file')->store('templates/files', 'local');

        // Simpan thumbnail (public storage)
        $thumbPath = $request->file('thumbnail')->store('templates/thumbs', 'public');

        Template::create([
            'user_id'     => auth()->id(),
            'title'       => $request->title,
            'type'        => $request->type,
            'price'       => $request->price,
            'description' => $request->description,
            'file_path'   => $filePath,
            'thumbnail'   => $thumbPath,
            'status'      => 'pending', // Perlu moderasi admin
        ]);

        return redirect()->route('vendor.products')->with('success', 'Template berhasil diupload dan sedang direview.');
    }
}
