<?php

namespace App\Livewire\Forms;

use App\Models\Post;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PostForm extends Form
{
    public ?Post $post;
    #[Validate('required|string|max:255')]
    public string $title;

    #[Validate('required|string|max:500')]
    public string $content;
    #[Validate('required|string|in:draft,scheduled')]
    public string $status;
    #[Validate('nullable|date_format:Y-m-d H:i|after:today')]
    public string $scheduled_time;
    #[Validate('nullable|image')]
    public  $image;
    public  $platforms;
}
