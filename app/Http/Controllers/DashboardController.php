<?php

namespace App\Http\Controllers;

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
        // Estatísticas simuladas para o dashboard
        $stats = [
            'total_users' => rand(100, 500),
            'active_tickets' => rand(5, 50),
            'closed_tickets' => rand(50, 200),
            'avg_response_time' => rand(1, 24) . ' hours'
        ];

        // Atividades recentes simuladas
        $activities = [
            ['user' => 'Admin', 'action' => 'Criou um novo ticket', 'time' => now()->subHours(1)],
            ['user' => 'Operator', 'action' => 'Respondeu ao ticket #123', 'time' => now()->subHours(3)],
            ['user' => 'Client', 'action' => 'Fechou o ticket #456', 'time' => now()->subHours(5)],
            ['user' => 'Admin', 'action' => 'Adicionou um novo usuário', 'time' => now()->subHours(8)],
            ['user' => 'Operator', 'action' => 'Alterou prioridade do ticket #789', 'time' => now()->subHours(12)]
        ];

        // Dados para o gráfico
        $chartData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'datasets' => [
                [
                    'label' => 'Tickets Abertos',
                    'data' => [rand(10, 30), rand(20, 40), rand(15, 35), rand(25, 45), rand(30, 50), rand(20, 40)]
                ],
                [
                    'label' => 'Tickets Fechados',
                    'data' => [rand(5, 20), rand(15, 30), rand(10, 25), rand(20, 35), rand(25, 40), rand(15, 30)]
                ]
            ]
        ];

        return view('dashboard', compact('stats', 'activities', 'chartData'));
    }
}
