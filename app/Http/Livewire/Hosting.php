<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Amenity;
use App\Models\Category;
use App\Models\Hostel;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Livewire\Component;
use Livewire\WithFileUploads;

class Hosting extends Component implements HasForms
{
    use InteractsWithForms;
    use WithFileUploads;

    public string $title = '';
    public ?string $description = null;
    public int $size = 0;
    public int $price = 0;
    public string $address = '';
    public float $latitude = 0;
    public float $longitude = 0;
    public array $categoriesList = [];
    public array $amenitiesList = [];
    public $firstMedia;
    public $media;

    protected $rules = [
        'title' => ['required', 'string', 'max:255'],
        'description' => ['string'],
        'size' => ['required', 'integer', 'min:1'],
        'price' => ['required', 'integer', 'min:1'],
    ];

    public function setLatLng(array $latLng): void
    {
        $this->latitude = $latLng['lat'];
        $this->longitude = $latLng['lng'];
    }

    public function createHostel(): void
    {
        $this->validate();

        $hostel = Hostel::create([
            'title' => $this->title,
            'description' => $this->description,
            'size' => $this->size,
            'monthly_price' => $this->price,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'owner_id' => auth()->id(),
        ]);
        $this->categoriesList = array_filter($this->categoriesList);
        $this->amenitiesList = array_filter($this->amenitiesList);
        $hostel->categories()->sync($this->categoriesList);
        $hostel->amenities()->sync($this->amenitiesList);
        foreach ($this->media as $photo) {
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
            ->body('Create to the **post** have been saved.')
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

    protected function getFormSchema(): array
    {
        return [
            Placeholder::make('Images')
                ->content('Ảnh cuối cùng sẽ là ảnh đại diện cho nhà của bạn hãy sắp xếp theo thứ tự thật chính xác!'),
            SpatieMediaLibraryFileUpload::make('media')
                ->label('')
                ->multiple()
                ->enableReordering()
                ->minFiles(5),
        ];
    }
}
