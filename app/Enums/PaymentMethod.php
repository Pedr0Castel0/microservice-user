<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case DINHEIRO = 'dinheiro';
    case PIX = 'pix';
    case CARTAO_DEBITO = 'cartao_debito';
    case CARTAO_CREDITO = 'cartao_credito';

    public function label(): string
    {
        return match ($this) {
            self::DINHEIRO => 'Dinheiro',
            self::PIX => 'PIX',
            self::CARTAO_DEBITO => 'Cartão de Débito',
            self::CARTAO_CREDITO => 'Cartão de Crédito',
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
