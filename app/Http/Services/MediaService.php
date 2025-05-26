<?php

namespace App\Http\Services;

use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaService
{
    /**
     * Summary of store
     * @param \Illuminate\Http\UploadedFile $media
     * @return string
     */
    public function store(UploadedFile $media): string
    {
        $name = $media->hashName();
        $path =  $media->storeAs('posts/images', $name, 'public');
        return $path;
    }

    public function update($request, $media,Post $post)
    {
        if ($media) {
            $this->delete($post->image_url);
            return $this->store($media);
        }

        if (!$media && $request->boolean('delete_image')) {
            $this->delete($post->image_url);
            return null;
        }
        return $post->image_url;
    }

    public function delete(string|null $url)
    {
        if ($url && Storage::disk('public')->exists($url)) {
            Storage::disk('public')->delete($url);
        }
    }
}
