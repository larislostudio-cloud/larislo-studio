@extends('layouts.app')

@section('title', 'AI Voice Over')

@section('content')
<div class="max-w-3xl mx-auto py-6">

    <!-- Info Kredit -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6 flex justify-between items-center">
        <div>
            <h3 class="font-bold text-gray-800">Sisa Kredit Anda</h3>
            <p class="text-2xl font-extrabold text-sky-600">{{ auth()->user()->credits }} Kredit</p>
        </div>
        <span class="text-xs text-gray-400 font-medium bg-gray-50 px-3 py-1 rounded-full">Biaya: 3 Kredit</span>
    </div>

    <div class="bg-white p-8 rounded-xl shadow border border-gray-100">
        <h2 class="text-xl font-bold mb-4">🎙️ Text to Speech</h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-200 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">{{ session('error') }}</div>
        @endif

        <form action="{{ route('ai.voice.generate') }}" method="POST">
            @csrf
            <textarea name="text" class="w-full border-gray-200 rounded-lg p-4 mb-4 focus:ring-sky-500 focus:border-sky-500" rows="6" placeholder="Type text here..."></textarea>
            <div class="flex gap-4 mb-4">
                <select name="voice_type" class="border border-gray-200 rounded-lg p-3 flex-1 bg-white focus:ring-sky-500">
                    <option value="female">Female Voice</option>
                    <option value="male">Male Voice</option>
                </select>
            </div>
            <button class="w-full bg-sky-600 text-white py-3 rounded-lg font-bold hover:bg-sky-700 transition flex items-center justify-center gap-2
                           {{ auth()->user()->credits < 3 ? 'opacity-50 cursor-not-allowed' : '' }}"
                    {{ auth()->user()->credits < 3 ? 'disabled' : '' }}>
                <span>Generate Audio</span>
                <span class="bg-white/20 text-xs px-2 py-1 rounded-full ml-2">-3 Kredit</span>
            </button>
        </form>
    </div>
</div>
@endsection
