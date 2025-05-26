<?php

namespace App\Enums;

enum  StatusType: string
{
    case DRAFT = 'draft';
    case SCHEDULED = 'scheduled';
    case PUBLISHED = 'published';

    public function color(): string
    {
        return match ($this) {
            Self::DRAFT => 'border-red-500',
            Self::SCHEDULED => 'border-yellow-500',
            Self::PUBLISHED => 'border-green-500'
        };
    }
}
