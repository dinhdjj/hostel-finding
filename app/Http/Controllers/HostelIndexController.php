<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Hostel;
use Illuminate\Http\Request;

class HostelIndexController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $trendingHostel = Hostel::with(['owner', 'categories'])
            ->withAggregate('votes', 'score')
            ->withCount('visitLogs')
            ->orderByVisitLogsCount()
            ->whereNotNull('found_at')
            ->paginate(12)
        ;

        return view('hostels.index', [
            'trendingHostel' => $trendingHostel,
        ]);
    }
}
