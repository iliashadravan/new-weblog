<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketController\sendMessageRequest;
use App\Http\Requests\TicketController\StoreTicketRequest;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index()
    {
        return response()->json(Ticket::where('user_id', Auth::id())->with('messages')->get());
    }

    public function store(StoreTicketRequest $request)
    {

        $ticket = Ticket::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
        ]);

        TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id'   => Auth::id(),
            'message'   => $request->message,
        ]);

        return response()->json(['ticket' => $ticket]);
    }

    public function sendMessage(sendMessageRequest $request, Ticket $ticket)
    {
        if ($ticket->user_id != Auth::id()) {
            return response()->json([
                'success' => false,
            ], 403);
        }

        TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id'   => Auth::id(),
            'message'   => $request->message,
        ]);

        return response()->json([
        'message' => 'Your message has been sent.',
        'success' => true,
        ]);
    }
}
