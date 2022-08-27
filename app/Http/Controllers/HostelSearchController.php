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
            'address' => $request->input('address'),
            'north' => (float) $request->input('north'),
            'south' => (float) $request->input('south'),
            'west' => (float) $request->input('west'),
            'east' => (float) $request->input('east'),
        ]);
    }
}
