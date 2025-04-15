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
use Spatie\Permission\Models\Role;

Route::get('/', function () {
    return view('welcome');
});

// Rota temporária para verificar papéis do usuário
Route::get('/check-roles', function () {
    $user = Auth::user();
    if ($user) {
        return [
            'user' => $user->name,
            'roles' => $user->getRoleNames(),
            'permissions' => $user->getAllPermissions()->pluck('name'),
        ];
    }
    return "Usuário não autenticado.";
})->middleware('auth');

// Rota temporária para atribuir papel de admin
Route::get('/setup-admin', function () {
    $user = Auth::user();
    if ($user) {
        $adminRole = Role::findByName('admin');
        $user->assignRole($adminRole);
        return "Papel de admin atribuído com sucesso!";
    }
    return "Usuário não autenticado.";
})->middleware('auth');

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
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Rota de perfil
    Route::get('/profile', function () {
        return view('profile.show');
    })->name('profile.show');
    
    // Rotas de chamados
    Route::resource('tickets', TicketController::class);
    Route::post('tickets/{ticket}/accept', [TicketController::class, 'accept'])->name('tickets.accept');
    Route::post('tickets/{ticket}/comments', [TicketCommentController::class, 'store'])->name('tickets.comments.store');
    
    // Rotas de usuários (admin)
    Route::middleware('permission:manage users')->group(function () {
        Route::resource('users', UserController::class);
    });
});
