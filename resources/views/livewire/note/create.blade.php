
<form wire:submit.prevent="save" x-data x-on:submit.prevent="updateContent()">
    <div class="flex flex-col">
        <label class='text-gray-600' for="name">Note Name</label>
        <input class='rounded border-gray-400' type="text" wire:model="name" id="name"/>
    </div>
    <div class="my-3">
        <input id="content" wire:model.live="content" type="hidden">
        <trix-editor class="trix-content" input="content"></trix-editor>
    </div>
    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">
        {{__('Create Note')}}</button>
</form>


<script>
    function updateContent() {
        var editor = document.querySelector('#content');
        @this.$set('content', editor.value);
    }
</script>
