<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\HostelSearchRequest;
use Illuminate\View\View;

class HostelSearchController extends Controller
{
    public function __invoke(HostelSearchRequest $request): View
    {
        return view('hostels.search', [
            'latitude' => (float) $request->latitude,
            'longitude' => (float) $request->longitude,
        ]);
    }
}
