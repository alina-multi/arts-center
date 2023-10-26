<?php

namespace App\Nova\Actions;

use App\Models\Post;
use App\Models\User;
use App\Notifications\BlogPostContent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class SendBlogPost extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param \Laravel\Nova\Fields\ActionFields $fields
     * @param \Illuminate\Support\Collection $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $post = Post::firstOrFail('id', $fields['post']);
        $models->each(fn(User $user) => $user->notify(new BlogPostContent($post)));
    }

    /**
     * Get the fields available on the action.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        $lastPosts = Post::orderBy('published_at', 'desc')
            ->get()
            ->mapWithKeys(fn(Post $post) => [$post->id => $post->title])->toArray();

        return [
            Select::make('Post')->options($lastPosts)->required(),
        ];
    }
}
