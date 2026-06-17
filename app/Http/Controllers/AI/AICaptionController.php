<?php

namespace App\Http\Controllers\AI;

use App\Http\Controllers\Controller;
use App\Helpers\AiHelper;
use App\Models\AiContent;
use Illuminate\Http\Request;

class AICaptionController extends Controller
{
    public function index()
    {
        return view('ai.caption.index');
    }

    public function generate(Request $request)
    {
        $user = auth()->user();
        $creditCost = 1; // Biaya generate caption

        // 1. Cek Kredit
        if (!$user->hasCredits($creditCost)) {
            return back()->with('error', "Kredit Anda tidak cukup. Butuh {$creditCost} kredit.");
        }

        $request->validate([
            'business_type' => 'required|string',
            'product_name'  => 'required|string',
            'promo'         => 'nullable|string',
            'tone'          => 'required|string',
        ]);

        // 2. Proses AI
        $result = AiHelper::generateCaption($request->all());

        if ($result) {
            // 3. Kurangi Kredit (Hanya jika berhasil)
            $user->deductCredits($creditCost);

            // 4. Simpan Riwayat
            $content = AiContent::create([
                'user_id' => $user->id,
                'type'    => 'caption',
                'prompt'  => json_encode($request->all()),
                'result'  => $result
            ]);

            return view('ai.caption.result', compact('result', 'content'));
        }

        return back()->with('error', 'Gagal generate caption. Silakan coba lagi.');
    }
}
