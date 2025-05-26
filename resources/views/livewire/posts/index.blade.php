<div>
    <div class="justify-center m-6">
        <div class="my-4 px-4 py-6 bg-white rounded-lg shadow hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
            <select id="status" wire:model.live.throttle.550ms="status"
                class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                @foreach (\App\Enums\StatusType::cases() as $status)
                    <option value="{{ $status->value }}">{{ $status->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div>
        <div class="px-6">
            @foreach ($posts as $post)
                <div
                    class="my-4 px-4 py-6 bg-white rounded-lg shadow hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                    <div class="p-4 leading-normal">
                        <div class="flex justify-between mb-4">
                            <h5 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ $post->title }}
                            </h5>
                            <span
                                class="px-2 py-1 border border-slate-200 bg-white rounded-md flex justify-end">{{ $post->scheduled_time }}</span>
                        </div>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $post->content }}</p>
                    </div>
                    <div class="flex justify-between">
                        <div>
                            @foreach (App\Enums\StatusType::cases() as $case)
                                <button wire:key="post-{{ $post->id }}" type="button"
                                    wire:click="changeStatus({{ $post->id }}, '{{ $case->value }}')"
                                    @class([
                                        'inline-flex items-center px-4 py-2 bg-white border rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150',
                                    ]) {{ $case->value != $post->status ? 'disabled' : '' }}>
                                    {{ Str::of($case->value)->headline() }}
                                </button>
                            @endforeach
                        </div>
                        <div>
                            <a href="{{ route('posts.edit', $post->id) }}">
                                <x-primary-button class="bg-green-500 hover:bg-green-700">Edit</x-primary-button>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-2 mb-4 p-2">
            {{ $posts->links() }}
        </div>
    </div>
</div>
