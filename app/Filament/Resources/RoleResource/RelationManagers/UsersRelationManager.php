<?php

declare(strict_types=1);

namespace App\Filament\Resources\RoleResource\RelationManagers;

use App\Filament\Resources\UserResource;
use App\Filament\Traits\Localizable;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DetachBulkAction;

class UsersRelationManager extends RelationManager
{
    use Localizable;

    protected static string $relationship = 'users';

    protected static ?string $recordTitleAttribute = 'email';

    public static function form(Form $form): Form
    {
        return UserResource::form($form);
    }

    public static function table(Table $table): Table
    {
        return UserResource::table($table)
            ->headerActions([
                CreateAction::make(),
                AttachAction::make(),
            ])
            ->bulkActions([
                DetachBulkAction::make(),
            ])
        ;
    }
}
