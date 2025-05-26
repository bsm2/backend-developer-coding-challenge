<?php

namespace App\Livewire\Posts;

use App\Models\Platform;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Analytics extends Component
{
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.posts.analytics', [
            'postsGroup' => Platform::withCount([
                'posts as total' => fn($q) => $q->where('user_id', request()->user()->id),
                'posts as draft' => fn($q) => $q->where('user_id', request()->user()->id)->where('status', 'draft'),
                'posts as scheduled' => fn($q) => $q->where('user_id', request()->user()->id)->where('status', 'scheduled'),
                'posts as published' => fn($q) => $q->where('user_id', request()->user()->id)->where('status', 'published')
            ])->orderByDesc('total')->get(),
        ]);
    }
}
