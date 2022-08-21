<?php

declare(strict_types=1);

namespace App\Filament\Resources\VoteResource\Pages;

use App\Filament\Resources\VoteResource;
use App\Filament\Resources\VoteResource\Widgets\StatsOverview;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVotes extends ListRecords
{
    protected static string $resource = VoteResource::class;

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
