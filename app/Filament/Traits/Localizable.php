<?php

declare(strict_types=1);

namespace App\Filament\Traits;

use ReflectionClass;
use Str;

trait Localizable
{
    public static function getModelLabel(): string
    {
        $model = new ReflectionClass(static::getModel());

        return __('models.'.lcfirst($model->getShortName()));
    }

    public static function getPluralModelLabel(): string
    {
        $model = new ReflectionClass(static::getModel());

        return __('models.'.Str::plural(lcfirst($model->getShortName())));
    }
}
