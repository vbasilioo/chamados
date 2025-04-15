<?php

namespace App\Enums;

enum TicketStatus: string
{
    case OPEN = 'open';
    case IN_PROGRESS = 'in_progress';
    case PENDING = 'pending';
    case RESOLVED = 'resolved';
    case CLOSED = 'closed';

    public function label(): string
    {
        return match($this) {
            self::OPEN => 'Aberto',
            self::IN_PROGRESS => 'Em Andamento',
            self::PENDING => 'Pendente',
            self::RESOLVED => 'Resolvido',
            self::CLOSED => 'Fechado',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::OPEN => 'bg-green-100 text-green-800',
            self::IN_PROGRESS => 'bg-blue-100 text-blue-800',
            self::PENDING => 'bg-yellow-100 text-yellow-800',
            self::RESOLVED => 'bg-purple-100 text-purple-800',
            self::CLOSED => 'bg-gray-100 text-gray-800',
        };
    }
} 