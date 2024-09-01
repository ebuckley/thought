<?php

namespace App\Livewire\Note;

use App\Models\Note;
use Laravel\Jetstream\InteractsWithBanner;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\Component;

class Create extends Component
{
    use InteractsWithBanner;

    public $showCreateNoteModal = false;

    #[Validate('required')]
    public $name = '';

    #[Validate('required')]
    public $content = '<h1>Write something today!</h1>';

    // Listen for the create_note event dispatched from the command bar
    #[On('create_note')]
    public function create()
    {
        $this->showCreateNoteModal = true;
    }

    public function save()
    {
        // TODO add an auth check
        $valid = $this->validate();

        auth()->user()->notes()->create($valid);
        $this->content = '';
        $this->name = '';
        $this->dispatch('note.created');
        $this->banner("Created Note");
        $this->showCreateNoteModal = false;
    }
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.note.create');
    }
}
