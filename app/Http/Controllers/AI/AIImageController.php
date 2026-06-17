<?php

namespace App\Http\Controllers\AI;

use App\Http\Controllers\Controller;
use App\Helpers\AiHelper;
use App\Models\AiContent;
use Illuminate\Http\Request;

class AIImageController extends Controller
{
    public function index()
    {
        return view('ai.image.index');
    }

    public function generate(Request $request)
    {
        $user = auth()->user();
        $creditCost = 5; // Biaya generate gambar lebih mahal

        // 1. Cek Kredit
        if (!$user->hasCredits($creditCost)) {
            return back()->with('error', "Kredit tidak cukup untuk generate gambar. Butuh {$creditCost} kredit.");
        }

        $request->validate([
            'description' => 'required|string|min:5',
        ]);

        // 2. Proses AI
        // Catatan: Ini contoh pemanggilan, sesuaikan dengan implementasi AiHelper Anda
        $imageUrl = AiHelper::generateImage($request->description);

        if ($imageUrl) {
            // 3. Kurangi Kredit
            $user->deductCredits($creditCost);

            // 4. Simpan Riwayat
            $content = AiContent::create([
                'user_id' => $user->id,
                'type'    => 'image',
                'prompt'  => $request->description,
                'result'  => $imageUrl // URL atau path gambar
            ]);

            return view('ai.image.result', compact('content'));
        }

        return back()->with('error', 'Gagal generate gambar.');
    }
}
