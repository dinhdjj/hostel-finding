<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\HostelResource\Pages;
use App\Models\Hostel;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;

class HostelResource extends Resource
{
    protected static ?string $model = Hostel::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('owner_id')
                    ->relationship('owner', 'email')
                    ->searchable(['name', 'email', 'phone_number', 'id_number']),
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                DateTimePicker::make('found_at')
                    ->required(),
                TextInput::make('address')
                    ->required()
                    ->maxLength(255),
                TextInput::make('latitude')
                    ->numeric()
                    ->required(),
                TextInput::make('longitude')
                    ->numeric()
                    ->required(),
                TextInput::make('size')
                    ->numeric()
                    ->required(),
                TextInput::make('monthly_price')
                    ->numeric()
                    ->required(),
                MultiSelect::make('amenities')
                    ->relationship('amenities', 'name')
                    ->searchable(['name']),
                MultiSelect::make('categories')
                    ->relationship('categories', 'name')
                    ->searchable(['name']),
                MarkdownEditor::make('description'),
                SpatieMediaLibraryFileUpload::make('default')
                    ->label('Images')
                    ->multiple()
                    ->enableReordering(),
            ])
        ;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title')
                    ->searchable(),
                BooleanColumn::make('found')
                    ->getStateUsing(fn (Model $record) => $record->found_at->lte(now())),
                TextColumn::make('address')
                    ->searchable(),
                TextColumn::make('size')
                    ->getStateUsing(fn (Model $record) => $record->size.' m²')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('monthly_price')
                    ->getStateUsing(fn (Model $record) => number_format($record->monthly_price, 0, '.', ',').' ₫')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ])
            ->defaultSort('id', 'desc')
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
            'index' => Pages\ListHostels::route('/'),
            'create' => Pages\CreateHostel::route('/create'),
            'view' => Pages\ViewHostel::route('/{record}'),
            'edit' => Pages\EditHostel::route('/{record}/edit'),
        ];
    }
}
