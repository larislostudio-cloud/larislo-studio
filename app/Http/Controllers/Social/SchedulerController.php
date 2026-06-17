<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\Models\ScheduledPost;
use Illuminate\Http\Request;

class SchedulerController extends Controller
{
    /**
     * Tampilkan form buat jadwal baru.
     */
    public function create()
    {
        return view('scheduler.create');
    }

    /**
     * Simpan jadwal baru ke database.
     */
    public function schedule(Request $request)
    {
        $user = auth()->user();

        // 1. Validasi Input
        $validated = $request->validate([
            'content' => 'required|string',
            'platform' => 'required|string',
            'publish_at' => 'required|date',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov|max:20480', // Max 20MB
        ]);

        // 2. Logika AI Smart Schedule (Opsional)
        if ($request->has('ai_schedule')) {
            $creditCost = 2;

            if (!$user->hasCredits($creditCost)) {
                return back()->with('error', 'Kredit tidak cukup untuk AI Scheduling.');
            }

            // Kurangi kredit
            $user->deductCredits($creditCost);

            // Logika AI menentukan waktu terbaik (Simulasi)
            // Di sini bisa diganti dengan logika prediksi engagement tinggi
            $bestTime = now()->addHours(rand(1, 5));
            $validated['publish_at'] = $bestTime;
        }

        // 3. Handle Upload Media (Jika ada)
        $mediaPath = null;
        if ($request->hasFile('media')) {
            $mediaPath = $request->file('media')->store('scheduled_media', 'public');
        }

        // 4. Simpan ke Database (Pakai field spesifik untuk keamanan)
        ScheduledPost::create([
            'user_id'     => auth()->id(),
            'content'     => $validated['content'],
            'platform'    => $validated['platform'],
            'publish_at'  => $validated['publish_at'],
            'media_path'  => $mediaPath,
            'status'      => 'scheduled',
        ]);

        return back()->with('success', 'Post berhasil dijadwalkan.');
    }

    /**
     * Tampilkan form edit jadwal.
     */
    public function edit(ScheduledPost $post)
    {
        // SECURITY CHECK: Pastikan user hanya bisa edit post miliknya
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('scheduler.edit', compact('post'));
    }
}
