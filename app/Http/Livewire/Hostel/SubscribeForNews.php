<?php

declare(strict_types=1);

namespace App\Http\Livewire\Hostel;

use App\Models\Hostel;
use Auth;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use Livewire\Component;

class SubscribeForNews extends Component
{
    public Hostel $hostel;

    public function mount(Hostel $hostel): void
    {
        $this->hostel = $hostel;
    }

    public function subscribe(): void
    {
        if (! Auth::check()) {
            Notification::make()
                ->warning()
                ->title('Yêu cầu đăng nhập')
                ->body('Vui lòng đăng nhập để nhận tin.')
                ->send()
            ;

            return;
        }

        if (Auth::user()->can('subscribe', [$this->hostel])) {
            $this->hostel->subscribers()->attach(Auth::id());
        }

        Notification::make()
            ->success()
            ->title('Đăng ký thành công')
            ->body('Chủ nhà sẽ sớm liên hệ với bạn.')
            ->send()
        ;
    }

    public function render(): View
    {
        return view('livewire.hostel.subscribe-for-news');
    }
}
