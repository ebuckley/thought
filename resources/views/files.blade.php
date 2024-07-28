<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Files') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-6">
                <livewire:file-upload/>
            </div>
            <div class="bg-white shadow-xl sm:rounded-lg p-6">
{{--                <form action="{{ route('files.upload') }}" method="POST" enctype="multipart/form-data" class="my-2">--}}
{{--                    @csrf--}}
{{--                    <div class="flex items-center justify-center w-full">--}}
{{--                        <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">--}}
{{--                            <div class="flex flex-col items-center justify-center pt-5 pb-6">--}}
{{--                                <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>--}}
{{--                                </svg>--}}
{{--                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>--}}
{{--                                <p class="text-xs text-gray-500">Any file, no maximum size.</p>--}}
{{--                            </div>--}}
{{--                            <input id="dropzone-file" type="file" name="file" class="hidden" />--}}
{{--                        </label>--}}
{{--                    </div>--}}
{{--                    <div class="mt-4">--}}
{{--                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">--}}
{{--                            Upload File--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </form>--}}

                @if($files->count() > 0)
                    <div class="">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Team ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($files as $file)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $file->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $file->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $file->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $file->team_id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <x-dropdown>
                                            <x-slot name="trigger">
                                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    </svg>
                                                </button>
                                            </x-slot>
                                            <x-slot name="content">
                                                <x-dropdown-link href="{{ route('files.view', $file->id) }}">
                                                    {{__('Show')}}
                                                </x-dropdown-link>
                                                <x-dropdown-link
                                                    x-data=""
                                                    x-on:click.prevent="$refs.deleteForm.submit()"
                                                >
                                                    {{__('Delete')}}
                                                </x-dropdown-link>
                                                <form x-ref="deleteForm" method="POST" action="{{ route('files.delete', $file->id) }}" class="hidden">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </x-slot>
                                        </x-dropdown>
{{--                                        <form action="{{ route('files.destroy', $file->id) }}" method="POST" class="inline-block">--}}
{{--                                            @csrf--}}
{{--                                            @method('DELETE')--}}
{{--                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete {{$file->name}} ?')">Delete</button>--}}
{{--                                        </form>--}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8">
                        {{ $files->links() }}
                    </div>
                @else
                    <p class="text-center text-gray-600">No notes found.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
