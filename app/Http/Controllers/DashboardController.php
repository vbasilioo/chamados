<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketComment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the dashboard.
     */
    public function index(): View
    {
        // Estatísticas
        $stats = [
            'total_users' => User::count(),
            'active_tickets' => Ticket::whereNotIn('status', ['closed', 'resolved'])->count(),
            'closed_tickets' => Ticket::whereIn('status', ['closed', 'resolved'])->count(),
            'avg_response_time' => $this->calculateAverageResponseTime(),
        ];
        
        // Dados para o gráfico
        $chartData = $this->getChartData();
        
        // Atividades recentes
        $activities = $this->getRecentActivities();
        
        return view('dashboard', compact('stats', 'chartData', 'activities'));
    }

    private function calculateAverageResponseTime()
    {
        $tickets = Ticket::whereNotNull('created_at')
            ->whereNotNull('updated_at')
            ->get();
            
        if ($tickets->isEmpty()) {
            return '0h 0m';
        }
        
        $totalHours = $tickets->sum(function ($ticket) {
            return $ticket->created_at->diffInHours($ticket->updated_at);
        });
        
        $averageHours = $totalHours / $tickets->count();
        $hours = floor($averageHours);
        $minutes = round(($averageHours - $hours) * 60);
        
        return "{$hours}h {$minutes}m";
    }

    private function getChartData()
    {
        $months = collect(['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun']);
        
        $ticketsByMonth = Ticket::selectRaw('EXTRACT(MONTH FROM created_at) as month, COUNT(*) as count')
            ->whereRaw('EXTRACT(YEAR FROM created_at) = ?', [Carbon::now()->year])
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();
            
        $resolvedTicketsByMonth = Ticket::selectRaw('EXTRACT(MONTH FROM updated_at) as month, COUNT(*) as count')
            ->whereRaw('EXTRACT(YEAR FROM updated_at) = ?', [Carbon::now()->year])
            ->whereIn('status', ['closed', 'resolved'])
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();
            
        $newTicketsData = $months->map(function ($month, $index) use ($ticketsByMonth) {
            return $ticketsByMonth[$index + 1] ?? 0;
        });
        
        $resolvedTicketsData = $months->map(function ($month, $index) use ($resolvedTicketsByMonth) {
            return $resolvedTicketsByMonth[$index + 1] ?? 0;
        });
        
        return [
            'labels' => $months,
            'datasets' => [
                [
                    'label' => 'Novos Tickets',
                    'data' => $newTicketsData,
                ],
                [
                    'label' => 'Tickets Resolvidos',
                    'data' => $resolvedTicketsData,
                ]
            ]
        ];
    }

    private function getRecentActivities()
    {
        $recentComments = TicketComment::with(['user', 'ticket'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($comment) {
                return [
                    'user' => $comment->user->name,
                    'action' => "Comentou no chamado #{$comment->ticket->id}",
                    'time' => $comment->created_at,
                ];
            });
            
        $recentStatusChanges = Ticket::with('user')
            ->whereNotNull('status')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($ticket) {
                return [
                    'user' => $ticket->user->name,
                    'action' => "Atualizou o status do chamado #{$ticket->id} para \"{$ticket->status->label()}\"",
                    'time' => $ticket->updated_at,
                ];
            });
            
        return $recentComments->concat($recentStatusChanges)
            ->sortByDesc('time')
            ->take(5)
            ->values()
            ->all();
    }
}
