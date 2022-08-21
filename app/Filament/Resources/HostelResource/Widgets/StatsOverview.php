<?php

declare(strict_types=1);

namespace App\Filament\Resources\HostelResource\Widgets;

use App\Models\Hostel;
use Dinhdjj\FilamentModelWidgets\Stats\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::model(Hostel::class, now()->subMonth(), now())
                ->cache()
                ->count(label: 'New hostels'),
            Card::query(Hostel::where('found_at', '<=', now()), now()->subMonth(), now())
                ->cache()
                ->count(label: 'Hostels Found'),
            Card::model(Hostel::class, now()->subMonth(), now())
                ->cache()
                ->average('monthly_price', label: 'Monthly Price Trend', displaceValue: fn (int $value) => number_format($value).'₫'),
        ];
    }
}
