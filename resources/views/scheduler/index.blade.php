@extends('layouts.app')

@section('title', 'Scheduler')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-slate-900 text-gray-900 dark:text-white py-6 px-4 md:px-8 transition-colors duration-300" x-data="schedulerUI()">

    <!-- Header -->
    <div class="max-w-7xl mx-auto mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight bg-gradient-to-r from-sky-600 to-blue-700 dark:from-sky-400 dark:to-blue-500 bg-clip-text text-transparent">
                Scheduled Posts
            </h1>
            <p class="text-gray-500 dark:text-slate-400 text-sm mt-1">Kelola dan jadwalkan konten ke berbagai platform</p>
        </div>
        <a href="{{ route('social.scheduler.create') }}" class="px-5 py-2.5 bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-400 hover:to-blue-500 text-white rounded-xl text-sm font-bold transition shadow-md shadow-sky-500/20 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Create Post
        </a>
    </div>

    <div class="max-w-7xl mx-auto space-y-6">

        <!-- Filters & View Controls -->
        <div class="bg-white dark:bg-slate-800 p-3 rounded-xl border border-gray-100 dark:border-slate-700 shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex gap-2 overflow-x-auto pb-1 sm:pb-0 w-full sm:w-auto">
                <button @click="filterStatus = 'all'" :class="filterStatus === 'all' ? 'bg-sky-50 dark:bg-sky-500/20 text-sky-600 dark:text-sky-300 border-sky-200 dark:border-sky-500/30' : 'bg-gray-50 dark:bg-slate-700 text-gray-500 dark:text-slate-400 border-transparent'" class="px-3 py-1 border rounded-full text-[11px] font-bold transition whitespace-nowrap">All</button>
                <button @click="filterStatus = 'scheduled'" :class="filterStatus === 'scheduled' ? 'bg-sky-50 dark:bg-sky-500/20 text-sky-600 dark:text-sky-300 border-sky-200 dark:border-sky-500/30' : 'bg-gray-50 dark:bg-slate-700 text-gray-500 dark:text-slate-400 border-transparent'" class="px-3 py-1 border rounded-full text-[11px] font-bold transition whitespace-nowrap">Scheduled</button>
                <button @click="filterStatus = 'published'" :class="filterStatus === 'published' ? 'bg-green-50 dark:bg-green-500/20 text-green-600 dark:text-green-300 border-green-200 dark:border-green-500/30' : 'bg-gray-50 dark:bg-slate-700 text-gray-500 dark:text-slate-400 border-transparent'" class="px-3 py-1 border rounded-full text-[11px] font-bold transition whitespace-nowrap">Published</button>
                <button @click="filterStatus = 'failed'" :class="filterStatus === 'failed' ? 'bg-red-50 dark:bg-red-500/20 text-red-600 dark:text-red-300 border-red-200 dark:border-red-500/30' : 'bg-gray-50 dark:bg-slate-700 text-gray-500 dark:text-slate-400 border-transparent'" class="px-3 py-1 border rounded-full text-[11px] font-bold transition whitespace-nowrap">Failed</button>
            </div>
            <div class="flex bg-gray-100 dark:bg-slate-900 rounded-lg p-1">
                <button @click="activeView = 'list'" :class="activeView === 'list' ? 'bg-white dark:bg-slate-700 shadow-sm text-gray-900 dark:text-white' : 'text-gray-500 dark:text-slate-400'" class="px-3 py-1.5 rounded-md text-xs font-semibold transition flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg> List
                </button>
                <button @click="activeView = 'grid'" :class="activeView === 'grid' ? 'bg-white dark:bg-slate-700 shadow-sm text-gray-900 dark:text-white' : 'text-gray-500 dark:text-slate-400'" class="px-3 py-1.5 rounded-md text-xs font-semibold transition flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg> Grid
                </button>
            </div>
        </div>

        <!-- Empty State -->
        @if($posts->isEmpty())
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-slate-700 p-12 text-center shadow-sm">
                <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-gray-100 dark:bg-slate-700 flex items-center justify-center text-4xl">📅</div>
                <h3 class="text-xl font-bold text-gray-800 dark:text-slate-200 mb-2">No Scheduled Posts</h3>
                <p class="text-gray-500 dark:text-slate-400 text-sm mb-6">Start planning your content strategy now.</p>
                <a href="{{ route('social.scheduler.create') }}" class="px-6 py-2.5 bg-sky-600 text-white rounded-lg text-sm font-bold hover:bg-sky-700 transition">Create First Post</a>
            </div>
        @endif

        <!-- List View -->
        <div x-show="activeView === 'list'" class="space-y-3">
            @foreach ($posts as $post)
            @if($post->status == $filterStatus || $filterStatus == 'all')
            <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-100 dark:border-slate-700 shadow-sm hover:shadow-md transition flex items-center justify-between gap-4 group">
                <div class="flex items-center gap-4 min-w-0">
                    <div class="w-16 h-16 bg-gray-100 dark:bg-slate-700 rounded-lg overflow-hidden shrink-0 border border-gray-200 dark:border-slate-600">
                        @if($post->media_path)
                            <img src="{{ asset('storage/' . $post->media_path) }}" class="object-cover w-full h-full">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 dark:text-slate-500 text-xs font-bold">No Media</div>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <p class="font-semibold text-gray-900 dark:text-white truncate">{{ Str::limit($post->content, 60) }}</p>
                        <div class="flex items-center gap-2 mt-1 text-xs text-gray-500 dark:text-slate-400">
                            <span class="flex items-center gap-1">
                                @if($post->platform == 'instagram') 📸 IG
                                @elseif($post->platform == 'facebook') 📘 FB
                                @elseif($post->platform == 'tiktok') 🎵 TT
                                @else 💻 Web
                                @endif
                            </span>
                            <span>•</span>
                            <span>{{ $post->publish_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <span class="px-2.5 py-1 text-[10px] font-bold rounded-full uppercase tracking-wider {{ $post->status == 'published' ? 'bg-green-100 dark:bg-green-500/20 text-green-700 dark:text-green-300' : ($post->status == 'failed' ? 'bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-300' : 'bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-300') }}">
                        {{ $post->status }}
                    </span>
                    <button class="p-1.5 text-gray-400 dark:text-slate-500 hover:text-gray-700 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-slate-700 rounded-md transition opacity-0 group-hover:opacity-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                    </button>
                </div>
            </div>
            @endif
            @endforeach
        </div>

        <!-- Grid View -->
        <div x-show="activeView === 'grid'" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($posts as $post)
            @if($post->status == $filterStatus || $filterStatus == 'all')
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-slate-700 shadow-sm hover:shadow-md transition overflow-hidden group">
                <div class="h-40 bg-gray-100 dark:bg-slate-700 relative overflow-hidden">
                    @if($post->media_path)
                        <img src="{{ asset('storage/' . $post->media_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400 dark:text-slate-500 text-sm font-bold">No Media</div>
                    @endif
                    <div class="absolute top-2 right-2">
                        <span class="px-2 py-0.5 text-[9px] font-bold rounded-full backdrop-blur-md {{ $post->status == 'published' ? 'bg-green-500/20 text-green-100' : ($post->status == 'failed' ? 'bg-red-500/20 text-red-100' : 'bg-amber-500/20 text-amber-100') }}">{{ $post->status }}</span>
                    </div>
                </div>
                <div class="p-4">
                    <p class="text-sm font-semibold text-gray-800 dark:text-white line-clamp-2 mb-2">{{ Str::limit($post->content, 80) }}</p>
                    <div class="flex items-center justify-between text-xs text-gray-500 dark:text-slate-400">
                        <span class="flex items-center gap-1">
                            @if($post->platform == 'instagram') 📸 Instagram
                            @elseif($post->platform == 'facebook') 📘 Facebook
                            @elseif($post->platform == 'tiktok') 🎵 TikTok
                            @else 💻 Web
                            @endif
                        </span>
                        <span>{{ $post->publish_at->format('d M, H:i') }}</span>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $posts->withQueryString()->links() }}
        </div>
    </div>
</div>

<script>
function schedulerUI() {
    return {
        activeView: 'list',
        filterStatus: 'all'
    }
}
</script>
@endsection
