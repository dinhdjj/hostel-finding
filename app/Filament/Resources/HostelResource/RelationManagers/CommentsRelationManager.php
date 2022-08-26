<?php

declare(strict_types=1);

namespace App\Filament\Resources\HostelResource\RelationManagers;

use App\Filament\Resources\CommentResource;
use App\Filament\Traits\Localizable;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables\Actions\CreateAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class CommentsRelationManager extends RelationManager
{
    use Localizable;

    protected static string $relationship = 'comments';

    protected static ?string $recordTitleAttribute = 'content';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                MarkdownEditor::make('content')
                    ->required()
                    ->maxLength(255),
            ])
        ;
    }

    public static function table(Table $table): Table
    {
        return CommentResource::table($table)
            ->headerActions([
                CreateAction::make()
                    ->mutateFormDataUsing(function (array $data) {
                        $data['owner_id'] = auth()->id();

                        return $data;
                    }),
            ])
        ;
    }

    protected function getTableQuery(): Builder|Relation
    {
        return parent::getTableQuery()
            ->with('owner')
        ;
    }

    protected function canCreate(): bool
    {
        return auth()->user()->can('create', [Comment::class, $this->getOwnerRecord()]);
    }
}
