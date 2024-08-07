

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Asset Types
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col gap-2 asset-form bg-white shadow-xl sm:rounded-lg">
                <div class="px-4 py-3  sm:px-6">
                    <p class="text-lg">
                    Asset Types are the configuration of your thought base. Add from our existing types, or create your own custom asset structures.
                    </p>


                    <div class="inline-flex rounded-md shadow-sm py-4" role="group">
                        <a href="{{route('structure.create')}}" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                            Add New Type
                        </a>
                        <button type="button" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                            Add CRM presets
                        </button>
                        <button type="button" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                            Add Password Manager
                        </button>
                    </div>
                    <div>
                        <h1 class="text-xl">Global types</h1>
                        <p>These are available for all teams to create</p>
                        @foreach($globalAssetTypes as $asset)
                            <div class="py-4">
                                <span class="text-lg">{{$asset->name}}</span>
                                <p>{{$asset->description}}</p>
                                <a href="{{route('structure.asset', $asset)}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                    Show
                                </a>
                                <a href="{{route('structure.edit', $asset->id)}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                    Edit
                                </a>
                            </div>
                            </a>
                        @endforeach

                        <h1 class="text-xl">Team types</h1>
                        @if($teamTypes->count() > 0)
                            @foreach($teamTypes as $asset)
                                <div>
                                        <span class="text-lg">{{$asset->name}}</span>
                                        <p>{{$asset->description}}</p>
                                    <a href="{{route('structure.asset', $asset)}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                        Show
                                    </a>
                                    <a href="{{route('structure.edit', $asset->id)}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                        Edit
                                    </a>
                                    <button data-modal-target="delete-modal-{{$asset->id}}" data-modal-toggle="delete-modal-{{$asset->id}}"  class="font-medium text-gray-500 dark:text-gray-300 hover:underline">
                                        Delete
                                    </button>
                                    <div id="delete-modal-{{$asset->id}}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative p-4 w-full max-w-md max-h-full">
                                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                    </svg>
                                                    <span class="sr-only">Delete asset?</span>
                                                </button>
                                                <div x-data="" class="p-4 md:p-5 text-center">
                                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                    </svg>
                                                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete {{$asset->name}} ?</h3>
                                                    <a x-on:click.prevent="$refs.deleteForm.submit()" data-modal-hide="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                        Delete
                                                    </a>
                                                    <button data-modal-hide="popup-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No, cancel</button>
                                                    <form x-ref="deleteForm" method="POST" action="{{ route('structure.destroy', $asset->id) }}" class="hidden">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="mt-8">
                                {{ $teamTypes->links() }}
                            </div>
                        @else
                            <p class="text-center text-gray-600"> No custom types yet, add one?</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
