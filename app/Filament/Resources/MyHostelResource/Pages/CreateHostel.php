<?php

declare(strict_types=1);

namespace App\Filament\Resources\MyHostelResource\Pages;

use App\Filament\Resources\MyHostelResource;
use Filament\Resources\Pages\CreateRecord;

class CreateHostel extends CreateRecord
{
    protected static string $resource = MyHostelResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['owner_id'] = auth()->id();

        return $data;
    }
}
