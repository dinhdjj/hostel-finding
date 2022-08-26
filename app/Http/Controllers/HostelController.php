<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Hostel;
use Illuminate\View\View;

class HostelController extends Controller
{
    public function show(Hostel $hostel): View
    {
        $hostel->loadAggregate('votes', 'score', 'avg')->loadCount('votes', 'comments');
        $hostel->comments->load('owner', 'parent', 'children');
        $comments = $hostel->comments;
        foreach ($comments as $comment) {
            $comment->children->load('owner', 'parent', 'children');
        }

        return view('hostels.show', [
            'hostel' => $hostel,
        ]);
    }

    public function hosting(): View
    {
        return view('hostels.hosting');
    }

    public function manage(): View
    {
        return view('hostels.manage');
    }

    public function edit(Hostel $hostel): View
    {
        return view('hostels.edit', [
            'hostel' => $hostel,
        ]);
    }
}
