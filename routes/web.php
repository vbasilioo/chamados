<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketCommentController;
use App\Http\Controllers\UserController;
use App\Models\User;
use App\Models\Ticket;
use Carbon\Carbon;

Route::get('/', function () {
    return view('welcome');
});

// Rotas de autenticação
Route::middleware('guest')->group(function () {
    Route::get('login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
    Route::get('register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);
});

// Rotas protegidas por autenticação
Route::middleware('auth')->group(function () {
    Route::post('logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', function () {
        // Estatísticas
        $stats = [
            'total_users' => User::count(),
            'active_tickets' => Ticket::whereNotIn('status', ['closed', 'resolved'])->count(),
            'closed_tickets' => Ticket::whereIn('status', ['closed', 'resolved'])->count(),
            'avg_response_time' => '2h 34m', // Valor estático para demonstração
        ];
        
        // Dados para o gráfico
        $months = collect(['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun']); 
        $chartData = [
            'labels' => $months,
            'datasets' => [
                [
                    'label' => 'Novos Tickets',
                    'data' => [15, 20, 18, 22, 16, 25],
                ],
                [
                    'label' => 'Tickets Resolvidos',
                    'data' => [10, 15, 16, 18, 15, 22],
                ]
            ]
        ];
        
        // Atividades recentes - apenas para demonstração
        $activities = [
            [
                'user' => 'Admin',
                'action' => 'Respondeu ao chamado #123',
                'time' => Carbon::now()->subHours(2),
            ],
            [
                'user' => 'Operador',
                'action' => 'Atualizou o status do chamado #122 para "Resolvido"',
                'time' => Carbon::now()->subHours(5),
            ],
            [
                'user' => 'Usuário',
                'action' => 'Criou um novo chamado #124',
                'time' => Carbon::now()->subHours(8),
            ],
        ];
        
        return view('dashboard', compact('stats', 'chartData', 'activities'));
    })->name('dashboard');
    
    // Rota de perfil
    Route::get('/profile', function () {
        return view('profile.show');
    })->name('profile.show');
    
    // Rotas de chamados
    Route::resource('tickets', TicketController::class);
    Route::post('tickets/{ticket}/comments', [TicketCommentController::class, 'store'])->name('tickets.comments.store');
    
    // Rotas de usuários (admin)
    Route::resource('users', UserController::class);
});
