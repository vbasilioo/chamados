<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Category;
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
    public function index()
    {
        // Verifica se é admin ou operador para mostrar todos os tickets
        if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('operador')) {
            $tickets = Ticket::with(['user', 'assignedUser', 'category'])->latest()->paginate(10);
        } else {
            // Usuário normal só vê seus próprios tickets
            $tickets = Ticket::with(['user', 'assignedUser', 'category'])
                ->where('user_id', Auth::id())
                ->latest()
                ->paginate(10);
        }
        
        $categories = Category::all();
        
        return view('tickets.index', compact('tickets', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $categories = Category::all();
        
        return view('tickets.create', compact('users', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'assignee_id' => 'nullable|exists:users,id',
            'priority' => 'required|in:baixa,media,alta,critica',
            'category_id' => 'required|exists:categories,id',
        ]);

        $ticket = new Ticket();
        $ticket->title = $request->title;
        $ticket->description = $request->description;
        $ticket->user_id = Auth::id();
        $ticket->assigned_to = $request->assignee_id;
        $ticket->priority = $request->priority;
        $ticket->category_id = $request->category_id;
        $ticket->status = 'aberto';
        $ticket->save();

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Chamado criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        // Verifica se o usuário tem permissão para ver este ticket
        if (!Auth::user()->hasRole(['admin', 'operador']) && Auth::id() !== $ticket->user_id) {
            abort(403, 'Você não tem permissão para visualizar este chamado.');
        }
        
        $ticket->load(['user', 'assignedUser', 'comments.user', 'category']);
        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        // Verifica se o usuário tem permissão para editar este ticket
        if (!Auth::user()->hasRole(['admin', 'operador']) && Auth::id() !== $ticket->user_id) {
            abort(403, 'Você não tem permissão para editar este chamado.');
        }
        
        $users = User::all();
        $categories = Category::all();
        
        return view('tickets.edit', compact('ticket', 'users', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        // Verifica se o usuário tem permissão para atualizar este ticket
        if (!Auth::user()->hasRole(['admin', 'operador']) && Auth::id() !== $ticket->user_id) {
            abort(403, 'Você não tem permissão para atualizar este chamado.');
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'assignee_id' => 'nullable|exists:users,id',
            'status' => 'required|in:aberto,em_andamento,resolvido,fechado',
            'priority' => 'required|in:baixa,media,alta,critica',
            'category_id' => 'required|exists:categories,id',
        ]);

        $ticket->title = $request->title;
        $ticket->description = $request->description;
        $ticket->assigned_to = $request->assignee_id;
        $ticket->status = $request->status;
        $ticket->priority = $request->priority;
        $ticket->category_id = $request->category_id;
        $ticket->save();

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Chamado atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        // Apenas admin pode excluir tickets
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Você não tem permissão para excluir chamados.');
        }
        
        $ticket->delete();
        
        return redirect()->route('tickets.index')
            ->with('success', 'Chamado excluído com sucesso!');
    }
}
