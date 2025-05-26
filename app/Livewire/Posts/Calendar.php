<?php

namespace App\Livewire\Posts;

use App\Http\Traits\ApiResponser;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Calendar extends Component
{
    use ApiResponser;
    public $start;
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.posts.calendar', ['posts' => Post::all()->map(function ($q) {
            return [
                'title' => $q->title,
                'start' => $q->scheduled_time
            ];
        })]);
    }

    public function posts(Request $request)
    {
        Cache::flush();
        $posts = Cache::remember(
            "calendar_events_{$request->start}_{$request->end}",
            60,
            fn() => Post::filter($request->query())
                ->get()
                ->map(fn($post) => [
                    'title' => $post->title,
                    'start' => $post->scheduled_time,
                ])
        );
        return $this->success($posts);
    }
}
