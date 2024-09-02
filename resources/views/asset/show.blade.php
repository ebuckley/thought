<x-app-layout>
    <x-slot name="header">
        <nav class="flex mb-5 sm:mb-0" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <a href="{{ route('structure.asset', $asset->assetType) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">{{ $asset->assetType->name }}</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">
                        @if($asset->name)
                            {{$asset->name}}
                        @else
                            {{  $asset->id }}
                        @endif
                        @if($asset->deleted)
                            <span class="text-red-600">(Deleted)</span>
                        @endif
                        </span>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('structure.asset.edit', [$asset->assetType, $asset]) }}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Edit Asset
            </a>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @foreach($asset->assetType->structure as $elem)
                    <div class="mb-4">
                        @php
                            $label = preg_replace('/<br\s*\/?>\s*$/', '', $elem['label']);
                        @endphp
                        @switch($elem['type'])
                            @case('header')
                                {!! '<' . $elem['subtype'] . ' class="font-semibold mb-2">' !!}
                                {{ $label }}
                                {!! '</' . $elem['subtype'] . '>' !!}
                                @break
                            @case('paragraph')
                                <p class="mb-2">{!! $label !!}</p>
                                @break
                            @case('date')
                                <p><strong>{{ $label }}:</strong> {{ $asset->data[$elem['name']] ?? 'N/A' }}</p>
                                @break
                            @case('textarea')
                            @case('text')
                                <p><strong>{{ $label }}:</strong> {{ $asset->data[$elem['name']] ?? 'N/A' }}</p>
                                @break
                            @case('trixEditor')
                                <div>
                                    <strong>{{ $label }}:</strong>
                                    <div class="trix-content mt-2">{!! $asset->data[$elem['name']] ?? 'N/A' !!}</div>
                                </div>
                                @break
                            @case('radio-group')
                                <p><strong>{{ $label }}:</strong> {{ $asset->data[$elem['name']] ?? 'N/A' }}</p>
                                @break
                            @default
                                <p class="text-red-600">Unknown element type: {{ $elem['type'] }}</p>
                        @endswitch
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
