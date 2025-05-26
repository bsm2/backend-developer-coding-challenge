<?php

namespace App\Http\Services;

use App\Models\Post;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PostService
{
    public function __construct(protected MediaService $mediaService) {}

    public function store($request)
    {
        $user = $request->user();
        if ($user->posts()->whereDate('created_at', now())->count() >= 10) {
            throw new AccessDeniedHttpException("You exceed your limit today");

        }
        $validated = collect($request->validated())->except('image', 'platforms')->toArray();
        $validated['user_id'] = $user->id;
        if ($request->file('image')) {
            $validated['image_url'] = $this->mediaService->store($request->image);
        }
        $userPlatforms = $user->platforms()->where('active', 1)->pluck('platforms.id')->toArray();
        $syncData = [];

        foreach ($request->platforms as $platform) {
            $syncData[$platform] = [
                'platform_status' => in_array( $platform, $userPlatforms) ? 'active' : 'innactive'
            ];
        }
        $post = Post::create($validated);
        $post->platforms()->sync($syncData);
    }

    public function posts($request)
    {
        return $request->user()->posts()->filter($request->query())->paginate(10);
    }
    /**
     * Summary of update
     * @param mixed $request
     * @return void
     */
    public function update($request, $post)
    {
        if ($post->user_id != $request->user()->id) {
            throw new ModelNotFoundException();
        }
        if ($post->status == 'published') {
            throw ValidationException::withMessages([
                'status' => 'Post already published',
            ]);
        }
        $validated = collect($request->validated())->except('image')->toArray();
        $validated['user_id'] = $request->user()->id;
        $validated['image_url'] = $this->mediaService->update($request, $request->image, $post);

        $post->update($validated);
        $post->platforms()->sync($request->platforms);
    }

    /**
     * Summary of update
     * @param mixed $request
     * @return void
     */
    public function delete($post)
    {
        if ($post->user_id != request()->user()->id) {
            throw new ModelNotFoundException();
        }
        if ($post->status == 'published') {
            throw ValidationException::withMessages([
                'status' => 'Post already published',
            ]);
        }
        $post->platforms()->detach();
        $this->mediaService->delete($post->image_url);
        $post->delete();
    }
}
