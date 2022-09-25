<div>
    <div class="divide-y divide-gray-200">
        <ul role="list" class="space-y-8">
            @foreach ($comments as $comment)
                <li>
                    <div class="flex space-x-3">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" src="{{ $comment->owner->profile_photo_url }}"
                                alt="avatar">
                        </div>
                        <div>
                            <div class="text-sm">
                                <a href="#" class="font-medium text-gray-900">{{ $comment->owner->name }}</a>
                            </div>
                            <div class="mt-1 text-sm text-gray-700">
                                <p>{{ $comment->content }}</p>
                            </div>
                            <div class="mt-2 space-x-2 text-sm">
                                <span
                                    class="font-medium text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                <!-- space -->
                                {{-- <span class="font-medium text-gray-500">·</span> --}}
                                <!-- space -->
                                {{-- <button type="button" class="font-medium text-gray-900">Reply</button> --}}
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="mt-4 rounded-md bg-gray-50 px-4 py-6 sm:px-6">
        @auth
            <div class="flex space-x-3">
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="">
                </div>
                <div class="min-w-0 flex-1">
                    <form wire:submit.prevent="submit">
                        <div>
                            <label for="comment" class="sr-only">About</label>
                            <textarea id="comment" name="comment" rows="3"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                placeholder="Hãy viết gì đó" wire:model.defer="content" required minlength="3"></textarea>
                        </div>
                        <div class="mt-3 flex items-center justify-end">
                            <button type="submit"
                                class="inline-flex items-center justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Bình luận </button>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}" class="inline-block w-full text-center font-bold text-primary-600">
                Đăng Nhập Để Bình Luận
            </a>
        @endauth
    </div>
</div>
