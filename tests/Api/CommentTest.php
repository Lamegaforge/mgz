<?php

namespace Tests\Api;

use Tests\TestCase;
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
}
