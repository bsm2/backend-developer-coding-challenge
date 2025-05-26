<?php

namespace App\Http\Services;

use App\Models\Platform;
use App\Models\PostPlatform;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PlatformService
{
    /**
     * Summary of platforms
     * @param mixed $request
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function platforms()
    {
        return Platform::with(['users' => fn($q) => $q->where('user_id', request()->user()->id)->select('user_platforms.active')])->paginate(10);
    }

    /**
     * Summary of toggle
     * @param array $platforms
     * @return void
     */
    public function toggle(array $platforms)
    {
        $user = request()->user();
        $userPosts = $user->posts()->pluck('id')->toArray();
        $syncData = [];
        foreach ($platforms as $platform) {
            $syncData[$platform['id']] = ['active' => $platform['active']];
        }
        PostPlatform::whereIn('post_id',  $userPosts)->where('platform_id', collect($platforms)->where('active', true)->pluck('id')->toArray())->update(['platform_status' => 'active']);
        PostPlatform::whereIn('post_id',  $userPosts)->where('platform_id', collect($platforms)->where('active', false)->pluck('id')->toArray())->update(['platform_status' => 'inactive']);
        $user->platforms()->sync($syncData);
    }
}
