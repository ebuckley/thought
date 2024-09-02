

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
                            <a href="{{ route('structure.asset', $asset_type) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">{{ $asset_type->name }}</a>
                        </div>
                    </li>
                </ol>
            </nav>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col gap-2 asset-form bg-white shadow-xl sm:rounded-lg">
                <div class="px-4 py-3 sm:px-6 flex flex-col">
                    <div class="inline-flex rounded-md shadow-sm py-4" role="group">
                        <a href="{{route('structure.asset.create', [$asset_type])}}" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                            Add {{$asset_type->name}}
                        </a>
                    </div>
                    <div>
                    @if($assets->count() > 0)
                            <table id="asset-table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3"></th>
                                    <th scope="col" class="px-6 py-3">
                                        Name
                                    </th>
                                    @foreach($asset_type->structure as $elem)
                                        @php
                                            $label = Str::replaceLast("<br>", "", $elem['label']);
                                        @endphp
                                        @switch($elem['type'])
                                            @case('date')
                                            @case('text')
                                            @case('textarea')
                                            @case('radio-group')
                                            @case('trixEditor')
                                                <th scope="col" class="px-6 py-3">
                                                    {{$label}}
                                                </th>
                                            @break
                                            @default
{{--                                                Nothing, because it's a header or whatever--}}
                                        @endswitch
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($assets as $asset)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <x-dropdown align="left">
                                            <x-slot name="trigger">
                                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    </svg>
                                                </button>
                                            </x-slot>
                                            <x-slot name="content">
                                                <x-dropdown-link href="{{route('structure.asset.edit', [$asset_type, $asset])}}">
                                                    {{__('Edit')}}
                                                </x-dropdown-link>
                                                <x-dropdown-link x-data="" x-on:click.prevent="$refs.deleteForm.submit()">
                                                    {{__('Delete')}}
                                                    <form x-ref="deleteForm" method="POST" action="{{ route('structure.asset.destroy', [$asset_type, $asset]) }}" class="hidden">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </x-dropdown-link>
                                            </x-slot>
                                        </x-dropdown>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        @if($asset->name)
                                            {{$asset->name}}
                                        @else
                                            {{$asset->id}}
                                        @endif
                                    </td>
                                    @foreach($asset_type->structure as $elem)
                                        @php
                                            $data = "";
                                            if (isset($asset->data[$elem['name']])) {
                                                $data = $asset->data[$elem['name']];
                                            }
                                        @endphp
                                        @switch($elem['type'])
                                            @case('date')
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{$data}}
                                                </td>
                                                @break
                                            @case('text')
                                            @case('textarea')
                                            @case('radio-group')
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{$data}}
                                                </td>
                                                @break
                                            @case('trixEditor')
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
{{--                                                    TODO if it is a lot of data then maybe this isn't the way..--}}
                                                    {!! $data !!}
                                                </td>
                                            @break
                                            @default
                                                {{--  Nothing, because it's a header or whatever--}}
                                        @endswitch
                                    @endforeach
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-8">
                            {{ $assets->links() }}
                        </div>
                    @else
                        <p class="text-center text-gray-600"> No custom types yet, add one?</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        const thetable = new DataTable('#asset-table', {
            responsive: true
        });
    </script>
</x-app-layout>
