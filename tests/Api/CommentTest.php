<?php

namespace Tests\Api;

use Tests\TestCase;
use App\Models\Clip;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CommentTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function get_clip_comments()
    {
        $children = Comment::factory()
            ->state(new Sequence(
                ['approved_at' => '2020-01-01'],
                ['approved_at' => '2020-01-02'],
            ))
            ->count(2);

        $comment = Comment::factory()
            ->has($children, 'children')
            ->create();

        $response = $this->get('api/comments/search/' . $comment->id);

        $children = $comment->children;

        $response
            ->assertStatus(200)
            ->assertJsonPath('comments.0.id', $comment->id)
            ->assertJsonPath('comments.0.children.1.id', $children->last()->id)
            ->assertJsonPath('comments.0.children.1.user.id', $children->last()->user->id)
            ->assertJsonPath('comments.0.children.0.id', $children->first()->id);
    }

    /**
     * @test
     */
    public function get_user_comments()
    {
        $comment = Comment::factory()->create();

        $response = $this->get('api/comments/user/' . $comment->user->id);

        $response
            ->assertStatus(200)
            ->assertJsonPath('comments.data.0.id', $comment->id);
    }

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
