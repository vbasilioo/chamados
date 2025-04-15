<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // Todos usuários autenticados podem ver a lista de tickets
    }

    public function view(User $user, Ticket $ticket): bool
    {
        return $user->hasRole('admin') || 
               $ticket->user_id === $user->id || 
               $ticket->assigned_to === $user->id;
    }

    public function create(User $user): bool
    {
        return true; // Todos usuários autenticados podem criar tickets
    }

    public function update(User $user, Ticket $ticket): bool
    {
        return $user->hasRole('admin') || 
               $ticket->assigned_to === $user->id;
    }

    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->hasRole('admin');
    }

    public function assign(User $user, Ticket $ticket): bool
    {
        return $user->hasRole('admin');
    }

    public function changeStatus(User $user, Ticket $ticket): bool
    {
        return $user->hasRole('admin') || 
               $ticket->assigned_to === $user->id;
    }
} 