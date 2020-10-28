<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Clip;
use App\Models\Card;
use App\Jobs\ProcessAchievements; 
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class ProcessAchievementsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function expect_empty()
    {
        $this->artisan('db:seed');

        $user = User::factory()->create();

        ProcessAchievements::dispatchNow($user);

        $this->assertEmpty($user->achievements->empty());
    }

    /**
     * @test
     */
    public function expect_achievements()
    {
        $this->artisan('db:seed');
        
        $user = User::factory()->create();

        $this->addAchievementsRequirement($user);

        ProcessAchievements::dispatchNow($user);

        $user->refresh();

        $slugs = $user->achievements->pluck('slug');

        $this->assertContains('valerie_damidot', $slugs);
        $this->assertContains('compulsive_clipper', $slugs);
        $this->assertContains('famous', $slugs);
        $this->assertContains('fifty_active_clips', $slugs);
        $this->assertContains('hundred_active_clips', $slugs);
        $this->assertContains('one_hundred_fifty_active_clips', $slugs);
        $this->assertContains('seventy_active_clips', $slugs);
        $this->assertContains('ten_active_clips', $slugs);
        $this->assertContains('thirty_active_clips', $slugs);
        $this->assertContains('thousand_views_all_clips', $slugs);
        $this->assertContains('three_thousand_views_all_clips', $slugs);
        $this->assertContains('two_thousand_views_all_clips', $slugs);
    }

    protected function addAchievementsRequirement(User $user): void
    {
        $this->addValerieDamidotRequirement($user);
        $this->addCompulsiveClipperRequirement($user);
        $this->addFamousRequirement($user);
        $this->addILoveThisGameRequirement($user);
        $this->addClipsRequirement($user);
    }

    protected function addValerieDamidotRequirement(User $user): void
    {
        $user->update([
            'description' => 'qsdsq',
            'banner_image_slug' => 'qsdsq',
            'youtube' => 'qsdsq',
        ]);
    }

    protected function addCompulsiveClipperRequirement(User $user): void
    {
        Clip::factory()->times(7)->create([
            'user_id' => $user->id,
        ]);
    }

    protected function addFamousRequirement(User $user): void
    {
        Clip::factory()->create([
            'views' => 500,
            'user_id' => $user->id,
        ]);
    }

    protected function addILoveThisGameRequirement(User $user): void
    {
        Card::factory()
            ->hasClips(10, [
                'user_id' => $user->id,
            ])
            ->create();
    }

    protected function addClipsRequirement(User $user): void
    {
        Clip::factory()->times(150)->create([
            'user_id' => $user->id,
            'views' => 10,
        ]);
    }
}