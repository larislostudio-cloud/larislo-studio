<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\Controller;
use App\Models\Template; // Asumsi ada model Template
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    /**
     * Menampilkan daftar semua template yang dijual.
     */
    public function index(Request $request)
    {
        $query = Template::where('status', 'approved')->latest();

        // Filter berdasarkan kategori (Caption, Image, Video, Prompt)
        if ($request->has('category')) {
            $query->where('type', $request->category);
        }

        // Search
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $templates = $query->paginate(12);

        return view('marketplace.index', compact('templates'));
    }

    /**
     * Menampilkan detail produk template.
     */
    public function show($id)
    {
        $template = Template::with('user', 'reviews')->findOrFail($id);

        // Increment view count
        $template->increment('views');

        return view('marketplace.show', compact('template'));
    }
}
