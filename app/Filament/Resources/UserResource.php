<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Traits\Localizable;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserResource extends Resource
{
    use Localizable;

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.groups.system');
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Email' => $record->email,
            'Phone' => $record->phone_number,
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email', 'phone_number', 'id_number'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->localizeLabel(),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->localizeLabel(),
                DateTimePicker::make('email_verified_at')
                    ->localizeLabel(),
                TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => 'create' === $context)
                    ->maxLength(255)
                    ->localizeLabel(),
                TextInput::make('id_number')
                    ->required()
                    ->maxLength(255)
                    ->localizeLabel(),
                TextInput::make('phone_number')
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
                TextColumn::make('name')
                    ->searchable()
                    ->localizeLabel(),
                TextColumn::make('email')
                    ->searchable()
                    ->localizeLabel(),
                TextColumn::make('phone_number')
                    ->searchable()
                    ->localizeLabel(),
                TextColumn::make('id_number')
                    ->searchable()
                    ->localizeLabel(),
                BooleanColumn::make('email_verified_at')
                    ->label('Email verified')
                    ->localizeLabel(),
                TextColumn::make('updated_at')
                    ->getStateUsing(fn (User $record) => $record->updated_at->diffForHumans())
                    ->localizeLabel(),
            ])
            ->filters([
                Filter::make('Email Verified')
                    ->query(fn (Builder $query): Builder => $query->where('email_verified_at', '<=', now())),
            ])
            ->actions([
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
