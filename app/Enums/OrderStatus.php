<?php

namespace App\Enums;

enum OrderStatus: string
{
    case CONFIRMADO = 'confirmado';
    case EM_PREPARO = 'em_preparo';
    case SAIU_ENTREGA = 'saiu_entrega';
    case ENTREGUE = 'entregue';

    public function label(): string
    {
        return match ($this) {
            self::CONFIRMADO => 'Confirmado',
            self::EM_PREPARO => 'Em Preparo',
            self::SAIU_ENTREGA => 'Saiu para Entrega',
            self::ENTREGUE => 'Entregue',
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
