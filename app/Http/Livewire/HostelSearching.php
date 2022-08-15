<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Hostel;
use Debugbar;
use Livewire\Component;
use Livewire\WithPagination;

class HostelSearching extends Component
{
    use WithPagination;
    public array $hostels;

    public function mount(): void
    {
        $this->hostels = Hostel::paginate(10)->toArray()['data'];
    }

    public function updateBounds($north, $south, $west, $east): void
    {
        Debugbar::info($north, $south, $west, $east);
        $this->hostels = Hostel::query()
            ->where('latitude', '>=', $south)
            ->where('latitude', '<=', $north)
            ->where('longitude', '>=', $west)
            ->where('longitude', '<=', $east)
            ->paginate(10)
            ->toArray()['data'];
    }

    public function render()
    {
        return view('livewire.hostel-searching');
    }
}
