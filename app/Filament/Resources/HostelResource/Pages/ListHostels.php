<?php

declare(strict_types=1);

namespace App\Filament\Resources\HostelResource\Pages;

use App\Filament\Resources\HostelResource;
use App\Filament\Resources\HostelResource\Widgets\StatsOverview;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHostels extends ListRecords
{
    protected static string $resource = HostelResource::class;

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
