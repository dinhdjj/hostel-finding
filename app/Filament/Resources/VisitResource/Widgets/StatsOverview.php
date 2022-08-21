<?php

declare(strict_types=1);

namespace App\Filament\Resources\VisitResource\Widgets;

use App\Models\Visit;
use Dinhdjj\FilamentModelWidgets\Stats\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        /** @var Builder */
        $query = Visit::query()->distinct('ip');

        return [
            Card::query(Visit::whereVisitorId(null), now()->subMonth(), now())
                ->cache()
                ->count(label: 'New visits of guests'),
            Card::query(Visit::where('visitor_id', '!=', null), now()->subMonth(), now())
                ->cache()
                ->count(label: 'New visits of users'),
            Card::query($query, now()->subMonth(), now())
                ->cache()
                ->count(label: 'New unique IPs'),
        ];
    }
}
