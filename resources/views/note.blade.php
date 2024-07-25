<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center">
    <div class="max-w-2xl w-full">
        <h1 class="text-3xl font-bold mb-4 text-gray-800">{{ $note->name }}</h1>
        <div class="prose trix-content">
            {!!  $note->content  !!}
        </div>
        <div class="mt-6 text-sm text-gray-500">
            Created: {{ $note->created_at->format('F j, Y, g:i a') }}
        </div>
    </div>
</x-guest-layout>
