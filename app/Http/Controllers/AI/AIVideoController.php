<?php

namespace App\Http\Controllers\AI;

use App\Http\Controllers\Controller;
use App\Models\AiContent;
use Illuminate\Http\Request;

class AIVideoController extends Controller
{
    public function index()
    {
        // Ambil project video terakhir user yang masih draft, atau buat baru
        $project = AiContent::where('user_id', auth()->id())
            ->where('type', 'video')
            ->where('status', 'draft')
            ->latest()
            ->first();

        return view('ai.video.index', compact('project'));
    }

    public function autosave(Request $request)
    {
        $request->validate([
            'project_id' => 'nullable|exists:ai_contents,id',
            'project_data' => 'required|array',
            'prompt' => 'nullable|string',
        ]);

        $user = auth()->user();

        $project = AiContent::updateOrCreate(
            ['id' => $request->project_id, 'user_id' => $user->id],
            [
                'type' => 'video',
                'prompt' => $request->prompt ?? 'Untitled Project',
                'project_data' => $request->project_data,
                'status' => 'draft'
            ]
        );

        return response()->json(['success' => true, 'project_id' => $project->id]);
    }

    public function generate(Request $request)
    {
        $user = auth()->user();
        $creditCost = 20;

        if (!$user->hasCredits($creditCost)) {
            return back()->with('error', "Kredit tidak cukup untuk render video. Butuh {$creditCost} kredit.");
        }

        $request->validate([
            'project_id' => 'required|exists:ai_contents,id',
        ]);

        $project = AiContent::where('id', $request->project_id)->where('user_id', $user->id)->firstOrFail();

        // 1. Kurangi Kredit
        $user->deductCredits($creditCost);

        // 2. Update Status to Rendering
        $project->update(['status' => 'rendering']);

        // 3. Dispatch Job ke Background (FFmpeg processing)
        // ProcessVideoGeneration::dispatch($project->id);

        // Sementara return sukses untuk demo UI
        return back()->with('status', 'Video sedang dalam antrian render. Kredit telah dikurangi.');
    }

    public function aiGenerate(Request $request)
{
    $user = auth()->user();
    $creditCost = 5; // Biaya AI generate

    if (!$user->hasCredits($creditCost)) {
        return response()->json([
            'success' => false,
            'message' => 'Kredit tidak cukup. Butuh 5 kredit untuk AI Generate.'
        ], 400);
    }

    // Kurangi kredit
    $user->deductCredits($creditCost);

    // Di sini Anda bisa menambahkan logic untuk mengirim prompt ke OpenAI dll.
    // $prompt = $request->input('prompt');

    return response()->json([
        'success' => true,
        'message' => 'AI Generation initiated, 5 credits deducted.'
    ]);
}
}
