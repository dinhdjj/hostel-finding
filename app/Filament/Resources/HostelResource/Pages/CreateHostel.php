<?php

declare(strict_types=1);

namespace App\Filament\Resources\HostelResource\Pages;

use App\Filament\Resources\HostelResource;
use Filament\Resources\Pages\CreateRecord;

class CreateHostel extends CreateRecord
{
    protected static string $resource = HostelResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['owner_id'] = auth()->id();

        return $data;
    }
}
