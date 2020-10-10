<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Clip;
use App\Models\Comment;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CommentTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function guest_cannot_store_comment()
    {
        $clip = Clip::factory()->create();

        $response = $this->post('api/comments/store', [
            'clip_id' => $clip->id,
            'content' => 'content',
        ]);

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function auth_can_store_comment()
    {
        $user = User::factory()->create();
        $clip = Clip::factory()->create();

        $response = $this->actingAs($user)->post('api/comments/store', [
            'clip_id' => $clip->id,
            'content' => 'content',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('comments', [
            'clip_id' => $clip->id,
            'user_id' => $user->id,
            'content' => 'content',
            'parent_comment_id' => null,
        ]);
    }

    /**
     * @test
     */
    public function auth_can_store_sub_comment()
    {
        $user = User::factory()->create();
        $clip = Clip::factory()->create();
        $comment = Comment::factory()->create();

        $response = $this->actingAs($user)->post('api/comments/store', [
            'clip_id' => $clip->id,
            'parent_comment_id' => $comment->id,
            'content' => 'content',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('comments', [
            'clip_id' => $clip->id,
            'user_id' => $user->id,
            'content' => 'content',
            'parent_comment_id' => $comment->id,
        ]);
    }
}
