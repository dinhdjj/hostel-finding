<?php

declare(strict_types=1);

namespace App\Http\Livewire\Hostel;

use App\Models\Comment;
use App\Models\Hostel;
use Filament\Notifications\Notification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Livewire\Component;

class Comments extends Component
{
    use AuthorizesRequests;

    public Hostel $hostel;
    public string $content = '';

    protected array $rules = [
        'content' => ['required', 'min:3'],
    ];

    public function mount(Hostel $hostel): void
    {
        $this->hostel = $hostel;
    }

    public function submit(): void
    {
        $this->validate();
        $this->authorize('create', [Comment::class, $this->hostel]);

        Comment::create([
            'content' => $this->content,
            'hostel_id' => $this->hostel->id,
            'owner_id' => auth()->id(),
        ]);

        $this->content = '';
        Notification::make()
            ->success()
            ->title('Bình luận thành công')
            ->send()
        ;
        $this->hostel->load('comments.owner');
    }

    public function render(): View
    {
        return view('livewire.hostel.comments', [
            'comments' => $this->hostel->comments,
        ]);
    }
}
