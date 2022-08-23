<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Amenity;
use App\Models\Category;
use App\Models\Hostel;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditHostel extends Component
{
    use WithFileUploads;
    public $hostel;
    public $title = '';
    public $description = '';
    public $size = 0;
    public $price = 0;
    public $address = '';
    public $latitude = 0;
    public $longitude = 0;
    public $categoriesList = [];
    public $amenitiesList = [];
    public $oldPhotos = [];
    public $newPhotos = [];
    public $photoRemove = [];
    public $count = 0;

    protected $rules = [
        'title' => ['required', 'string', 'max:255'],
        'description' => ['string'],
        'newPhotos.*' => ['image'],
        'count' => ['integer', 'min:5'],
        'size' => ['required', 'integer', 'min:1'],
        'price' => ['required', 'integer', 'min:1'],
    ];
    protected $messages = [
        'count.min' => 'Trường này cần ít nhất 5 ảnh',
    ];

    public function mount(Hostel $hostel): void
    {
        $this->hostel = $hostel;
        $this->title = $hostel->title;
        $this->description = $hostel->description;
        $this->size = $hostel->size;
        $this->price = $hostel->monthly_price;
        $this->address = $hostel->address;
        $this->latitude = $hostel->latitude;
        $this->longitude = $hostel->longitude;
        $this->categoriesList = $hostel->categories->pluck('id');
        $this->amenitiesList = $hostel->amenities->pluck('id');
        $this->oldPhotos = $hostel->getMedia();
        $this->photos = $this->oldPhotos->toArray();
        $this->count = \count($this->oldPhotos);
    }

    public function removePhoto($id): void
    {
        foreach ($this->oldPhotos as $key => $photo) {
            if ($photo->id === $id) {
                unset($this->oldPhotos[$key]);
                $this->photoRemove[] = $photo;
            }
        }
    }

    public function updateHostel(): void
    {
        $this->count = $this->count - \count($this->photoRemove) + \count($this->newPhotos);
        $this->validate();
        $hostel = Hostel::find($this->hostel->id);
        $hostel->update([
            'title' => $this->title,
            'description' => $this->description,
            'size' => $this->size,
            'monthly_price' => $this->price,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ]);
        $hostel->categories()->sync($this->categoriesList);
        $hostel->amenities()->sync($this->amenitiesList);
        $media = $this->hostel->getMedia();
        foreach ($this->photoRemove as $photo) {
            $media->where('id', $photo['id'])->first()->delete();
        }
        foreach ($this->newPhotos as $photo) {
            $this->hostel->addMedia($photo)->toMediaCollection();
        }
        $this->photos = [];
        $this->title = '';
        $this->description = '';
        $this->size = 0;
        $this->monthly_price = 0;
        $this->categoriesList = [];
        $this->amenitiesList = [];

        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->body('Changes to the **post** have been saved.')
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(route('hostels.show', ['hostel' => $this->hostel])),
            ])
            ->send()
        ;
    }

    public function setLatLng(array $latLng): void
    {
        $this->latitude = $latLng['lat'];
        $this->longitude = $latLng['lng'];
    }

    public function render()
    {
        $categories = Category::all();
        $amenities = Amenity::all();

        return view('livewire.edit-hostel', [
            'categories' => $categories,
            'amenities' => $amenities,
        ]);
    }
}
