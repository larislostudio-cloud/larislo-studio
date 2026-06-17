<?php

namespace App\Http\Controllers\Planner;

use App\Http\Controllers\Controller;
use App\Models\ScheduledPost;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function events(Request $request)
    {
        $start = $request->start; // Dari FullCalendar JS
        $end = $request->end;

        $posts = ScheduledPost::where('user_id', auth()->id())
                    ->whereBetween('publish_at', [$start, $end])
                    ->get();

        $events = $posts->map(function($post) {
            return [
                'id' => $post->id,
                'title' => \Str::limit($post->content, 20),
                'start' => $post->publish_at->toIso8601String(),
                'color' => $post->status === 'published' ? '#10B981' : '#6366F1',
            ];
        });

        return response()->json($events);
    }
}
