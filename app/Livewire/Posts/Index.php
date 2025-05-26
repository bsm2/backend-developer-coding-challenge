<?php

namespace App\Livewire\Posts;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

class Index extends Component
{
    #[Url()]
    public $status;
    #[Layout('layouts.app')]
    public function render()
    {
        $user = User::find(request()->user()->id);

        return view('livewire.posts.index', [
            'posts' => $user->posts()->filter(['status' => $this->status])->latest()->paginate(10),
        ]);
    }
}
