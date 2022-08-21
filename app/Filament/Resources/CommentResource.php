<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Filament\Traits\Localizable;
use App\Models\Comment;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class CommentResource extends Resource
{
    use Localizable;

    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-alt-2';

    protected static ?string $navigationGroup = 'Related Hostel';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('owner_id')
                    ->relationship('owner', 'email')
                    ->searchable(['name', 'email', 'phone_number', 'id_number', 'id'])
                    ->required()
                    ->disabled()
                    ->visibleOn(['edit', 'view'])
                    ->localizeLabel(),
                Select::make('hostel_id')
                    ->relationship('hostel', 'title')
                    ->searchable(['title', 'description', 'id'])
                    ->required()
                    ->disabled()
                    ->localizeLabel(),
                MarkdownEditor::make('content')
                    ->required()
                    ->maxLength(255)
                    ->localizeLabel(),
            ])
        ;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->searchable()
                    ->sortable()
                    ->localizeLabel(),
                TextColumn::make('content')
                    ->searchable()
                    ->sortable()
                    ->localizeLabel(),
                TextColumn::make('owner.name')
                    ->localizeLabel(),
                TextColumn::make('updated_at')
                    ->getStateUsing(fn (Comment $record) => $record->updated_at->diffForHumans())
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
            'index' => Pages\ListComments::route('/'),
            'view' => Pages\ViewComment::route('/{record}'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
