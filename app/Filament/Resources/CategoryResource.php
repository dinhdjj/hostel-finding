<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Traits\Localizable;
use App\Models\Category;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class CategoryResource extends Resource
{
    use Localizable;

    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-hashtag';

    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.groups.hostel');
    }

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
                    ->getStateUsing(fn (Category $record) => $record->updated_at->diffForHumans())
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'view' => Pages\ViewCategory::route('/{record}'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
