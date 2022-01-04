<?php

namespace Tests\Feature;

use App\Comment;
use App\Feed;
use App\Follow;
use App\Jobs\RecountUserRatings;
use App\Tag;
use App\TagTitle;
use App\Vote;
use App\Work;
use App\WorkTitle;
use Carbon\Carbon;
use Illuminate\Broadcasting\BroadcastEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Bus;

class FeedTest extends TestCase
{
    use RefreshDatabase;

    function testAddComment()
    {
        Bus::fake();
        list ($workOwner, $commentOwner, $workSubscriber, $userSubscriber, $subscribedToBoth, $notSubscribed) = User::factory()->count(
            6
        )->create();
        $work = Work::factory()->create();
        $work->owners()->attach($workOwner->id);

        // Subscribed to work that we comment on
        $this->follow($workSubscriber->id, 'work', $work->id);

        // Subscribed to owner of the work
        $this->follow($userSubscriber->id, 'user', $workOwner->id);

        // Subscribed to both
        $this->follow($subscribedToBoth->id, 'work', $work->id);
        $this->follow($subscribedToBoth->id, 'user', $workOwner->id);

        // This should trigger the event by itself
        $comment = Comment::factory(
            ['user_id' => $commentOwner->id, 'commentable_type' => 'work', 'commentable_id' => $work->id]
        )->create();

        // All users should now have records in feed
        foreach ([$workSubscriber, $userSubscriber, $subscribedToBoth] as $user) {
            $this->assertDatabaseHas('feeds', [
                'feedable_id' => $comment->id,
                'feedable_type' => 'comment',
                'user_id' => $user->id
            ]);
        }
        // Check that user that is not subscribed don't receive stuff
        $this->assertDatabaseMissing('feeds', [
            'user_id' => $notSubscribed->id
        ]);
        // Check that total number of records is 3 (checking there are no duplicates for user who subscribed to both
        $this->assertDatabaseCount('feeds', 3);
        // And that it's broadcasted 3 times
        Bus::assertDispatchedTimes(BroadcastEvent::class, 3);
    }

    public function testPublishWork()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        Bus::fake();
        list ($workOwner, $subscriber1, $subscriber2, $notSubscribed) = User::factory()->count(
            6
        )->create();
        $work = Work::factory()->create();
        $work->owners()->attach($workOwner->id);

        // Both follow
        $this->follow($subscriber1->id, 'user', $workOwner->id);
        $this->follow($subscriber2->id, 'user', $workOwner->id);

        $work->published_at = $now;
        $work->show_en = 1;
        // This should trigger feed creation for subscribers
        $work->save();

        // All users should now have records in feed
        foreach ([$subscriber1, $subscriber2] as $user) {
            $this->assertDatabaseHas('feeds', [
                'feedable_id' => $work->id,
                'feedable_type' => 'work',
                'user_id' => $user->id
            ]);
        }
        // Check that user that is not subscribed don't receive stuff
        $this->assertDatabaseMissing('feeds', [
            'user_id' => $notSubscribed->id
        ]);
        // Check that total number of records is 3 (checking there are no duplicates for user who subscribed to both
        $this->assertDatabaseCount('feeds', 2);
        // And that it's broadcasted 3 times
        Bus::assertDispatchedTimes(BroadcastEvent::class, 2);
    }

    public function testFeedApi()
    {
        Bus::fake();
        $user = User::factory()->create();
        // They will be in reverse order
        Feed::factory(['user_id' => $user->id])->work()->create();
        Feed::factory(['user_id' => $user->id])->commentTowork()->create();

        $this->actingAs($user)->getJson('/api/feed/en')
            ->assertJson(fn(AssertableJson $json) => $json
                ->has('feeds', 2)
                ->has('feeds.0.comment.id')
                ->where('feeds.0.work',2)
                ->where('feeds.1.comment', null)
                ->where('feeds.1.work', 1)
                ->has('users', 3)
                ->has('works', 2)
            );
    }

    public function follow($user_id, $followable_type, $followable_id)
    {
        Follow::factory(
            ['user_id' => $user_id, 'followable_type' => $followable_type, 'followable_id' => $followable_id]
        )->create();
    }
}
