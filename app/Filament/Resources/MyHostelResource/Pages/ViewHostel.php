<?php

declare(strict_types=1);

namespace App\Filament\Resources\MyHostelResource\Pages;

use App\Filament\Resources\MyHostelResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewHostel extends ViewRecord
{
    protected static string $resource = MyHostelResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
