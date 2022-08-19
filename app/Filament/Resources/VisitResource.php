<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\VisitResource\Pages;
use App\Models\Visit;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;

class VisitResource extends Resource
{
    protected static ?string $model = Visit::class;

    protected static ?string $navigationIcon = 'heroicon-o-eye';

    protected static ?string $navigationGroup = 'System';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('visitable.title')
                    ->label('Hostel'),
                TextColumn::make('visitor.email'),
                TextColumn::make('updated_at')
                    ->getStateUsing(fn (Visit $record) => $record->updated_at->diffForHumans()),
                TextColumn::make('ip'),
                TextColumn::make('languages'),
                TextColumn::make('device'),
                TextColumn::make('platform'),
                TextColumn::make('browser'),
            ])
        ;
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVisits::route('/'),
        ];
    }
}
