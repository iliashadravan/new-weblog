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
        $tickets = Ticket::where('user_id', Auth::id())->with(['messages' => function ($query) {
            $query->whereNull('parent_id')->with('replies');
        }])->get();

        return response()->json($tickets);
    }


    public function store(StoreTicketRequest $request)
    {

        $ticket = Ticket::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'label'   => $request->label
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

        if ($request->parent_id && !TicketMessage::where('id', $request->parent_id)->where('ticket_id', $ticket->id)->exists()) {

            return response()->json([
                'success' => false,
                'message' => 'Parent message is invalid.'
            ], 400);
        }

        $message = TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id'   => Auth::id(),
            'message'   => $request->message,
            'parent_id' => $request->parent_id ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Message sent.',
            'data' => $message
        ]);
    }
}
