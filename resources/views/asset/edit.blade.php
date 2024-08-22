

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit @if($asset->name)
                {{$asset->name}}
            @else
                {{  $asset->id }}
            @endif
            @if($asset->deleted)
                deleted
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:assettype.asseteditor :assetType="$assetType" :asset="$asset"></livewire:assettype.asseteditor>
        </div>
    </div>
</x-app-layout>
