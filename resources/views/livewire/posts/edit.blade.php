<div>
    <div class="bg-slate-200 rounded-md p-4 mt-4 mx-6">
        <div class=" px-6">
            <div>
                <h1 class="text-2xl text-center font-semibold">Welcome, <span
                        class="text-indigo-500">{{ Auth::user()->name }}</span></h1>
            </div>
            <div class="mt-4">
                @if (session('success'))
                    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                        role="alert">
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif
                <form wire:submit="save">
                    <div class="mb-3">
                        <label for="title"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Title</label>
                        <input wire:model="form.title" type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            id="title">
                        <div>
                            @error('form.title')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="content"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Content</label>
                        <textarea wire:model.live="form.content" type="text" rows="5"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            id="content">
                    </textarea>
                        <div
                            class="text-sm mt-1 text-right {{ strlen($form->content) > 250 ? 'text-red-600' : 'text-gray-500' }}">
                            {{ strlen($form->content) }} / 500 characters
                        </div>
                        <div>
                            @error('form.content')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="flex justify-between gap-1">
                        <div class="mb-3 w-full md:w-1/2">
                            <label for="status"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Status</label>
                            <select id="status" wire:model="form.status"
                                class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @foreach (\App\Enums\StatusType::cases() as $status)
                                    <option value="{{ $status->value }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                            <div>
                                @error('form.status')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 w-full md:w-1/2">
                            <label for="slug"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Scheduled
                                time</label>
                            <input wire:model="form.scheduled_time" id = 'datepicker' datepicker type="text"
                                class="flatpickr bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <div>
                                @error('form.scheduled_time')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div wire:ignore class="mt-3">
                        <label for="platforms"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Platforms</label>
                        <select wire:model="form.platforms" multiple id="platforms"class="w-full select-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @foreach ($platforms as $platform)
                                <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-3">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-dark">Upload
                            Image</label>
                        <input wire:model="form.image"
                            class="p-4  block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            type="file">
                        @if ($form->image)
                            <img class="w-18 h-18 rounded-md p-4" src="{{ $form->image->temporaryUrl() }}">
                        @endif
                        @if ($post->image_url && !$form->image)
                            <img class="w-18 h-18 rounded-md p-4" src="{{ asset('storage/' . $post->image_url) }}">
                        @endif
                        @error('image')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3 pt-4 flex justify-between">
                        <button type="submit"
                            class="flex py-2 px-4 bg-indigo-500 hover:bg-indigo-600 text-black rounded-md">Submit
                            <div wire:loading>
                                <svg aria-hidden="true"
                                    class="w-5 h-5 mx-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                        fill="currentColor" />
                                    <path
                                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                        fill="currentFill" />
                                </svg>
                                <span class="sr-only">Loading...</span>
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @script()
        <script>
            flatpickr(".flatpickr", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                onChange: function(selectedDates, dateStr, instance) {
                    @this.set('form.scheduled_time', dateStr);
                }
            })

            $(document).ready(function() {
                $('#platforms').select2();
                $('#platforms').on('change', function() {
                    let data = $(this).val();
                    console.log(data);
                    @this.form.platforms = data;
                });
            });
        </script>
    @endscript
</div>
