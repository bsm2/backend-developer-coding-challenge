<?php
namespace App\Http\Services\Social;

use App\Models\Post;

interface SocialPosterInterface
{
    public function publish(Post $post): bool;
}
