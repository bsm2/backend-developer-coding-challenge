    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div>
                        <form wire:submit.prevent="togglePlatforms">
                            <div class="flex flex-col items-center gap-10 m-7">
                                @if (session('success'))
                                    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                                        role="alert">
                                        <span class="font-medium">{{ session('success') }}</span>
                                    </div>
                                @endif
                                <h1 class="text-white font-bold text-lg">Update Active Platforms</h1>

                                <div class="w-8/12 p-4 flex justify-between rounded-md bg-slate-200 shadow-md">
                                    @foreach ($platforms as $index => $platform)
                                        <div class="@class([
                                            'flex flex-col justify-center items-center gap-1 p-2 rounded-lg transition',
                                            'border-2 border-green-500 bg-green-100 shadow-md' => $platform['active'],
                                            'bg-white' => !$platform['active'],
                                        ])">
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" wire:model="platforms.{{ $index }}.active"
                                                    class="sr-only peer" {{ $platform['active'] ? 'checked' : '' }}>
                                                <div
                                                    class="w-11 h-6 bg-gray-300 rounded-full peer peer-focus:ring-2 peer-focus:ring-blue-500
                            dark:bg-gray-600 peer-checked:bg-green-500
                            after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                            after:bg-white after:border-gray-300 after:border after:rounded-full
                            after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full peer-checked:after:border-white">
                                                </div>
                                            </label>
                                            <input type="hidden" wire:model="platforms.{{ $index }}.id"
                                                value="{{ $platform['id'] }}">
                                            <span
                                                class="text-black font-medium text-sm mt-1">{{ $platform['name'] }}</span>
                                        </div>
                                    @endforeach
                                </div>

                                <button type="submit"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                                    Save Changes
                                </button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
