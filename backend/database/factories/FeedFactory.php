<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Feed;
use App\Models\User;
use App\Models\Work;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Feed::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

        ];
    }

    public function work()
    {
        $work = Work::factory()->create();
        $workOwner = User::factory()->create();

        $work->owners()->attach($workOwner);
        return $this->state(function (array $attributes) use ($work) {
            return [
                'feedable_id' => $work->id,
                'feedable_type' => $work->getMorphClass()
            ];
        });
    }

    public function commentToWork()
    {
        $work = Work::factory()->create();
        $workOwner = User::factory()->create();

        $work->owners()->attach($workOwner);

        $commentOwner = User::factory()->create();
        $comment = Comment::factory(
            ['commentable_type' => 'work', 'commentable_id' => $work->id, 'user_id' => $commentOwner->id]
        )->create();
        return $this->state(function (array $attributes) use ($comment) {
            return [
                'feedable_id' => $comment->id,
                'feedable_type' => $comment->getMorphClass()
            ];
        });
    }
}
