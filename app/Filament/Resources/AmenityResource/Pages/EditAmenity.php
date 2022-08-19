<?php

declare(strict_types=1);

namespace App\Filament\Resources\AmenityResource\Pages;

use App\Filament\Resources\AmenityResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAmenity extends EditRecord
{
    protected static string $resource = AmenityResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
