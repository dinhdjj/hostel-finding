<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\VoteResource\Pages;
use App\Filament\Traits\Localizable;
use App\Models\Vote;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class VoteResource extends Resource
{
    use Localizable;

    protected static ?string $model = Vote::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.groups.hostel');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('owner_id')
                    ->relationship('owner', 'email')
                    ->disabled()
                    ->required()
                    ->visibleOn(['edit', 'view'])
                    ->localizeLabel(),
                Select::make('hostel_id')
                    ->relationship('hostel', 'title')
                    ->disabled()
                    ->required()
                    ->localizeLabel(),
                Select::make('score')
                    ->options([
                        '1' => '1 ✯',
                        '2' => '2 ✯',
                        '3' => '3 ✯',
                        '4' => '4 ✯',
                        '5' => '5 ✯',
                    ])
                    ->required()
                    ->localizeLabel(),
                MarkdownEditor::make('description')
                    ->maxLength(255)
                    ->localizeLabel(),
            ])
        ;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('owner.name')
                    ->localizeLabel(),
                TextColumn::make('hostel.title')
                    ->localizeLabel(),
                TextColumn::make('score')
                    ->getStateUsing(fn (Vote $record) => $record->score * 5 .' ✯')
                    ->localizeLabel(),
                TextColumn::make('description')
                    ->localizeLabel(),
                TextColumn::make('updated_at')
                    ->getStateUsing(fn (Vote $record) => $record->updated_at->diffForHumans())
                    ->localizeLabel(),
            ])
            ->filters([
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListVotes::route('/'),
            'view' => Pages\ViewVote::route('/{record}'),
            'edit' => Pages\EditVote::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
