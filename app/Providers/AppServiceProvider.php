<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Services\MediaService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale('fr_FR');

        Blade::directive('datetime', function ($carbon) {
            return "<?php echo ($carbon)->isoFormat('LL'); ?>";
        });

        Blade::directive('cardVignette', function ($media) {
            return app(MediaService::class)->vignette($media);
        });

        Blade::directive('cardLogo', function ($media) {
            return app(MediaService::class)->logo($media);
        });

        Blade::directive('cardSmallLogo', function ($media) {
            return app(MediaService::class)->smallLogo($media);
        });

        Blade::directive('cardVignette', function ($media) {
            return app(MediaService::class)->vignette($media);
        });
    }
}
