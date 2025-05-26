<?php

namespace App\Http\Services;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PublishService
{

    protected PublishStrategy $strategy;

    public function setStrategy(PublishStrategy $strategy): void
    {
        $this->strategy = $strategy;
    }

    public function publish(array $post): string
    {
        return $this->strategy->publish($post);
    }
}
