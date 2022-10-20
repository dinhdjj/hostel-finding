<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\HostelResource\Pages;
use App\Filament\Resources\HostelResource\RelationManagers\CommentsRelationManager;
use App\Filament\Resources\HostelResource\RelationManagers\SubscribersRelationManager;
use App\Filament\Resources\HostelResource\RelationManagers\VotesRelationManager;
use App\Filament\Traits\Localizable;
use App\Forms\Components\GoogleMapSelector;
use App\Models\Hostel;
use Closure;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class HostelResource extends Resource
{
    use Localizable;

    protected static ?string $model = Hostel::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';

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
                    ->searchable(['name', 'email', 'phone_number', 'id_number'])
                    ->disabled()
                    ->visibleOn(['edit', 'view'])
                    ->required()
                    ->localizeLabel(),
                TextInput::make('title')
                    ->reactive()
                    ->required()
                    ->maxLength(255)
                    ->localizeLabel(),
                DateTimePicker::make('found_at')
                    ->required()
                    ->hint('Đến thời gian này phòng trọ tự động được đánh dấu là đã tìm thấy người thuê')
                    ->localizeLabel(),
                GoogleMapSelector::make('coordinates')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn (array $state, Closure $set) => $set('address', $state['address']))
                    ->columnSpan([
                        'default' => 1,
                        'lg' => 2,
                    ])
                    ->localizeLabel(),
                TextInput::make('address')
                    ->required()
                    ->maxLength(255)
                    ->localizeLabel(),
                TextInput::make('size')
                    ->numeric()
                    ->required()
                    ->localizeLabel(),
                TextInput::make('monthly_price')
                    ->numeric()
                    ->required()
                    ->localizeLabel(),
                TextInput::make('allowable_number_of_people')
                    ->numeric()
                    ->required()
                    ->localizeLabel(),
                MultiSelect::make('amenities')
                    ->relationship('amenities', 'name')
                    ->preload()
                    ->searchable(['name'])
                    ->localizeLabel(),
                MultiSelect::make('categories')
                    ->relationship('categories', 'name')
                    ->preload()
                    ->searchable(['name'])
                    ->localizeLabel(),
                MarkdownEditor::make('description')
                    ->columnSpan([
                        'default' => 1,
                        'lg' => 2,
                    ])
                    ->localizeLabel(),
                SpatieMediaLibraryFileUpload::make('default')
                    ->label('Images')
                    ->multiple()
                    ->enableReordering()
                    ->minFiles(5)
                    ->columnSpan([
                        'default' => 1,
                        'lg' => 2,
                    ])
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
                TextColumn::make('title')
                    ->searchable()
                    ->localizeLabel(),
                BooleanColumn::make('found')
                    ->getStateUsing(fn (Model $record) => $record->found_at->lte(now()))
                    ->localizeLabel(),
                TextColumn::make('address')
                    ->searchable()
                    ->localizeLabel(),
                TextColumn::make('votes_score')
                    ->avg('votes', 'score')
                    ->getStateUsing(fn (Hostel $record) => ceil($record->votes_score * 5).' ✯')
                    ->localizeLabel(),
                TextColumn::make('size')
                    ->getStateUsing(fn (Model $record) => $record->size.' m²')
                    ->searchable()
                    ->sortable()
                    ->localizeLabel(),
                TextColumn::make('monthly_price')
                    ->getStateUsing(fn (Model $record) => number_format($record->monthly_price, 0, '.', ',').' ₫')
                    ->searchable()
                    ->sortable()
                    ->localizeLabel(),
                TextColumn::make('updated_at')
                    ->getStateUsing(fn (Hostel $record) => $record->updated_at->diffForHumans())
                    ->localizeLabel(),
            ])
            ->filters([
                TernaryFilter::make('Founded')
                    ->nullable()
                    ->column('found_at')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->where('found_at', '<=', now()),
                        false: fn (Builder $query): Builder => $query->where('found_at', '>', now()),
                    ),
            ])
            ->actions([
                Action::make('activate')
                    ->label(__('Tìm thấy'))
                    ->visible(fn (Hostel $record) => ! $record->found_at->lt(now()))
                    ->action(fn (Hostel $record) => $record->update(['found_at' => now()]))
                    ->requiresConfirmation()
                    ->icon('heroicon-o-check-circle')
                    ->color('success'),
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
            SubscribersRelationManager::class,
            CommentsRelationManager::class,
            VotesRelationManager::class,
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
