<div>
<x-dialog-modal wire:model="showCreateNoteModal">
        <x-slot name="title">
            {{ __('Create New Note') }}
        </x-slot>

        <x-slot name="content">
                        
            <form wire:submit.prevent="save" x-data x-on:submit.prevent="updateContent()">
                <div class="flex flex-col">
                    <label class='text-gray-600' for="name">Note Name</label>
                    <input class='rounded border-gray-400' type="text" wire:model="name" id="name"/>
                </div>
                <div class="my-3">
                    <input id="content" wire:model.live="content" type="hidden">
                    <trix-editor class="trix-content" input="content"></trix-editor>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showCreateNoteModal', false)" wire:loading.attr="disabled">
                {{ __('Close') }}
            </x-secondary-button>

            <x-button class="ms-3" wire:click.prevent="save" wire:loading.attr="disabled" x-on:click.prevent="updateContent()">
                {{ __('Create Note') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <x-button wire:click.prevent="$set('showCreateNoteModal', true)">
        {{ __('Create Note') }}
        <span class="ml-2">
            <kbd class="px-2 py-1.5 text-xs font-semibold text-gray-800 bg-gray-100 border border-gray-200 rounded-lg">C</kbd>
            <kbd class="px-2 py-1.5 text-xs font-semibold text-gray-800 bg-gray-100 border border-gray-200 rounded-lg">N</kbd>
        </span>
    </x-button>
</div>
<script>
function updateContent() {
    var editor = document.querySelector('#content');
    @this.$set('content', editor.value);
}
</script>