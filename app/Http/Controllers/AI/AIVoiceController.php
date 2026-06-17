<?php

namespace App\Http\Controllers\AI;

use App\Http\Controllers\Controller;
use App\Models\AiContent;
use Illuminate\Http\Request;

class AIVoiceController extends Controller
{
    public function index()
    {
        return view('ai.voice.index');
    }

    public function generate(Request $request)
    {
        $user = auth()->user();
        $creditCost = 3; // Biaya voice over

        // 1. Cek Kredit
        if (!$user->hasCredits($creditCost)) {
            return back()->with('error', "Kredit tidak cukup. Butuh {$creditCost} kredit.");
        }

        $request->validate([
            'text' => 'required|string|max:1000',
            'voice_type' => 'required|in:male,female'
        ]);

        // 2. Proses AI (Placeholder logic)
        // $audioUrl = VoiceService::generate($request->text, $request->voice_type);
        $audioUrl = 'https://example.com/audio-placeholder.mp3';

        if ($audioUrl) {
            // 3. Kurangi Kredit
            $user->deductCredits($creditCost);

            // 4. Simpan Riwayat
            AiContent::create([
                'user_id' => $user->id,
                'type'    => 'voice',
                'prompt'  => $request->text,
                'result'  => $audioUrl
            ]);

            return back()->with('success', 'Voice over berhasil dibuat. Kredit dikurangi.');
        }

        return back()->with('error', 'Gagal membuat voice over.');
    }
}
