

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $assetType->name }}
            @if($assetType->deleted)
                deleted
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:assettype.asset-editor :assetType="$assetType"></livewire:assettype.asset-editor>
        </div>
    </div>
</x-app-layout>
