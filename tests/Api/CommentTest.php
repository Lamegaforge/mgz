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
            ->has(Comment::factory()->count(2), 'childs')
            ->create();

        $response = $this->get('api/comments/list/' . $comment->id);

        $childs = $comment->childs;

        $response
            ->assertStatus(200)
            ->assertJsonPath('comments.0.id', $comment->id)
            ->assertJsonPath('comments.0.childs.0.id', $childs->first()->id)
            ->assertJsonPath('comments.0.childs.1.id', $childs->last()->id);
    }
}
