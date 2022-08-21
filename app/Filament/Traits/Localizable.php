<?php

declare(strict_types=1);

namespace App\Filament\Traits;

trait Localizable
{
    public static function getModelLabel(): string
    {
        return __(parent::getModelLabel());
    }

    public static function getPluralModelLabel(): string
    {
        return __(parent::getPluralModelLabel());
    }
}
