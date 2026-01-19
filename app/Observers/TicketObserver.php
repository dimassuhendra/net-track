<?php

namespace App\Observers;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TicketObserver
{
    public function created(Ticket $ticket)
    {
        Notification::create([
            'user_id' => $ticket->pic_id,
            'title' => 'Penugasan Tiket Baru',
            'message' => "Anda ditugaskan pada tiket #{$ticket->ticket_number}",
            'type' => 'assignment'
        ]);
    }
}