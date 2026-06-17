@props(['id', 'title', 'message', 'actionUrl'])

<div id="{{ $id }}" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 class="text-lg font-bold text-gray-900">{{ $title }}</h3>
        <p class="mt-2 text-sm text-gray-600">{{ $message }}</p>
        <div class="mt-4 flex justify-end gap-2">
            <button onclick="document.getElementById('{{ $id }}').classList.add('hidden')" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Cancel</button>
            <form action="{{ $actionUrl }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Delete</button>
            </form>
        </div>
    </div>
</div>
