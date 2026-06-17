<?php

namespace App\Http\Controllers\Planner;

use App\Http\Controllers\Controller;
use App\Models\ScheduledPost;
use App\Models\AiContent;
use App\Helpers\AiHelper;
use Illuminate\Http\Request;

class ContentPlannerController extends Controller
{
    public function index()
    {
        $plans = ScheduledPost::where('user_id', auth()->id())
                    ->orderBy('publish_at', 'asc')
                    ->paginate(15);

        return view('planner.index', compact('plans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'publish_at' => 'required|date',
            'platform' => 'required|string'
        ]);

        ScheduledPost::create([
            'user_id' => auth()->id(),
            'content' => $request->content,
            'publish_at' => $request->publish_at,
            'platform' => $request->platform,
            'status' => 'draft'
        ]);

        return back()->with('success', 'Konten berhasil ditambahkan ke planner.');
    }

    public function generateAI(Request $request)
    {
        $user = auth()->user();
        $creditCost = 5;

        // 1. Cek Kredit (Menggunakan operator perbandingan standar, bukan method protected)
        if ($user->credits < $creditCost) {
            return back()->with('error', "Kredit tidak cukup. Butuh {$creditCost} kredit untuk generate ide.");
        }

        // Validasi input niche
        $request->validate(['niche' => 'required|string']);

        // 2. Proses AI
        $prompt = "Buatkan 5 ide konten menarik untuk bisnis dengan niche: " . $request->niche .
                  ". Format: Judul + Deskripsi singkat. Fokus untuk media sosial.";

        $ideas = AiHelper::generateCaption([
            'tone' => 'profesional',
            'product_name' => 'Ide Konten ' . $request->niche,
            'promo' => $prompt
        ]);

        if ($ideas) {
            // 3. Kurangi Kredit (Menggunakan method public bawaan Eloquent)
            $user->decrement('credits', $creditCost);

            // 4. Simpan hasil ide
            AiContent::create([
                'user_id' => $user->id,
                'type'    => 'content_idea',
                'prompt'  => $request->niche,
                'result'  => $ideas
            ]);

            return back()->with('success', 'Ide konten berhasil dibuat! Kredit dikurangi.');
        }

        return back()->with('error', 'Gagal generate ide. Coba lagi nanti.');
    }
}
