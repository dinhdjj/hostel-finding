<?php

declare(strict_types=1);

namespace App\Filament\Resources\AmenityResource\Pages;

use App\Filament\Resources\AmenityResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAmenities extends ListRecords
{
    protected static string $resource = AmenityResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
