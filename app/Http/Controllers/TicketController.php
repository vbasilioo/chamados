<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Category;
use App\Models\User;
use App\Enums\TicketStatus;
use App\Enums\TicketPriority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ticket::with(['user', 'assignedUser', 'category'])
            ->when($request->status, fn($q) => $q->withStatus(TicketStatus::from($request->status)))
            ->when($request->priority, fn($q) => $q->withPriority(TicketPriority::from($request->priority)))
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id))
            ->when(!Auth::user()->hasRole('admin'), function($q) {
                $q->where(function($query) {
                    $query->where('user_id', Auth::id())
                        ->orWhere('assigned_to', Auth::id());
                });
            });

        $tickets = $query->latest()->paginate(10);
        $categories = Category::all();
        $statuses = TicketStatus::cases();
        $priorities = TicketPriority::cases();

        return view('tickets.index', compact('tickets', 'categories', 'statuses', 'priorities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $priorities = TicketPriority::cases();
        $agents = User::role(['admin', 'operador'])->get();

        return view('tickets.create', compact('categories', 'priorities', 'agents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'priority' => ['required', 'string', 'in:' . implode(',', array_column(TicketPriority::cases(), 'value'))],
            'assigned_to' => ['nullable', 'exists:users,id'],
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = TicketStatus::OPEN;

        $ticket = Ticket::create($validated);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Chamado criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        $ticket->load(['user', 'assignedUser', 'category', 'comments.user']);

        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        $categories = Category::all();
        $priorities = TicketPriority::cases();
        $statuses = TicketStatus::cases();
        $agents = User::role(['admin', 'operador'])->get();

        return view('tickets.edit', compact('ticket', 'categories', 'priorities', 'statuses', 'agents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'priority' => ['required', 'string', 'in:' . implode(',', array_column(TicketPriority::cases(), 'value'))],
            'status' => ['required', 'string', 'in:' . implode(',', array_column(TicketStatus::cases(), 'value'))],
            'assigned_to' => ['nullable', 'exists:users,id'],
        ]);

        $ticket->update($validated);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Chamado atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $this->authorize('delete', $ticket);

        $ticket->delete();

        return redirect()->route('tickets.index')
            ->with('success', 'Chamado excluído com sucesso.');
    }

    public function accept(Ticket $ticket)
    {
        // Apenas operadores e admins podem aceitar chamados
        if (!Auth::user()->hasAnyRole(['operador', 'admin'])) {
            abort(403, 'Somente operadores e administradores podem aceitar chamados.');
        }

        // Verifica se o chamado já está atribuído
        if ($ticket->assigned_to !== null) {
            return redirect()->route('tickets.show', $ticket)
                ->with('error', 'Este chamado já está atribuído a um operador.');
        }

        $ticket->update([
            'assigned_to' => Auth::id(),
            'status' => TicketStatus::IN_PROGRESS
        ]);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Chamado aceito com sucesso!');
    }
}
