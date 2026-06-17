@extends('layouts.app')

@section('title', 'Connect Accounts')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Connect Social Media</h1>

    <div class="space-y-4">
        <!-- Instagram -->
        <div class="bg-white p-4 rounded-lg shadow flex justify-between items-center">
            <div class="flex items-center gap-3">
                <span class="text-2xl">📷</span>
                <span class="font-medium">Instagram Business</span>
            </div>
            <a href="{{ route('social.instagram.connect') }}" class="px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white text-sm rounded-lg">Connect</a>
        </div>

        <!-- Facebook -->
        <div class="bg-white p-4 rounded-lg shadow flex justify-between items-center">
            <div class="flex items-center gap-3">
                <span class="text-2xl">📘</span>
                <span class="font-medium">Facebook Page</span>
            </div>
            <a href="{{ route('social.facebook.connect') }}" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg">Connect</a>
        </div>

        <!-- TikTok -->
        <div class="bg-white p-4 rounded-lg shadow flex justify-between items-center">
            <div class="flex items-center gap-3">
                <span class="text-2xl">🎵</span>
                <span class="font-medium">TikTok</span>
            </div>
            <a href="#" class="px-4 py-2 bg-black text-white text-sm rounded-lg">Connect</a>
        </div>
    </div>
</div>
@endsection
