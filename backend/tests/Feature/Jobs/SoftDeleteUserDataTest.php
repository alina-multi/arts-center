<?php

use App\Jobs\SoftDeleteUser;
use App\Models\User;
use App\Models\Comment;
use App\Models\Work;
use Illuminate\Support\Facades\Event;
use function Pest\Laravel\assertSoftDeleted;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('it soft deletes user and related data', function () {
    Event::fake();
    // Create a user with comments and works
    $user = User::factory()->create();
    
    // Create comments (more than chunk size to test chunking)
    $comments = Comment::factory()
        ->count(2)
        ->create(['user_id' => $user->id]);
    
    // Create works and attach them to the user
    $works = Work::factory()
        ->count(2)
        ->create();
    $user->works()->attach($works->pluck('id'));

    // Execute the job
    SoftDeleteUser::dispatchSync($user);

    // Assert everything is soft deleted
    assertSoftDeleted($user);
    $works->each(fn ($work)=>assertSoftDeleted($work));
    $comments->each(fn ($comment)=>assertSoftDeleted($comment));
});
