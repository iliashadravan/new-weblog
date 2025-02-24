<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketController\sendMessageRequest;
use App\Http\Requests\TicketController\updateStatusRequest;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Http\Request;

class TicketAdminController extends Controller
{
    public function index()
    {
        return response()->json(Ticket::with(['messages.replies'])->get());
    }

    public function sendMessage(sendMessageRequest $request, Ticket $ticket)
    {
        $message = TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id'   => auth()->id(),
            'message'   => $request->message,
            'parent_id' => $request->parent_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your message has been sent.',
            'data'    => $message
        ]);
    }


    public function updateStatus(updateStatusRequest $request, Ticket $ticket)
    {

        $ticket->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Ticket status changed']);
    }
}
