<?php

declare(strict_types=1);

namespace App\Filament\Resources\VoteResource\Widgets;

use App\Models\Vote;
use Dinhdjj\FilamentModelWidgets\Stats\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::model(Vote::class, now()->subMonth(), now())
                ->cache()
                ->count(label: __('stats.vote.count.*')),
            Card::model(Vote::class, now()->subMonth(), now())
                ->cache()
                ->average('score', __('stats.vote.average.score'), displaceValue: fn ($value) => number_format($value * 5, 1).' ✯'),
        ];
    }
}
