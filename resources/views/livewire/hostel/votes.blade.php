<div x-data="livewire_hostel_votes">
    <div class="divide-y divide-gray-200">
        <ul role="list" class="space-y-8">
            @foreach ($votes as $vote)
                <li>
                    <div class="flex space-x-3">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" src="{{ $vote->owner->profile_photo_url }}" alt="avatar">
                        </div>
                        <div>
                            <div class="text-sm">
                                <a href="#" class="font-medium text-gray-900">
                                    {{ $vote->owner->name }}
                                </a>
                                <div>
                                    @for ($i = 1; $i <= 5 * $vote->score; $i++)
                                        <x-heroicon-s-star class="inline-block h-4 text-yellow-500" />
                                    @endfor
                                </div>
                            </div>
                            <div class="mt-1 text-sm text-gray-700">
                                <p>{{ $vote->description }}</p>
                            </div>
                            <div class="mt-2 space-x-2 text-sm">
                                <span class="font-medium text-gray-500">{{ $vote->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="mt-4 rounded-md bg-gray-50 px-4 py-6 sm:px-6">
        @auth
            @can('create', [App\Models\Vote::class, $hostel])
                <div class="flex space-x-3">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="">
                    </div>
                    <div class="min-w-0 flex-1">
                        <form @submit.prevent="submit">
                            <div>
                                <label for="comment" class="sr-only">About</label>
                                <textarea id="comment" name="comment" rows="3"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    placeholder="Hãy viết gì đó" x-model="description" required minlength="3"></textarea>
                            </div>
                            <div class="mt-3 flex items-start justify-between">
                                <div>
                                    <x-heroicon-s-star class="inline-block h-4" ::class="{
                                        'text-gray-500': score < 0.2,
                                        'text-yellow-500': score >= 0.2,
                                    }" @click="score = 0.2" />
                                    <x-heroicon-s-star class="inline-block h-4" ::class="{
                                        'text-gray-500': score < 0.4,
                                        'text-yellow-500': score >= 0.4,
                                    }" @click="score = 0.4" />
                                    <x-heroicon-s-star class="inline-block h-4" ::class="{
                                        'text-gray-500': score < 0.6,
                                        'text-yellow-500': score >= 0.6,
                                    }" @click="score = 0.6" />
                                    <x-heroicon-s-star class="inline-block h-4" ::class="{
                                        'text-gray-500': score < 0.8,
                                        'text-yellow-500': score >= 0.8,
                                    }" @click="score = 0.8" />
                                    <x-heroicon-s-star class="inline-block h-4" ::class="{
                                        'text-gray-500': score < 1,
                                        'text-yellow-500': score >= 1,
                                    }" @click="score = 1" />
                                </div>
                                <button type="submit"
                                    class="inline-flex items-center justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Đánh giá
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <button class="inline-block w-full text-center font-bold text-primary-600">
                    Bạn Không Thể Đánh Giá
                </button>
            @endcan
        @else
            <a href="{{ route('login') }}" class="inline-block w-full text-center font-bold text-primary-600">
                Đăng Nhập Để Đánh Giá
            </a>
        @endauth
    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('livewire_hostel_votes', () => ({
                    score: 0,
                    description: null,

                    submit() {
                        this.$wire.submit(this.score, this.description)
                    }
                }))
            });
        </script>
    @endpush
</div>
