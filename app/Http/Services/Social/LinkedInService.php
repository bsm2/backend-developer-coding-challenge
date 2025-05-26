<?php

namespace App\Http\Services\Social;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LinkedInService implements SocialPosterInterface
{
    /**
     * Summary of publish
     * @param \App\Models\Post $post
     * @return bool
     */
    public function publish(Post $post): bool
    {
        return true;
    }
}
