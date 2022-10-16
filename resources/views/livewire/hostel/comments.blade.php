<div>
    <div class="divide-y divide-gray-200">
        <ul role="list" class="space-y-8">
            @foreach ($comments as $comment)
                @if ($comment->parent_id == null)
                    <div>
                        <li>
                            <div class="flex space-x-3">
                                <div class="flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full" src="{{ $comment->owner->profile_photo_url }}"
                                        alt="avatar">
                                </div>
                                <div>
                                    <div class="text-sm">
                                        <a href="#"
                                            class="font-medium text-gray-900">{{ $comment->owner->name }}</a>
                                    </div>
                                    <div class="mt-1 text-sm text-gray-700">
                                        <p>{{ $comment->content }}</p>
                                    </div>
                                    <div x-data="{ reply: false }">
                                        <button @click="reply = !reply" class="text-sm leading-5 text-gray-500">
                                            Phản hồi
                                        </button>
                                        <div x-show="reply">
                                            <div class="mt-1">
                                                <form wire:submit.prevent="replyComment({{ $comment->id }})"
                                                    class="flex">
                                                    @csrf
                                                    <input type="text" name="reply" id="reply"
                                                        wire:model.defer="reply"
                                                        class="mr-2 block w-full rounded-md border-gray-300 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                        placeholder="Hãy phản hồi gì đó">
                                                    <button type="submit"
                                                        class="focus:shadow-outline-indigo active:shadow-outline-indigo flex-shrink-0 rounded-md border-indigo-500 bg-indigo-500 px-4 py-2 text-sm font-medium leading-5 text-white hover:border-indigo-400 hover:bg-indigo-400 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 active:border-indigo-700 active:bg-indigo-600">
                                                        Gửi phản hồi </button>
                                                </form>
                                            </div>
                                        </div>
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
                    </div>
                    <div class="pl-12">
                        @if ($comment->children->count() > 0)
                            <ul>
                                @foreach ($comment->children as $child)
                                    <li>
                                        <div class="flex space-x-3">
                                            <div class="flex-shrink-0">
                                                <img class="h-10 w-10 rounded-full"
                                                    src="{{ $child->owner->profile_photo_url }}" alt="avatar">
                                            </div>
                                            <div>
                                                <div class="text-sm">
                                                    <span class="font-light text-gray-500">Phản hồi từ</span>
                                                    <a href="#" class="font-medium text-gray-800">
                                                        {{ $child->owner->name }}
                                                    </a>
                                                </div>
                                                <div class="mt-1 text-sm text-gray-700">
                                                    <p>{{ $child->content }}</p>
                                                </div>
                                                <div class="mt-2 space-x-2 text-sm">
                                                    <span
                                                        class="font-medium text-gray-500">{{ $child->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endif
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
