<?php

namespace App\Console\Commands;

use App\Enums\StatusType;
use App\Http\Services\Social\SocialPosterFactory;
use App\Models\Post;
use Illuminate\Console\Command;

class PublishPost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:publish-post';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish scheduled posts';

    /**
     * Execute the console command.
     */
    public function handle(SocialPosterFactory $factory)
    {
        Post::where('scheduled_time', date('Y-m-d H:i'))->get();
        $now = now();
        $processedPostIds = [];


        Post::where('scheduled_time', '<=', $now)->where('status', StatusType::SCHEDULED)
            ->whereHas('platforms', fn($q) => $q->where('platform_status', 'active'))
            ->chunk(100, function ($posts) use ($factory, &$processedPostIds) {
                foreach ($posts as $post) {
                    $success = true;
                    foreach ($post->platforms as $platform) {
                        try {
                            $poster = $factory->make($platform->type);
                            $poster->publish($post);

                            logger()->info("Published to $platform: Post #{$post->id}");
                            sleep(1);
                        } catch (\Throwable $e) {
                            $success = false;
                            logger()->error("Failed to post to $platform for Post #{$post->id}: {$e->getMessage()}");
                        }
                    }
                    if ($success) {
                        $processedPostIds[] = $post->id;
                    }
                }
            });

        if (!empty($processedPostIds)) {
            Post::whereIn('id', $processedPostIds)->update(['status' => 'published']);
        }
    }
}
