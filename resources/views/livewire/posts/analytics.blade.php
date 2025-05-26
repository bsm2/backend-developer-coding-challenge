<div>
    <div class ="flex flex-col items-center gap-10 m-7">
        @foreach ($postsGroup as $group)
            <h1 class="text-white bold text-md-center">{{ $group->name }}</h1>
            <div class="w-8/12 p-4 flex justify-between rounded-md bg-slate-200 shadow-md">
                @foreach (\App\Enums\StatusType::cases() as $status)
                    <div class="flex flex-col justify-center items-center">
                        <span @class([
                            'w-16 h-16 flex justify-center items-center rounded-full text-lg text-black border-2',
                            $status->color() => $status,
                        ])>
                            {{ $group->{$status->value} }}
                        </span>
                        <span class="text-black">{{ Str::of($status->value)->headline() }}</span>
                    </div>
                @endforeach
            </div>
        @endforeach

    </div>
</div>
