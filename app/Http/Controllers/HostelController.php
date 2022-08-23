<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Hostel;
use Illuminate\Http\Request;

class HostelController extends Controller
{
    public function show(Request $request, Hostel $hostel)
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

    public function hosting()
    {
        return view('hostels.hosting');
    }

    public function manage(Request $request, Hostel $hostel)
    {
        return view('hostels.edit', [
            'hostel' => $hostel,
        ]);
    }
}
