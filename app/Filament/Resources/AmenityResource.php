<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\AmenityResource\Pages;
use App\Filament\Traits\Localizable;
use App\Models\Amenity;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class AmenityResource extends Resource
{
    use Localizable;

    protected static ?string $model = Amenity::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationGroup = 'Related Hostel';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
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
                TextColumn::make('name')
                    ->localizeLabel(),
                TextColumn::make('description')
                    ->localizeLabel(),
                TextColumn::make('updated_at')
                    ->getStateUsing(fn (Amenity $record) => $record->updated_at->diffForHumans())
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
            'index' => Pages\ListAmenities::route('/'),
            'create' => Pages\CreateAmenity::route('/create'),
            'view' => Pages\ViewAmenity::route('/{record}'),
            'edit' => Pages\EditAmenity::route('/{record}/edit'),
        ];
    }
}
