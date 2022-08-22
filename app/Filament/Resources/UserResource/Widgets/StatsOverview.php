<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Dinhdjj\FilamentModelWidgets\Stats\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::query(User::whereHas('hostels', operator: '<'), now()->subMonth(), now())
                ->cache()
                ->count(label: __('stats.user.count.*.no_hostel')),
            Card::query(User::whereHas('hostels'), now()->subMonth(), now())
                ->cache()
                ->count(label: __('stats.user.count.*.has_hostel')),
        ];
    }
}
