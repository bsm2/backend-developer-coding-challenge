<?php

namespace App\Http\Services\Social;
use InvalidArgumentException;

class SocialPosterFactory
{
    public function make(string $platform): SocialPosterInterface
    {
        return match ($platform) {
            'linkedin' => new LinkedInService(),
            'instagram' => new InstagramService(),
            'twitter' => new TwitterService(),
            default => throw new InvalidArgumentException("Unsupported platform: $platform"),
        };
    }
}
