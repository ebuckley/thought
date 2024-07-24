<?php

namespace App\Livewire\Note;

use Livewire\Component;

class FilledList extends Component
{
    public $notes = [];
    public function mount(): void
    {
        $this->notes = auth()->user()->notes()->latest()->get();
    }
    public function render()
    {
        return view('livewire.note.filled-list');
    }
}
