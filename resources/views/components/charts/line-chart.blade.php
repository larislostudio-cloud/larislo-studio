@props(['data'])

<div class="p-4 bg-white rounded-lg shadow-sm border">
    <div class="flex justify-between items-center mb-4">
        <h3 class="font-semibold text-gray-700">{{ $title ?? 'Chart' }}</h3>
    </div>
    <div class="h-48 w-full bg-gray-50 rounded flex items-center justify-center">
        <!-- Logic Chart.js/Chartist akan ditaruh di sini -->
        <p class="text-gray-400 text-sm">Chart Rendering...</p>
    </div>
</div>
