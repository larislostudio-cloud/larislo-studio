<?php

namespace App\Http\Controllers\AI;

use App\Http\Controllers\Controller;
use App\Helpers\AiHelper;
use Illuminate\Http\Request;

class AIHashtagController extends Controller
{
    public function generate(Request $request)
    {
        $user = auth()->user();
        $creditCost = 1; // Sama dengan caption

        // 1. Cek Kredit
        if (!$user->hasCredits($creditCost)) {
            return response()->json([
                'success' => false,
                'message' => 'Kredit tidak cukup.'
            ], 402); // 402 Payment Required
        }

        $request->validate(['keyword' => 'required|string']);

        // 2. Proses AI
        $prompt = "Generate 20 hashtags virals dan relevan untuk keyword: " . $request->keyword;
        $hashtags = AiHelper::generateCaption(['tone' => 'standard', 'product_name' => $prompt]);

        if ($hashtags) {
            // 3. Kurangi Kredit
            $user->deductCredits($creditCost);

            return response()->json([
                'success' => true,
                'hashtags' => $hashtags
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal generate hashtag.'
        ], 500);
    }
}
