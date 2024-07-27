<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($file->name) }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg">
                @if($file->is_image)
                    <img src="{{$file->url}}" alt="{{$file->name}}"/>
                @else
                    <a rel='nofollot' target='_blank' href="{{$file->url}}">Open</a>
                @endif
                <pre>{{json_encode($file, JSON_PRETTY_PRINT)}}</pre>
            </div>
        </div>
    </div>

</x-app-layout>
