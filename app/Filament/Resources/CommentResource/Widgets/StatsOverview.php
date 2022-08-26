<?php

declare(strict_types=1);

namespace App\Filament\Resources\CommentResource\Widgets;

use App\Models\Comment;
use Dinhdjj\FilamentModelWidgets\Stats\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::model(Comment::class, now()->subMonth(), now())
                ->cache()
                ->count(label: __('stats.comment.count.*')),
        ];
    }
}
