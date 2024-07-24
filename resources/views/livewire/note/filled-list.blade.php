<div class="flex flex-col">
    @foreach($notes as $note)
       <div wire:key="{{$note->id}}">
           <div>
               <span>{{$note->name}}</span>
               <span class="text-sm text-gray-500">{{$note->created_at}}</span>
           </div>
           <div class="trix-content">
               {!! $note->content !!}
           </div>
       </div>
    @endforeach
</div>
