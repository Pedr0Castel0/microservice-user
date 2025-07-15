<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case PENDENTE = 'pendente';
    case PAGO = 'pago';

    public function label(): string
    {
        return match ($this) {
            self::PENDENTE => 'Pendente',
            self::PAGO => 'Pago',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }
        return $options;
    }
}
