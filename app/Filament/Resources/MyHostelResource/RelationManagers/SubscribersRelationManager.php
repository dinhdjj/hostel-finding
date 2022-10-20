<?php

declare(strict_types=1);

namespace App\Filament\Resources\MyHostelResource\RelationManagers;

use App\Filament\Traits\Localizable;
use App\Models\User;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class SubscribersRelationManager extends RelationManager
{
    use Localizable;

    protected static string $relationship = 'subscribers';

    protected static ?string $recordTitleAttribute = 'name';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->localizeLabel(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->localizeLabel(),
                Tables\Columns\BooleanColumn::make('active')
                    ->label('Đã đọc'),
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Action::make('active')
                    ->label(__('Đánh dấu đã đọc'))
                    ->visible(fn (User $record) => ! $record->pivot->active)
                    ->action(fn (User $record) => $record->pivot->update(['active' => true]))
                    ->requiresConfirmation()
                    ->icon('heroicon-o-check-circle')
                    ->color('success'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
        ;
    }

    public static function canViewForRecord(Model $ownerRecord): bool
    {
        return $ownerRecord->owner_id === auth()->id();
    }

    protected function canCreate(): bool
    {
        return false;
    }

    protected function canEdit(Model $record): bool
    {
        return false;
    }
}
