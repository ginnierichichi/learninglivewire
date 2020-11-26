<div class="text-center">
    {{-- The Master doesn't talk, he acts. --}}
    <h1 class="text-2xl">Tickets</h1>

    <form wire:submit.prevent="addTicket" class="my-4 flex justify-center">
        <input wire:model.debounce.500ms="newTicket"
               type="text"
               class="w-2/3 rounded border shadow p-2 mr-2 my-2"
               placeholder="Create a Ticket">
        <div class="py-2">
            <button type="submit" class="bg-blue-300 rounded-lg px-4 py-2 text-white">Add</button>
        </div>
    </form>

    @foreach($tickets as $ticket)
        <div class="flex justify-center mb-4">
            <div class="rounded-lg border bg-white p-3 w-2/3 {{$active == $ticket->id ? 'bg-gray-200' : 'shadow-lg'}}" wire:click="$emit('ticketSelected', {{$ticket->id}})">
                <p class="text-gray-800 text-left">{{$ticket->questions}}</p>
            </div>
        </div>
    @endforeach
</div>
