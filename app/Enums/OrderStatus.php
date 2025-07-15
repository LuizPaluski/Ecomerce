<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;


final class OrderStatus extends Enum
{
    const PENDING = 'pending';
    const PROCESSING = 'processing';
    const COMPLETED = 'completed';
    const CANCELLED = 'cancelled';
    const SHIPPED = 'shipped';

    public function label(): string{
        return match ($this->value){
            self::PENDING => 'Waiting for confirmation',
            self::PROCESSING => 'In progress',
            self::COMPLETED => 'Completed',
            self::CANCELLED => 'Order cancelled',
            self::SHIPPED => 'Shipped',
        };

    }
}
