<?php

namespace App\Http\Livewire;

use App\Models\SupportTicket;
use Livewire\Component;

class Tickets extends Component
{
    public $active;     //first one is always selected
    public $newTicket;
    protected $listeners = [
        'ticketSelected' => 'ticketSelected',
    ];

    public function addTicket()
    {
        $this->validate(['newTicket'=>'required|max:255']);

        $createdTicket = SupportTicket::create([
            'questions' => $this->newTicket,
        ]);
        $this->newTicket ='';
    }

    public function ticketSelected($ticketId)
    {
        $this->active = $ticketId;
    }

    public function render()
    {
        return view('livewire.tickets', [
            'tickets' => SupportTicket::all(),
        ]);
    }
}
