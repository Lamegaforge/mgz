<?php

namespace Tests\Api;

use Tests\TestCase;
use App\Models\Comment;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CommentTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function get_clip_comments()
    {
        $comment = Comment::factory()
            ->has(Comment::factory()->count(2), 'children')
            ->create();

        $response = $this->get('api/comments/search/' . $comment->id);

        $children = $comment->children;

        $response
            ->assertStatus(200)
            ->assertJsonPath('comments.0.id', $comment->id)
            ->assertJsonPath('comments.0.children.0.id', $children->first()->id)
            ->assertJsonPath('comments.0.children.1.id', $children->last()->id);
    }
}
