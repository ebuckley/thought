<?php

namespace App\Livewire;

use Livewire\Component;

class CommandBar extends Component
{
    public $commands = [
        [
            'name' => 'Create Note',
            'keys' => ['cn'],
        ]
    ];

    

    public function render()
    {
        return <<<'HTML'
        <span x-data="{modalOpen: false}" @keyup.ctrl.e.window.prevent="modalOpen = true" @keyup.esc.window="modalOpen = false">
            <template x-teleport="body" >
                <template x-if="modalOpen">
                <div tabindex="-1" class="backdrop-grayscale overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="mx-auto relative p-4 w-full max-w-md max-h-full">
                        <div class="mx-auto  relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <div class="p-4 md:p-5" x-trap="modalOpen">
                                <input class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block" type="text" placeholder="Enter a command" />

                                @foreach($commands as $command)
                                <div>
                                    {{$command['name']}}
                                    @foreach($command['keys'] as $key)
                                    <kbd class="ml-2 bg-gray-100 dark:bg-gray-800 rounded-md px-2 py-1">{{$key}}</kbd>
                                    @endforeach
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                </template>
            </template>
        </span>
        @script
        <script>
            console.log('command bar loaded');
            // Print out the commands keymap
            console.log($wire.commands.map(command => `${command.name}: ${command.keys.join(', ')}`).join('\n'));
            const sequence = [];
            let timeout;
            window.addEventListener('keyup', (e) => {
                // turn off the global hotkey launch system if something is focused in the app
                if (document.activeElement.tagName === 'INPUT' || document.activeElement.tagName === 'TEXTAREA' || document.activeElement.tagName === 'SELECT'
                    || document.activeElement.tagName === 'BUTTON' || document.activeElement.tagName === 'A' || document.activeElement.tagName === 'LABEL' ||
                    document.activeElement.tagName === 'OPTION' || document.activeElement.tagName === 'DIALOG' || 
                    document.activeElement.tagName === 'TRIX-EDITOR'
                ) {
                    return;
                }
                clearInterval(timeout);
                const key = event.key.toLowerCase()
                sequence.push(key)
                // trim to the last 2 items in the list
                sequence.splice(0, sequence.length - 2)
                // start a timer to clear the list
                timeout = setTimeout(() => {
                    sequence.length = 0;
                }, 300)
                console.log(sequence);
                // dispatch the right function depending on what the thing is
                sequence.join('');

                // Check if the sequence matches any command's keys
                $wire.commands.forEach(command => {
                    if (sequence.join('') === command.keys.join('').toLowerCase()) {
                        // dispatch the command to the livewire component
                        const dispatchTo = command.name.toLowerCase().replace(/\s+/g, '_');
                        console.log(dispatchTo);
                        $wire.dispatch(dispatchTo);
                    }
                });
            })
        </script>
        @endscript
        HTML;
    }
}
