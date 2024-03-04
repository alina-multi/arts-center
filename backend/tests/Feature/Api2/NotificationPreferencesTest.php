<?php

use App\Models\{User, NotificationPreference, Comment};
use App\Enums\{NotificationTypes, NotificationChannels};
use App\Notifications\{NewWorkComment};
use function Pest\Laravel\{actingAs, assertDatabaseHas, assertDatabaseCount};

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('Notification preferences validation', function () {
    $user = User::factory()->create();
    actingAs($user)->putJson('/api2/notification-preferences', [
        'preferences' => [
            [
                'type' => 0,
                'channel' => 0
            ]
        ]
    ])->assertInvalid(['preferences.0.type', 'preferences.0.channel']);
});

test('Notification preferences update', function () {
    $user = User::factory()->create();

    // This should be removed after update
    NotificationPreference::create([
        'user_id' => $user->id,
        'type' => NotificationTypes::FeaturedPosts,
        'channel' => NotificationChannels::Mail
    ]);
    actingAs($user)->putJson('/api2/notification-preferences', [
        'preferences' => [
            [
                'type' => NotificationTypes::SiteNews,
                'channel' => NotificationChannels::Mail
            ]
        ]
    ])->assertNoContent();

    // Check that we replace and not add preferences
    assertDatabaseCount('notification_preferences', 1);
    assertDatabaseHas('notification_preferences', [
        'user_id' => $user->id,
        'type' => NotificationTypes::SiteNews->value,
        'channel' => NotificationChannels::Mail->value
    ]);

    // Empty array should be valid (remove all preferences)
    actingAs($user)->putJson('/api2/notification-preferences', [
        'preferences' => []
    ])->assertNoContent();
    assertDatabaseCount('notification_preferences', 0);
});

test('Notification preferences works', function () {
    $user = User::factory()->create();

    $comment = Comment::factory()->create();
    $notification = new NewWorkComment($comment);
    function checkNotification($notification, User $user, array $expectedArray)
    {
        $via = $notification->via($user);
        expect($via)->toEqualCanonicalizing($expectedArray);
    }

    checkNotification($notification, $user, ['mail', 'broadcast', 'database']);

    $user->notificationPreferences()->create(['type' => NotificationTypes::MyContentComment, 'channel'=> NotificationChannels::Mail]);
    checkNotification($notification, $user, ['broadcast', 'database']);

    $user->notificationPreferences()->create(['type' => NotificationTypes::MyContentComment, 'channel'=> NotificationChannels::Web]);
    checkNotification($notification, $user, []);
});

test('Get notification preferences', function () {
    [$user, $user2] = User::factory()->count(2)->create();
    $user->notificationPreferences()->create(['type' => NotificationTypes::MyContentComment, 'channel'=> NotificationChannels::Mail]);
    $user2->notificationPreferences()->create(['type' => NotificationTypes::MyContentVote, 'channel'=> NotificationChannels::Web]);
    actingAs($user)->getJson('/api2/notification-preferences')->assertExactJson([
        'preferences'=> [
            ['type' => NotificationTypes::MyContentComment->value, 'channel'=> NotificationChannels::Mail->value]
        ]
    ]);
});

