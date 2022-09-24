<?php

declare(strict_types=1);

namespace App\Http\Livewire\Hostel;

use App\Models\Amenity;
use App\Models\Category;
use App\Models\Hostel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Search extends Component
{
    use WithPagination;

    public float $north = 0;
    public float $south = 0;
    public float $west = 0;
    public float $east = 0;
    public ?int $max_price = null;
    public ?int $min_price = null;
    public array $category_ids = [];
    public array $amenity_ids = [];
    public string $order = 'newest';
    public array $hostelsData = [];

    public int $largestPrice = 0;
    public int $smallestPrice = 0;

    /**
     * @var (string|array)[]
     */
    protected $queryString = [
        'north',
        'south',
        'west',
        'east',
        'max_price' => ['except' => null],
        'min_price' => ['except' => null],
        'category_ids' => ['except' => []],
        'amenity_ids' => ['except' => []],
        'order' => ['except' => 'newest'],
    ];

    public function mount(): void
    {
        $this->largestPrice = Hostel::where('found_at', '>', now())->max('monthly_price') ?? 0;
        $this->smallestPrice = Hostel::where('found_at', '>', now())->min('monthly_price') ?? 0;
    }

    public function updateBounds(float $north, float $south, float $west, float $east): void
    {
        $this->south = $south;
        $this->north = $north;
        $this->west = $west;
        $this->east = $east;

        $this->resetPage();
    }

    public function showNearestHostels(): void
    {
        /** @var ?Hostel */
        $nearestHostel = $this->getBaseHostelQuery()
            ->selectRaw('*, ( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance', [$this->north, $this->west, $this->south])
            ->orderBy('distance')
            ->first()
        ;

        if (! $nearestHostel) {
            return;
        }

        $this->fitPoint($nearestHostel->latitude, $nearestHostel->longitude);
    }

    public function filter(array $price, array $categoryIds, array $amenityIds, string $order): void
    {
        $this->min_price = $price[0];
        $this->max_price = $price[1];
        $this->category_ids = $categoryIds;
        $this->amenity_ids = $amenityIds;
        $this->order = $order;
    }

    public function render(): View
    {
        $query = $this->getBaseHostelQuery();
        $this->applyOrderToQuery($query);

        $hostels = $query
            ->withCount('visitLogs')
            ->where('latitude', '>=', $this->south)
            ->where('latitude', '<=', $this->north)
            ->where('longitude', '>=', $this->west)
            ->where('longitude', '<=', $this->east)
            ->paginate(12)
        ;

        $categories = Category::all();

        $amenities = Amenity::all();

        $this->hostelsData = $hostels->toArray()['data'];

        return view('livewire.hostel.search', [
            'hostels' => $hostels,
            'categories' => $categories,
            'amenities' => $amenities,
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

    protected function getBaseHostelQuery(): Builder
    {
        return Hostel::with('categories')
            ->where('found_at', '>', now())
            ->when($this->min_price, fn ($query) => $query->where('monthly_price', '>=', $this->min_price))
            ->when($this->max_price, fn ($query) => $query->where('monthly_price', '<=', $this->max_price))
            ->when($this->category_ids, fn ($query) => $query->whereHas('categories', fn ($query) => $query->whereIn('id', $this->category_ids)))
            ->when($this->amenity_ids, fn ($query) => $query->whereHas('amenities', fn ($query) => $query->whereIn('id', $this->amenity_ids)))
        ;
    }

    protected function applyOrderToQuery(Builder $query): void
    {
        switch ($this->order) {
            case 'price_desc':
                $query->orderBy('monthly_price', 'desc');

                break;

            case 'price_asc':
                $query->orderBy('monthly_price', 'asc');

                break;

            case 'distance_asc':
                $query
                    ->selectRaw('*, ( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance', [$this->north, $this->west, $this->south])
                    ->orderBy('distance')
                ;

                break;

            case 'visits_desc':
                $query
                    ->withCount('visitLogs')
                    ->orderBy('visit_logs_count', 'desc')
                ;

                break;

            case 'visits_asc':
                $query
                    ->withCount('visitLogs')
                    ->orderBy('visit_logs_count', 'asc')
                ;

                break;

            case 'newest':
                $query->orderBy('created_at', 'desc');

                break;

            case 'oldest':
                $query->orderBy('created_at', 'asc');

                break;
        }
    }
}
