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

class Hosting extends Component
{
    use WithFileUploads;

    public string $title = '';
    public ?string $description = null;
    public $photos = [];
    public int $size = 0;
    public int $price = 0;
    public array $categoriesList = [];
    public array $amenitiesList = [];

    protected $rules = [
        'title' => ['required', 'string', 'max:255'],
        'description' => ['string'],
        'photos' => ['required', 'array', 'min:5'],
        'photos.*' => ['image'],
        'size' => ['required', 'integer', 'min:1'],
        'price' => ['required', 'integer', 'min:1'],
    ];
    protected $messages = [
        'photos.min' => 'Trường này cần ít nhất 5 ảnh',
    ];

    public function createHostel(): void
    {
        $this->validate();

        $hostel = Hostel::create([
            'title' => $this->title,
            'description' => $this->description,
            'size' => $this->size,
            'monthly_price' => $this->price,
            'address' => '',
            'latitude' => 11.11111111111113,
            'longitude' => 11.11111111111113,
            'owner_id' => auth()->id(),
        ]);
        $this->categoriesList = array_filter($this->categoriesList);
        $this->amenitiesList = array_filter($this->amenitiesList);
        $hostel->categories()->sync($this->categoriesList);
        $hostel->amenities()->sync($this->amenitiesList);
        foreach ($this->photos as $photo) {
            $hostel->addMedia($photo)->toMediaCollection();
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
                    ->url(route('hostels.show', ['hostel' => $hostel])),
            ])
            ->send()
        ;
    }

    public function render()
    {
        $categories = Category::all();
        $amenities = Amenity::all();

        return view('livewire.hosting', [
            'categories' => $categories,
            'amenities' => $amenities,
        ]);
    }
}