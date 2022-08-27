<?php

declare(strict_types=1);

namespace App\Http\Livewire\Hostel;

use App\Models\Hostel;
use Livewire\Component;
use Livewire\WithPagination;

class Search extends Component
{
    use WithPagination;

    public float $north = 0;
    public float $south = 0;
    public float $west = 0;
    public float $east = 0;
    public array $hostelsData = [];

    protected $queryString = [
        'north',
        'south',
        'west',
        'east',
    ];

    public function mount(float $north, float $south, float $west, float $east): void
    {
        $this->south = $south;
        $this->north = $north;
        $this->west = $west;
        $this->east = $east;
    }

    public function updateBounds(float $north, float $south, float $west, float $east): void
    {
        $this->south = $south;
        $this->north = $north;
        $this->west = $west;
        $this->east = $east;

        $this->resetPage();
    }

    /**
     * TODO: show nearest hostels.
     */
    public function showNearestHostels(): void
    {
    }

    public function render()
    {
        $hostels = Hostel::with('categories')
            ->where('latitude', '>=', $this->south)
            ->where('latitude', '<=', $this->north)
            ->where('longitude', '>=', $this->west)
            ->where('longitude', '<=', $this->east)
            ->paginate(12)
        ;

        $this->hostelsData = $hostels->toArray()['data'];

        return view('livewire.hostel.search', [
            'hostels' => $hostels,
        ]);
    }
}
