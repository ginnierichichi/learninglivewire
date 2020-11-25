<div class="text-center">
    {{-- The Master doesn't talk, he acts. --}}
    <h1 class="text-2xl">Tickets</h1>

    @foreach($tickets as $ticket)
        <div class="flex justify-center mb-4">
            <div class="rounded-lg border bg-white p-3 w-2/3 {{$active == $ticket->id ? 'bg-gray-200' : 'shadow-lg'}}" wire:click="$emit('ticketSelected', {{$ticket->id}})">
                <p class="text-gray-800 text-left">{{$ticket->question}}</p>
            </div>
        </div>
    @endforeach
</div>
