<?php

declare(strict_types=1);

namespace App\Filament\Resources\MyHostelResource\Pages;

use App\Filament\Resources\MyHostelResource;
use App\Filament\Resources\MyHostelResource\Widgets\StatsOverview;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHostels extends ListRecords
{
    protected static string $resource = MyHostelResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }
}
