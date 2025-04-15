<?php

namespace App\Enums;

enum TicketPriority: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
    case URGENT = 'urgent';

    public function label(): string
    {
        return match($this) {
            self::LOW => 'Baixa',
            self::MEDIUM => 'Média',
            self::HIGH => 'Alta',
            self::URGENT => 'Urgente',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::LOW => 'bg-gray-100 text-gray-800',
            self::MEDIUM => 'bg-blue-100 text-blue-800',
            self::HIGH => 'bg-orange-100 text-orange-800',
            self::URGENT => 'bg-red-100 text-red-800',
        };
    }
} 