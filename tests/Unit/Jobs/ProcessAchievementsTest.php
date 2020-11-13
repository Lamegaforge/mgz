<?php

namespace Tests\Unit;

use DB;
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

        $this->assertContains('pharos', $slugs);
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
        $this->assertContains('unloved', $slugs);
        $this->assertContains('i_am_an_idiot', $slugs);
        $this->assertContains('old_man', $slugs);
        $this->assertContains('valerie_damidot', $slugs);
        $this->assertContains('random', $slugs);

        $this->assertNotifications($user, $number = 18);

        $this->assertRemoveAchievements($user);
    }

    protected function assertRemoveAchievements(User $user)
    {
        $user->clips()->delete();

        ProcessAchievements::dispatchNow($user);

        $user->refresh();

        $slugs = $user->achievements->pluck('slug');

        $this->assertNotContains('fifty_active_clips', $slugs);
        $this->assertNotContains('hundred_active_clips', $slugs);
        $this->assertNotContains('one_hundred_fifty_active_clips', $slugs);
        $this->assertNotContains('seventy_active_clips', $slugs);
        $this->assertNotContains('ten_active_clips', $slugs);
        $this->assertNotContains('thirty_active_clips', $slugs);

        $this->assertNotifications($user, $number = 24);
    }

    protected function assertNotifications(User $user, int $number)
    {
        $unreadNotifications = $user->unreadNotifications()->count();

        $this->assertEquals($number, $unreadNotifications);
    }

    protected function addAchievementsRequirement(User $user): void
    {
        $this->addPharosRequirement($user);
        $this->addCompulsiveClipperRequirement($user);
        $this->addFamousRequirement($user);
        $this->addILoveThisGameRequirement($user);
        $this->addClipsRequirement($user);
        $this->addUnlovedRequirement($user);
        $this->addIAmAnIdiotRequirement($user);
        $this->addValerieDamidotRequirement($user);
        $this->addRandomRequirement($user);
    }

    protected function addPharosRequirement(User $user): void
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

    /**
     * Egalement OldMan achievements
     */
    protected function addFamousRequirement(User $user): void
    {
        Clip::factory()->create([
            'views' => 500,
            'user_id' => $user->id,
            'created_at' => '1992-01-01',
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

    protected function addUnlovedRequirement(User $user): void
    {
        Clip::factory()->times(20)->create([
            'user_id' => $user->id,
            'state' => 'rejected',
        ]);
    }

    protected function addIAmAnIdiotRequirement(User $user): void
    {
        $user->update([
            'youtube' => 'http://qsdsqsq',
        ]);
    }

    protected function addValerieDamidotRequirement(User $user): void
    {
        DB::table('counts')->insert([
            'user_id' => $user->id,
            'slug' => 'banner',
            'values' => 5,
        ]);
    }

    protected function addRandomRequirement(User $user): void
    {
        DB::table('counts')->insert([
            'user_id' => $user->id,
            'slug' => 'random',
            'values' => 1000,
        ]);
    }
}
