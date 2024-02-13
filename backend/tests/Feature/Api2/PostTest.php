<?php

use App\Models\{User, Work, Image, Post};


uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('Create post', function () {
    $user = User::factory()->create();
    $this->actingAs($user)->postJson('/api2/post')->assertCreated();
    $this->assertDatabaseHas('posts', [
        'user_id' => $user->id,
    ]);
});


test('Delete post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create([
        'user_id' => $user->id,
    ]);
    $this->actingAs($user)->deleteJson('/api2/post/' . $post->id)->assertNoContent();
    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'deleted_at' => now(),
    ]);
});

test('Save post', function () {
    [$user, $wrongUser] = User::factory()->count(2)->create();
    $post = Post::factory()->create(['user_id' => $user->id]);
    $image = Image::factory()->create();
    $work = Work::factory()->create();

    $validBody = [
        'title' => 'test title',
        'language' => 'en',
        'body' => [
            [
                'type' => 'text',
                'text' => 'test text',
            ],
            [
                'type' => 'image',
                'image_id' => $image->id,
            ],
            [
                'type' => 'work',
                'works' => [$work->id]
            ],
        ]
    ];
    // Can't edit another user's post.
    $this->actingAs($wrongUser)->putJson("/api2/post/{$post->id}", $validBody)->assertForbidden();

    // Required fields
    $this->actingAs($user)->putJson("/api2/post/{$post->id}", [
        'body' => [
            [
                'type' => 'text',
                'image_id' => 666,
            ],
            [
                'type' => 'image',
                'text' => 'test text',
            ],
            [
                'type' => 'work',
            ],
        ]
    ])->assertInvalid([
        'title', 'body.0.text', 'body.1.image_id', 'body.2.works', 'language'
    ]);

    // Test work and image fields exist
    $this->actingAs($user)->putJson("/api2/post/{$post->id}", [
        'title' => 'test title',
        'body' => [
            [
                'type' => 'text',
                'text' => 'test text',
            ],
            [
                'type' => 'image',
                'image_id' => 666,
            ],
            [
                'type' => 'work',
                'works' => [666]
            ],
        ]
    ])->assertInvalid(['body.1.image_id', 'body.2.works.0']);
    $this->actingAs($user)->putJson("/api2/post/{$post->id}", $validBody)->assertOk();
    \Pest\Laravel\assertDatabaseHas('posts', [
        'title' => 'test title',
        'body' => json_encode([
            [
                'type' => 'text',
                'text' => 'test text',
            ],
            [
                'type' => 'image',
                'image_id' => $image->id,
            ],
            [
                'type' => 'work',
                'works' => [$work->id]
            ],
        ]),
    ]);
});