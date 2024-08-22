<?php

namespace App\Livewire\Assettype;

use App\Models\AssetType;
use Laravel\Jetstream\InteractsWithBanner;
use Livewire\Component;

class Formbuilder extends Component
{
    use InteractsWithBanner;
    public ?AssetType $assetType = null;
    public $name = "";
    public $description = "";
    public $structure = [];
    public $expirationKey = "";

    public function save() {

        $props = [
            'name' => $this->name,
            'description' => $this->description,
            'expiration_key' => $this->expirationKey,
            'structure' => $this->structure,
        ];
        if (is_null($this->assetType)) {
            $this->authorize('create', AssetType::class);
            auth()->user()->currentTeam->assetTypes()->create($props);
        } else {
            $this->authorize('update', $this->assetType);
            $this->assetType->update($props);
        }
        return route('structure.index');
    }
    public function mount(?AssetType $assetType) {
        if ($assetType->exists) {
            $this->assetType = $assetType;
            $this->name = $assetType->name;
            $this->description = $assetType->description;
            $this->structure = $assetType->structure;
            $this->expirationKey = $assetType->expiration_key;
        }
    }
    public function render()
    {
        return <<<'HTML'
        <div>
            <div class="flex flex-col gap-4">


                <div class="flex flex-col">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="name">Name</label>
                    <input type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" wire:model="name"></input>
                    <p id="floating_helper_text" class="mt-2 text-xs text-gray-500 dark:text-gray-400">The name of this structure, this will be used in navigation I.E Contacts</p>
                </div>
               <div class="flex flex-col">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> Description </label>
                    <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" placeholder="A description" wire:model="description"></textarea>
                </div>
                <div class="flex flex-col pb-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="expiration-key"> Expiration Key </label>
                    <input id="expiration-key" type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" wire:model="expirationKey" />
                    <p id="floating_helper_text" class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        The key that will be used for making new expirations, it should be a date key from the form structure created below</p>
                </div>

                <div id="fb-editor"></div>
          </div>
            @script
            <script>
            console.log('running script');
                if (!window.fbControls) window.fbControls = new Array();
                window.fbControls.push(function (controlClass) {
                  class trixEditor extends controlClass {
                      configure() {
                          console.log('trix editor plugin configured')
                      }
                      build() {
                          return this.markup('span', null, {id: this.config.name})
                      }
                      static get definition() {
                          return {
                              i18n: {
                                  default: 'Rich Text Editor'
                              }
                          }
                      }

                      onRender() {
                      //     do we need to do anthing?
                      $('#' + this.config.name).text('A rich text editor goes here ' + JSON.stringify(this.config))
                      }
                  }
                  controlClass.register('trixEditor', trixEditor)
                  return trixEditor;
                });
                jQuery(async function($) {
                    const options = {
                      onSave: async function(evt, formData) {
                          console.log(evt);
                          console.log(formData);
                          $wire.structure = JSON.parse(formData);
                          await $wire.save();
                          window.location.replace("{{route('structure.index')}}");
                      }
                    };
                    const form = $(document.getElementById('fb-editor')).formBuilder(options);
                    await form.promise;

                    form.actions.setData(JSON.stringify($wire.structure));
                    console.log($wire.structure);

                });
            </script>
            @endscript
        </div>
        HTML;
    }
}
