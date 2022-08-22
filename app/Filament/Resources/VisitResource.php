<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\VisitResource\Pages;
use App\Filament\Traits\Localizable;
use App\Models\Visit;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;

class VisitResource extends Resource
{
    use Localizable;

    protected static ?string $model = Visit::class;

    protected static ?string $navigationIcon = 'heroicon-o-eye';

    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.groups.system');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('visitable.title')
                    ->label('Hostel')
                    ->localizeLabel(),
                TextColumn::make('visitor.email')
                    ->localizeLabel(),
                TextColumn::make('updated_at')
                    ->getStateUsing(fn (Visit $record) => $record->updated_at->diffForHumans())
                    ->localizeLabel(),
                TextColumn::make('ip')
                    ->localizeLabel(),
                TextColumn::make('languages')
                    ->localizeLabel(),
                TextColumn::make('device')
                    ->localizeLabel(),
                TextColumn::make('platform')
                    ->localizeLabel(),
                TextColumn::make('browser')
                    ->localizeLabel(),
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
