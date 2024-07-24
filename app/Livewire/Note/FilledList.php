<?php

namespace App\Livewire\Note;

use App\Models\Note;
use Livewire\Attributes\On;
use Livewire\Component;

class FilledList extends Component
{
    public ?Note $editing;
    public bool $confirmingDeleteNote = false;
    public $notes = [];

    public function edit(Note $note) {
        $this->editing = $note;
    }

    public function delete(Note $note) {
        $this->authorize('delete', $note);
        $note->delete();
        $this->refreshNotes();
        $this->confirmingDeleteNote = false;
    }

    #[On('note.updated')]
    #[On('note.created')]
    public function refreshNotes() {
        $this->notes = auth()->user()->notes()->latest()->get();
        $this->editing = null;
    }
    public function mount(): void
    {
        $this->notes = auth()->user()->notes()->latest()->get();
    }
    public function render()
    {
        return view('livewire.note.filled-list');
    }
}
