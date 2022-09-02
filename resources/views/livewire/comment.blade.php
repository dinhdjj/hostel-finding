<div class="pt-10">
    <div class="text-3xl">
        COMMENTS
    </div>
    {{-- star --}}
    <div class="flex items-center pb-5 font-bold">
        {{ round($hostel->votes_avg_score * 5, 2) }}
        <x-heroicon-s-star class="inline-block h-4" />
        <x-bi-dot />
        <div class="my-4 inline-block text-base leading-6 text-gray-900">
            {{ $hostel->votes_count }} đánh giá
        </div>
        <x-bi-dot />
        {{ $hostel->comments_count }} comments
    </div>
    @can('create', [\App\Comment::class, $hostel])
    @else
        <div class="text-sm font-semibold text-red-500">
            You have voted this hostel {{ $hostel->votes->where('owner_id', auth()->id())->first()->score }} stars
        </div>
    @endcan

    {{-- comment --}}
    @auth
        @if ($comments->count() > 0)
            <div class="grid grid-cols-2">
                @foreach ($comments as $index => $comment)
                    @if ($comment->parent_id == null)
                        <div class="col-span-1">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <x-avatar :search="$comment->owner->email" :src="$comment->owner->profile_photo_url" />
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium leading-5 text-gray-900">
                                        {{ $comment->owner->name }}
                                    </div>
                                    <div class="text-sm leading-5 text-gray-500">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                            <div x-data="{ reply: false }" class="my-4 ml-4 pl-9 text-base leading-6 text-gray-900">
                                <div class="w-96">
                                    {{ $comment->content }}
                                </div>
                                <button @click="reply = !reply" class="text-sm leading-5 text-gray-500">
                                    Phản hồi
                                </button>
                                <div x-show="reply">
                                    <div class="mt-1">
                                        <form wire:submit.prevent="replyComment({{ $comment->id }})" class="flex">
                                            @csrf
                                            <input type="text" name="reply" id="reply" wire:model.defer="reply"
                                                class="block w-full rounded-full border-gray-300 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                placeholder="Write a reply...">
                                            <button type="submit"
                                                class="focus:shadow-outline-indigo active:shadow-outline-indigo flex-shrink-0 rounded-full border-indigo-500 bg-indigo-500 px-4 py-2 text-sm font-medium leading-5 text-white hover:border-indigo-400 hover:bg-indigo-400 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 active:border-indigo-700 active:bg-indigo-600">
                                                Post reply</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="pl-12">
                                @if ($comment->children->count() > 0)
                                    @foreach ($comment->children as $child)
                                        <div class="my-4 ml-4 pl-9 text-base leading-6 text-gray-900">
                                            <div class="font-bold">
                                                Reply to {{ $child->owner->name }}
                                            </div>
                                            <div class="text-sm leading-5 text-gray-500">
                                                {{ $child->created_at->diffForHumans() }}
                                            </div>
                                            <div class="overflow-hidden pl-5">
                                                {{ $child->content }}
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div>
                {{ $comments->links() }}
            </div>
        @endif
        <div class="mt-1">
            <form wire:submit.prevent="createComment" class="flex">
                @csrf
                <input type="text" name="comment" id="comment" wire:model.defer="comment"
                    class="block w-1/2 rounded-xl border-gray-300 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    placeholder="Write a comment...">
                <button type="submit"
                    class="focus:shadow-outline-indigo active:shadow-outline-indigo flex-shrink-0 rounded-full border-indigo-500 bg-indigo-500 px-4 py-2 text-sm font-medium leading-5 text-white hover:border-indigo-400 hover:bg-indigo-400 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 active:border-indigo-700 active:bg-indigo-600">
                    Post comment</button>
            </form>
        </div>
        </>
    @else
        <div class="text-center">
            <a href="{{ route('login') }}" class="text-indigo-500 hover:text-indigo-700">
                Đăng nhập để bình luận
            </a>
        </div>
    @endauth
    {{-- end comment --}}
</div>
