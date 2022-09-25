<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Category;
use App\Models\Hostel;
use Cache;
use Http;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HostelIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        $ip = $request->ip();
        $location = Cache::rememberForever("location-ip-{$ip}", fn () => Http::get("http://ip-api.com/json/{$ip}")->throw()->json());
        $nearestHostels = new Collection();

        if ('fail' !== $location['status']) {
            $lat = $location['lat'];
            $lon = $location['lon'];

            // get the nearest hostels
            $nearestHostels = Hostel::with(['owner', 'categories'])
                ->selectRaw('*, ( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?)) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance', [$lat, $lon, $lat])
                ->orderBy('distance')
                ->whereNotNull('found_at')
                ->limit(12)
                ->get()
            ;
        } else {
            $nearestHostels = Hostel::with(['owner', 'categories'])
                ->withAggregate('votes', 'score')
                ->withCount('visitLogs')
                ->orderBy('visit_logs_count', 'desc')
                ->whereNotNull('found_at')
                ->limit(12)
                ->get()
            ;
        }

        return view('hostels.index', [
            'nearestHostels' => $nearestHostels,
            'trendingCategories' => Category::withCount('hostels')->orderBy('hostels_count', 'desc')->limit(12)->get(),
            'trendingAmenities' => Amenity::withCount('hostels')->orderBy('hostels_count', 'desc')->limit(12)->get(),
        ]);
    }
}
