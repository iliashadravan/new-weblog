<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketController\sendMessageRequest;
use App\Http\Requests\TicketController\updateStatusRequest;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        return response()->json(Ticket::with('messages')->get());
    }

    public function sendMessage(sendMessageRequest $request, Ticket $ticket)
    {

        TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id'   => auth()->id(),
            'message'   => $request->message,
        ]);

        return response()->json(['message' => ' Your message has been sent.']);

    }

    public function updateStatus(updateStatusRequest $request, Ticket $ticket)
    {

        $ticket->update(['status' => $request->status]);

        return response()->json(['message' => 'Ticket status changed']);
    }
}
