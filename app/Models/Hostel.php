<?php

declare(strict_types=1);

namespace App\Models;

use Dinhdjj\Visit\Traits\Visitable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Hostel extends Model implements HasMedia
{
    use HasFactory;
    use HasSlug;
    use InteractsWithMedia;
    use Visitable;

    protected $fillable = [
        'title',
        'description',
        'found_at',
        'address',
        'latitude',
        'longitude',
        'size',
        'monthly_price',
        'allowable_number_of_people',
        'owner_id',
        'coordinates',
    ];

    protected $hidden = [];

    protected $casts = [
        'found_at' => 'datetime',
    ];

    protected $appends = [
        'coordinates',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
        ;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps()->withPivot('active');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')
            ->acceptsMimeTypes(['image/jpg', 'image/jpeg', 'image/png', 'image/bmp', 'image/gif', 'image/svg+xml', 'image/webp'])
            ->withResponsiveImages()
        ;
    }

    public function getCoordinatesAttribute(): array
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }

    public function setCoordinatesAttribute(array $coordinates): void
    {
        $this->fill([
            'latitude' => $coordinates['latitude'],
            'longitude' => $coordinates['longitude'],
        ]);
    }

    protected static function booted(): void
    {
        static::deleting(function (self $hostel): void {
            $hostel->comments->each->delete();
            $hostel->votes->each->delete();
        });
    }
}
