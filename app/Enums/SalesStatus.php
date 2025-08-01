<?php

namespace App\Enums;

enum SalesStatus: int
{
    // case SuperAdmin = 'super_admin';
    case Aguardando = 0;
    case Pago = 1;
    case Pessoal = 2;

    public function badgeClass(): string
    {
        return match ($this) {
            self::Aguardando => 'badge-warning',
            self::Pago => 'badge-success',
            self::Pessoal => 'badge-info',
        };
    }
    public function dbName(): string
    {
        return match ($this) {
            self::Aguardando => 'Aguardando...',
            self::Pago => 'Pago',
            self::Pessoal => 'Pessoal',
        };
    }
}
