@props([
    'active' => false,
    'icon' => null // Tambahkan default null agar tidak error jika tidak ada icon
])

<a {{ $attributes->merge(['class' => "flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-colors " . ($active ? 'bg-slate-800 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white')]) }}>
    @if($icon)
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
        </svg>
    @endif

    {{ $slot }}
</a>
