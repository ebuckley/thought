<x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Search') }}
            </h2>
        </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-6">
                <form class="flex items-center w-full gap-2" method="GET" action="{{route('notes.search')}}">
                        <input name="query" value="{{$query}}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full" id="title" type="text" placeholder="Search for anything">
                        <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path></svg>
                        </button>
                </form>

                @if($notesPage->count() > 0)
                    <div class="space-y-4">
                        @foreach($notesPage as $note)
                            <div class="p-6 border-b border-gray-500">
                                <h2 class="text-xl font-semibold mb-2">
                                    <a href="{{ route('notes.view', $note->id) }}" class="text-blue-600 hover:underline">
                                        {{ $note->name }}
                                    </a>
                                </h2>
                                @if(strlen($note->content) < 1024)
                                    <p class="trix-content">{!! $note->content !!}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8">
                        {{ $notesPage->appends(['query' => $query])->links() }}
                    </div>
                @else
                    <p class="text-center text-gray-600">No notes found.</p>
                @endif
            </div>
        </div>
    </div>

</x-app-layout>
