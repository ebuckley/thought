<?php

namespace App\Livewire\Note;

use App\Models\Note;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Edit extends Component
{
    public Note $note;

    #[Validate('required')]
    public $content = '';
    public function mount(Note $note):void
    {
        $this->note = $note;
        $this->content = $this->note->content;
    }
    public function save():void
    {
        $this->authorize('update', $this->note);
        $valid = $this->validate();
        $this->note->update($valid);
        $this->content = '';
        $this->dispatch('note.updated');
    }
    public function render()
    {
        return view('livewire.note.edit');
    }
}
