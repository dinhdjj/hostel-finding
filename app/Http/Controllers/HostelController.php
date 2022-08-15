<?php

declare(strict_types=1);

namespace App\Http\Controllers;

class HostelController extends Controller
{
    public function search()
    {
        return view('hostels.search');
    }
}
