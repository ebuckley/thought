<?php

namespace App\Livewire\Assettype;

use App\Models\Asset;
use App\Models\AssetType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class View extends Component
{
    use AuthorizesRequests;
    public ?Asset $asset;
    public ?AssetType $assetType;
    public $currentData = [];

    public function mount($assetType = null, $asset = null)
    {
        if (isset($asset)) {
            // TODO this is verbose but I want to actually validate here that asset matches assettype as well?
            foreach ($asset->data as $key => $value) {
                $this->currentData[$key] = $value;
            }
        } else {
            foreach ($assetType->structure as $elem) {
                if (isset($elem['name'])) {
                    $this->currentData[$elem['name']] = '';
                }
            }
        }
        $this->asset = $asset;
        $this->assetType = $assetType;
    }

    public function save($structure) {
        if (!is_null($this->assetType)) {
            if (!isset($this->asset)) {
                $this->authorize('create', Asset::class);
                $asset = $this->assetType->assets()->create([
                    'data' => $structure,
                ]);
                // redirect
                $route = route('structure.asset.show', [$this->assetType, $asset]);
                $this->redirect($route);
            } else {
                $this->authorize('update', $this->asset);
                $this->asset->update([
                    'data' => $structure,
                ]);
                $route = route('structure.asset.show', [$this->assetType, $this->asset]);
                $this->redirect($route);
            }

        } else {
            throw new \Exception("No AssetType so ot sure how to even save this..");
        }
    }
    public function render()
    {
        return view('livewire.assettype.view');
    }
}
