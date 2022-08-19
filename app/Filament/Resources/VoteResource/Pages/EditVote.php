<?php

declare(strict_types=1);

namespace App\Filament\Resources\VoteResource\Pages;

use App\Filament\Resources\VoteResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVote extends EditRecord
{
    protected static string $resource = VoteResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
