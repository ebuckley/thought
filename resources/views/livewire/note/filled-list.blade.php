<div class="mt-6 divide-y">
    @foreach($notes as $note)
       <div class="p-6 flex-col space-x-2" wire:key="{{$note->id}}">
           <div class="px-2 flex-1">
               <div class="flex justify-between items-center">
                    <a href="{{ route('notes.view', ['id' => $note->id]) }}"
                       class="flex-col flex">
                        <span class="text-gray-800 text-lg">{{$note->name}}</span>
                        <span class="text-sm text-gray-500">{{$note->created_at}}</span>
                    </a>
                   @if ($note->user->is(auth()->user()))
                       <x-dropdown>
                           <x-slot name="trigger">
                               <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                   <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                       <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                   </svg>
                               </button>
                           </x-slot>
                           <x-slot name="content">
                               <x-dropdown-link wire:click="edit({{$note->id}})">
                                   {{__('Edit')}}
                               </x-dropdown-link>
                               <x-dropdown-link wire:click="$toggle('confirmingDeleteNote')">
                                   {{__('Delete')}}
                               </x-dropdown-link>
                           </x-slot>
                       </x-dropdown>
                   @endif
               </div>
           </div>
           @if($note->is($editing))
               <livewire:note.edit :note="$note" :key="$note->id" />
           @else
           <div class="trix-content">
               {!! $note->content !!}
           </div>
           @endif
           <x-confirmation-modal wire:model="confirmingDeleteNote">
               <x-slot name="title">
                   Delete Note?
               </x-slot>

               <x-slot name="content">
                   Are you sure you want to delete {{$note->name}}?
               </x-slot>

               <x-slot name="footer">
                   <x-secondary-button wire:click="$toggle('confirmingDeleteNote')" wire:loading.attr="disabled">
                       Nevermind
                   </x-secondary-button>

                   <x-danger-button class="ml-2" wire:click="delete({{$note->id}})" wire:loading.attr="disabled">
                       Delete Note
                   </x-danger-button>
               </x-slot>
           </x-confirmation-modal>
       </div>
    @endforeach
</div>
