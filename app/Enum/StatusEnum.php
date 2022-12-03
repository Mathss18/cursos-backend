<?php

namespace App\Enum;

final class StatusEnum
{
    public const ACTIVE   = 1;
    public const INACTIVE = 0;
    public const DELETED  = 3;

    public function getAll(): array
    {
        return [
            self::ACTIVE,
            self::INACTIVE,
            self::DELETED
        ];
    }

    public static function getAllWithLabel(): array
    {
        return [
            'active' => self::ACTIVE,
            'inactive' => self::INACTIVE,
            'deleted' => self::DELETED
        ];
    }
}
