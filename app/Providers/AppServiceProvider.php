<?php

namespace App\Providers;

use View;
use Carbon\Carbon;
use App\View\Components;
use Illuminate\Http\Request;
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

        Blade::component('meta', Components\Meta::class);

        Request::macro('auth', function () {
            return (bool) $this->user();
        });
    }
}
