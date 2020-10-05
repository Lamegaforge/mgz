<?php

namespace Database\Seeders;

use App\Models\Clip;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
	    Clip::factory()
			->times(50)
			->create();
    }
}
