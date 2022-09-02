<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Amenity;
use App\Models\Category;
use App\Models\Hostel;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class Edit extends Component implements HasForms
{
    use InteractsWithForms;

    public Hostel $hostel;
    public string $title = '';
    public string $description = '';
    public int $size = 0;
    public int $monthly_price = 0;
    public string $address = '';
    public Collection $categoriesList;
    public Collection $amenitiesList;
    public float $latitude = 0;
    public float $longitude = 0;
    public mixed $media;

    public function mount(Hostel $hostel): void
    {
        $this->hostel = $hostel;
        $this->title = $hostel->title;
        $this->description = $hostel->description;
        $this->size = $hostel->size;
        $this->monthly_price = $hostel->monthly_price;
        $this->address = $hostel->address;
        $this->latitude = $hostel->latitude;
        $this->longitude = $hostel->longitude;
        $this->categoriesList = $hostel->categories->pluck('id');
        $this->amenitiesList = $hostel->amenities->pluck('id');
        $this->form->fill([ // @phpstan-ignore-line
            'title' => $this->hostel->title,
            'description' => $this->hostel->description,
            'size' => $this->hostel->size,
            'monthly_price' => $this->hostel->monthly_price,
            'address' => $this->hostel->address,
        ]);
    }

    public function setLatLng(array $latLng): void
    {
        $this->latitude = $latLng['lat'];
        $this->longitude = $latLng['lng'];
    }

    public function submit(): void
    {
        $hostel = Hostel::find($this->hostel->id);
        $data = $this->form->getState(); // @phpstan-ignore-line
        $hostel->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'size' => $data['size'],
            'monthly_price' => $data['monthly_price'],
            'address' => $data['address'],
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ]);
        $hostel->categories()->sync($this->categoriesList);
        $hostel->amenities()->sync($this->amenitiesList);
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

    public function render(): View
    {
        $categories = Category::all();
        $amenities = Amenity::all();

        return view('livewire.edit', [
            'categories' => $categories,
            'amenities' => $amenities,
        ]);
    }

    protected function getFormModel(): mixed
    {
        return $this->hostel;
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('title')
                ->required()
                ->maxLength(255),
            TextInput::make('size')
                ->numeric()
                ->required(),
            TextInput::make('monthly_price')
                ->numeric()
                ->required(),
            MarkdownEditor::make('description'),
            Placeholder::make('Images')
                ->content('Ảnh cuối cùng sẽ là ảnh đại diện cho nhà của bạn hãy sắp xếp theo thứ tự thật chính xác!'),
            SpatieMediaLibraryFileUpload::make('media')
                ->model($this->hostel)
                ->label('')
                ->multiple()
                ->enableReordering()
                ->minFiles(5),
            TextInput::make('address')
                ->required()
                ->disabled()
                ->maxLength(255),
        ];
    }
}
