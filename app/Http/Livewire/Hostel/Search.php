<?php

declare(strict_types=1);

namespace App\Http\Livewire\Hostel;

use App\Models\Hostel;
use Livewire\Component;
use Livewire\WithPagination;

class Search extends Component
{
    use WithPagination;

    public float $south;
    public float $north;
    public float $west;
    public float $east;
    public array $hostelsData;

    public function mount(float $latitude, float $longitude): void
    {
        $this->south = $latitude - 0.01;
        $this->north = $latitude + 0.01;
        $this->west = $longitude - 0.01;
        $this->east = $longitude + 0.01;
    }

    public function updateBounds($north, $south, $west, $east): void
    {
        $this->south = $south;
        $this->north = $north;
        $this->west = $west;
        $this->east = $east;
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

        $this->emitSelf('update-hostels');

        return view('livewire.hostel.search', [
            'hostels' => $hostels,
        ]);
    }
}
