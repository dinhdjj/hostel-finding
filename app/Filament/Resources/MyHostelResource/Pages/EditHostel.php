<?php

declare(strict_types=1);

namespace App\Filament\Resources\MyHostelResource\Pages;

use App\Filament\Resources\MyHostelResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHostel extends EditRecord
{
    protected static string $resource = MyHostelResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
