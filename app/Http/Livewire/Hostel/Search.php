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
        $nearestHostel = Hostel::selectRaw('*, ( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance', [$this->north, $this->west, $this->south])
            ->orderBy('distance')
            ->first(1)
        ;

        if (! $nearestHostel) {
            return;
        }

        $this->fitPoint($nearestHostel->latitude, $nearestHostel->longitude);
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

    protected function fitPoint(float $latitude, float $longitude): void
    {
        if ($latitude > $this->north) {
            $this->north = $latitude + 0.001;
        } elseif ($latitude < $this->south) {
            $this->south = $latitude - 0.001;
        }

        if ($longitude > $this->east) {
            $this->east = $longitude + 0.001;
        } elseif ($longitude < $this->west) {
            $this->west = $longitude - 0.001;
        }

        $this->emitSelf('update-bounds');
    }
}
