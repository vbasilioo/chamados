<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created comment in storage.
     */
    public function store(Request $request, Ticket $ticket)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $comment = new TicketComment();
        $comment->comment = $request->comment;
        $comment->ticket_id = $ticket->id;
        $comment->user_id = Auth::id();
        $comment->save();

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Comentário adicionado com sucesso!');
    }
} 