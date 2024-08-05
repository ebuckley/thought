<?php

namespace App\Livewire\Assettype;

use App\Models\AssetType;
use Livewire\Component;

class View extends Component
{
    public ?AssetType $assetType;
    public function mount($assetType = null)
    {
        $this->assetType = $assetType;
    }
    public function render()
    {
        return view('livewire.assettype.view');
    }
}
