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
    public int $allowable_number_of_people = 0;
    public string $address = '';
    public Collection $categoriesList;
    public Collection $amenitiesList;
    public float $latitude = 0;
    public float $longitude = 0;
    public mixed $media;
    public mixed $oldMedia;

    public function mount(Hostel $hostel): void
    {
        $this->hostel = $hostel;
        $this->title = $hostel->title;
        $this->description = $hostel->description;
        $this->size = $hostel->size;
        $this->monthly_price = $hostel->monthly_price;
        $this->allowable_number_of_people = $hostel->allowable_number_of_people;
        $this->address = $hostel->address;
        $this->latitude = $hostel->latitude;
        $this->longitude = $hostel->longitude;
        $this->categoriesList = $hostel->categories->pluck('id');
        $this->amenitiesList = $hostel->amenities->pluck('id');
        $this->oldMedia = $hostel->getMedia();
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
            'allowable_number_of_people' => $data['allowable_number_of_people'],
            'address' => $data['address'],
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ]);
        $hostel->categories()->sync($this->categoriesList);
        $hostel->amenities()->sync($this->amenitiesList);
        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->body('C??p nh???t th??ng tin th??nh c??ng')
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(route('hostels.show', ['hostel' => $this->hostel])),
            ])
            ->send()
        ;
    }

    public function cancel(): void
    {
        $this->redirect(route('hostels.show', ['hostel' => $this->hostel]));
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
                ->label('Ti??u ?????')
                ->required()
                ->maxLength(255),
            TextInput::make('size')
                ->label('Di???n t??ch')
                ->numeric()
                ->required(),
            TextInput::make('monthly_price')
                ->label('Gi?? m???i th??ng')
                ->numeric()
                ->required(),
            TextInput::make('allowable_number_of_people')
                ->label('S??? ng?????i ???')
                ->numeric()
                ->required(),
            MarkdownEditor::make('description')
                ->label('M?? t???'),
            Placeholder::make('Images')
                ->label('???nh')
                ->content('???nh cu???i c??ng s??? l?? ???nh ?????i di???n cho nh?? c???a b???n h??y s???p x???p theo th??? t??? th???t ch??nh x??c!'),
            SpatieMediaLibraryFileUpload::make('media')
                ->model($this->hostel)
                ->label('')
                ->multiple()
                ->enableReordering()
                ->minFiles(5),
            TextInput::make('address')
                ->label('?????a ch???')
                ->required()
                ->disabled()
                ->maxLength(255),
        ];
    }
}
