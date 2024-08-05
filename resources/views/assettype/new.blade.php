

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           @if(!is_null($asset))
                Edit {{$asset->name}}
            @else
                New Structure
           @endif

        </h2>
    </x-slot>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
    <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(!is_null($asset))
                <livewire:assettype.formbuilder :assetType="$asset"/>
            @else
                <livewire:assettype.formbuilder />
            @endif
        </div>
    </div>

</x-app-layout>
