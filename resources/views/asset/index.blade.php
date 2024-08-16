

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$asset_type->name}}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col gap-2 asset-form bg-white shadow-xl sm:rounded-lg">
                <div class="px-4 py-3  sm:px-6">
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
                                        @switch($elem['type'])
                                            @case('date')
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{$asset->data[$elem['name']]}}
                                                </td>
                                                @break
                                            @case('text')
                                            @case('textarea')
                                            @case('radio-group')
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{$asset->data[$elem['name']]}}
                                                </td>
                                                @break
                                            @case('trixEditor')
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
{{--                                                    TODO if it is a lot of data then maybe this isn't the way..--}}
                                                    {!! $asset->data[$elem['name']] !!}
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
        console.log('hmmmmmm');
        const thetable = new DataTable('#asset-table', {
            responsive: true
        });
        console.log('thetable', thetable);
    </script>
</x-app-layout>
