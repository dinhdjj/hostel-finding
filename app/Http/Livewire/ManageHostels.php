<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Hostel;
use Auth;
use Closure;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;
use Livewire\Component;

class ManageHostels extends Component implements HasTable
{
    use InteractsWithTable;

    public function render(): View
    {
        return view('livewire.manage-hostels');
    }

    protected function getTableQuery(): Builder
    {
        return Hostel::where('owner_id', auth()->id());
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('title')
                ->searchable(),
            BooleanColumn::make('found')
                ->getStateUsing(fn (Hostel $record) => $record->found_at->lte(now())),
            TextColumn::make('address')
                ->searchable(),
            TextColumn::make('score')
                ->avg('votes', 'score')
                ->getStateUsing(fn (Hostel $record) => $record->votes_score * 5 .' ✯'), // @phpstan-ignore-line
            TextColumn::make('size')
                ->getStateUsing(fn (Hostel $record) => $record->size.' m²')
                ->searchable()
                ->sortable(),
            TextColumn::make('monthly_price')
                ->getStateUsing(fn (Hostel $record) => number_format($record->monthly_price, 0, '.', ',').' ₫')
                ->searchable()
                ->sortable(),
            TextColumn::make('updated_at')
                ->getStateUsing(fn (Hostel $record) => $record->updated_at->diffForHumans()),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('edit')
                ->url(fn (Hostel $record): string => route('hostels.edit', $record))
                ->icon('feathericon-edit')
                ->openUrlInNewTab()
                ->visible(fn (Hostel $record): bool => Auth::user()->can('update', $record)),
            DeleteAction::make('delete')
                ->visible(fn (Hostel $record): bool => Auth::user()->can('delete', $record)),
        ];
    }

    protected function getTableBulkActions(): array
    {
        return [];
    }

    protected function getTableFilters(): array
    {
        return [
            TernaryFilter::make('Founded')
                ->nullable()
                ->column('found_at')
                ->queries(
                    true: fn (Builder $query): Builder => $query->where('found_at', '<=', now()),
                    false: fn (Builder $query): Builder => $query->where('found_at', '>', now()),
                ),
        ];
    }

    protected function getTableRecordUrlUsing(): Closure
    {
        return fn (Model $record): string => route('hostels.show', ['hostel' => $record]);
    }

    protected function getTableEmptyStateIcon(): ?string
    {
        return 'heroicon-o-bookmark';
    }

    protected function getTableEmptyStateHeading(): ?string
    {
        return 'No posts yet';
    }

    protected function getTableEmptyStateDescription(): ?string
    {
        return 'You may create a post using the button below.';
    }

    protected function getTableEmptyStateActions(): array
    {
        return [
            Action::make('create')
                ->label('Create post')
                ->url(route('hostels.create'))
                ->icon('heroicon-o-plus')
                ->button(),
        ];
    }
}
