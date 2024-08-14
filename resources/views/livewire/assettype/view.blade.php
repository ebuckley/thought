<form x-data="structureForm" x-ref="assetForm" x-on:submit.prevent="save($refs.assetForm)"
      class="flex flex-col gap-2 asset-form bg-white shadow-xl sm:rounded-lg">
    <div class="px-4 py-3  sm:px-6">
        @foreach($assetType->structure as $elem)
            <div class="pt-1 pb-3" wire:key="{{$loop->index}}">
                @switch($elem['type'])
                    @case('header')

                        {!! '<' . $elem['subtype'] . ' class="font-semibold" >' !!}
                        {{$elem['label']}}
                        {!! '</' . $elem['subtype'] . '>' !!}
                        @break
                    @case('paragraph')
                        <p>{!!  $elem['label'] !!}</p>
                        @break
                    @case('date')
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                               for="{{$loop->index}}">{{$elem['label']}}</label>
                        <div class="relative max-w-sm">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>
                            <input id="{{$loop->index}}" datepicker name="{{$elem['name']}}" type="text"
                                   value="{{$currentData[$elem['name']]}}"
                                   class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="Select date">
                        </div>
                        @if(isset($elem['description']))
                            <p id="floating_helper_text"
                               class="mt-2 text-xs text-gray-500 dark:text-gray-400">{{$elem['description']}}</p>
                        @endif
                        @break
                    @case('textarea')
                        <div class="flex flex-col">

                            {{--                    {{json_encode($elem)}}--}}
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                   for="{{$loop->index}}">{{$elem['label']}}</label>
                            <textarea
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                                name="{{$elem['name']}}">{{$currentData[$elem['name']]}}</textarea>
                            @if(isset($elem['description']))
                                <p id="floating_helper_text"
                                   class="mt-2 text-xs text-gray-500 dark:text-gray-400">{{$elem['description']}}</p>
                            @endif
                        </div>
                        @break
                    @case('text')
                        <div class="flex flex-col">

                            {{--                    {{json_encode($elem)}}--}}
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                   for="{{$loop->index}}">{{$elem['label']}}</label>
                            <input type="{{$elem['type']}}"
                                   class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                                   value="{{$currentData[$elem['name']]}}"
                                   name="{{$elem['name']}}"/>
                            @if(isset($elem['description']))
                                <p id="floating_helper_text"
                                   class="mt-2 text-xs text-gray-500 dark:text-gray-400">{{$elem['description']}}</p>
                            @endif
                        </div>
                        @break
                    @case('trixEditor')
                         <div class="flex flex-col">
                             <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{$elem['label']}}</label>
                             <input id="{{$elem['name']}}" type="hidden" name="{{$elem['name']}}"/>
                             <trix-editor class="trix-content" input="{{$elem['name']}}" />
                         </div>
                    @break
                    @default
                        <span class="text-red-800 font-bold">Unknown form element type</span>
                        {{json_encode($elem)}}
                @endswitch
            </div>
        @endforeach
    </div>
    <div
        class="flex items-center justify-end px-4 py-3 bg-gray-50 text-end sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
        <button
            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">
            @if(isset($asset))
                Update
            @else
                Create
            @endif
        </button>
    </div>
</form>

@script
<script>
    Alpine.data('structureForm', () => ({
        save(el) {
            const fd = new FormData(el);
            const entries = Object.fromEntries(fd)
            $wire.save(entries);
        }
    }))

</script>
@endscript
