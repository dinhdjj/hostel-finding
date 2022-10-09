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
use Illuminate\View\View;
use Livewire\Component;

class ManageHostels extends Component implements HasTable
{
    use InteractsWithTable;

    public function render(): View
    {
        return view('livewire.manage-hostels');
    }

    public function found(Hostel $hostel): void
    {
        $hostel->update(['found_at' => now()]);
    }

    protected function getTableQuery(): Builder
    {
        $hostel = Hostel::where('owner_id', auth()->id());
        $hostel->withAvg('votes', 'score');

        return $hostel;
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('title')
                ->label('Tiêu đề')
                ->searchable(),
            BooleanColumn::make('found')
                ->label('Tìm thấy')
                ->getStateUsing(fn (Hostel $record) => $record->found_at->lte(now())),
            TextColumn::make('address')
                ->label('Địa chỉ')
                ->searchable(),
            TextColumn::make('score')
                ->label('Điểm')
                ->avg('votes', 'score')
                ->getStateUsing(fn (Hostel $record) => $record->votes_avg_score * 5 .' ✯'), // @phpstan-ignore-line
            TextColumn::make('size')
                ->label('Kích thước')
                ->getStateUsing(fn (Hostel $record) => $record->size.' m²')
                ->searchable()
                ->sortable(),
            TextColumn::make('monthly_price')
                ->label('Giá mỗi tháng')
                ->getStateUsing(fn (Hostel $record) => number_format($record->monthly_price, 0, '.', ',').' ₫')
                ->searchable()
                ->sortable(),
            TextColumn::make('allowable_number_of_people')
                ->label('Số người ở')
                ->getStateUsing(fn (Hostel $record) => $record->allowable_number_of_people.' người')
                ->searchable()
                ->sortable(),
            TextColumn::make('updated_at')
                ->label('Cập nhật')
                ->getStateUsing(fn (Hostel $record) => $record->updated_at->diffForHumans()),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('edit')
                ->label('Sửa')
                ->url(fn (Hostel $record): string => route('hostels.edit', $record))
                ->icon('feathericon-edit')
                ->openUrlInNewTab()
                ->visible(fn (Hostel $record): bool => Auth::user()->can('update', $record)),
            Action::make('found')
                ->label('')
                ->icon('feathericon-check')
                ->action(function (Hostel $record): void {
                    $record->update(['found_at' => now()]);
                })
                ->visible(fn (Hostel $record): bool => Auth::user()->can('update', $record)),
            DeleteAction::make('delete')
                ->label('Xóa')
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
        return fn (Hostel $record): string => route('hostels.show', ['hostel' => $record]);
    }

    protected function getTableEmptyStateIcon(): ?string
    {
        return 'heroicon-o-bookmark';
    }

    protected function getTableEmptyStateHeading(): ?string
    {
        return 'Bạn chưa có nhà trọ nào';
    }

    protected function getTableEmptyStateDescription(): ?string
    {
        return 'Bạn có thể tạo nhà trọ mới bằng cách nhấn vào nút bên dưới';
    }

    protected function getTableEmptyStateActions(): array
    {
        return [
            Action::make('create')
                ->label('Tạo mới nhà trọ')
                ->url(route('hostels.create'))
                ->icon('heroicon-o-plus')
                ->button(),
        ];
    }
}
