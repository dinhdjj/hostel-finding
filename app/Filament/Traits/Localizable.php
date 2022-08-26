<?php

declare(strict_types=1);

namespace App\Filament\Traits;

use Str;

trait Localizable
{
    public static function getModelLabel(): string
    {
        return __('models.'.parent::getModelLabel());
    }

    public static function getPluralModelLabel(): string
    {
        return __('models.'.Str::plural(parent::getModelLabel()));
    }
}
