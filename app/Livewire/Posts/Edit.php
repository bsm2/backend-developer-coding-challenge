<?php

namespace App\Livewire\Posts;

use App\Http\Services\MediaService;
use App\Livewire\Forms\PostForm;
use App\Models\Platform;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Console\View\Components\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public PostForm $form;

    public $post;

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->form->title = $post->title;
        $this->form->content = $post->content;
        $this->form->status = $post->status;
        $this->form->scheduled_time = Carbon::parse($post->scheduled_time)->format('Y-m-d H:i');
        $this->form->platforms = $post->platforms()->pluck('platforms.id')->toArray();
    }
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.posts.edit', ['platforms' => Platform::all()]);
    }

    public function save(Request $request)
    {
        $this->validate();
        if ($this->post->status == 'published') {
            throw ValidationException::withMessages([
                'status' => 'Post already published',
            ]);
        }
        $mediaService = new MediaService();
        $validated = $this->form->all();
        $validated['user_id'] = request()->user()->id;
        $validated['image_url'] = $mediaService->update($request, $this->form->image, $this->post);

        $this->post->update($validated);
        $this->post->platforms()->sync($this->form->platforms);
        session()->flash('success', 'Post successfully updated.');
    }
}
