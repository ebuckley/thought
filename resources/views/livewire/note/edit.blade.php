
<form  wire:submit.prevent="save"
       x-data="trixContent"
       x-on:submit.prevent="updateContent"
       x-init="$nextTick(()=> setInitialContent())">
    <div class="mb-3">
        <input id="note-{{$note->id}}-content" wire:model.live="content" type="hidden">
        <trix-editor class="trix-content" input="note-{{$note->id}}-content"></trix-editor>
    </div>
    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">
        {{__('Save')}}</button>
</form>

@script
<script>
    Alpine.data('trixContent', () => ({
        setInitialContent() {
            const root = @this.el;
            const trixEl = root.querySelector('.trix-content');
            console.log('setting editor value', trixEl);
            trixEl.value = $wire.content;
        },
        updateContent() {
                const root = @this.el;
                const trixEl = root.querySelector('.trix-content');
                console.log('setting editor value', trixEl.value);
                @this.$set('content', trixEl.value);
        }
    }))
</script>
@endscript
