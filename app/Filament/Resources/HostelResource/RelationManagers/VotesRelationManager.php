<?php

declare(strict_types=1);

namespace App\Filament\Resources\HostelResource\RelationManagers;

use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class VotesRelationManager extends RelationManager
{
    protected static string $relationship = 'votes';

    protected static ?string $recordTitleAttribute = 'description';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('score')
                    ->numeric()
                    ->maxValue(1)
                    ->minValue(0)
                    ->required(),
                MarkdownEditor::make('description')
                    ->maxLength(255),
            ])
        ;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('owner.name'),
                TextColumn::make('score'),
                TextColumn::make('description'),
                TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data) {
                        $data['owner_id'] = auth()->id();

                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
        ;
    }

    protected function canCreate(): bool
    {
        return auth()->user()->can('create', [Vote::class, $this->getOwnerRecord()]);
    }
}
