<?php

namespace App\Enums;

enum SpiceLevel: string
{
    case SUAVE = 'Suave';
    case MEDIO = 'Médio';
    case PICANTE = 'Picante';
    case MUITO_PICANTE = 'Muito Picante';

    public function label(): string
    {
        return $this->value;
    }

    public function icon(): string
    {
        return match ($this) {
            self::SUAVE => '🟢',
            self::MEDIO => '🟡',
            self::PICANTE => '🟠',
            self::MUITO_PICANTE => '🔴',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::SUAVE => 'Tempero suave, sem ardência',
            self::MEDIO => 'Tempero médio, levemente picante',
            self::PICANTE => 'Tempero picante, bem apimentado',
            self::MUITO_PICANTE => 'Tempero muito picante, para quem gosta de pimenta forte',
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
