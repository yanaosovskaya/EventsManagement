<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class WidgetServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        \Blade::directive('widget', function ($name) {
            return "<?php echo app('widget')->show($name); ?>";
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        \App::singleton('widget', function () {
            return new \App\Widgets\Widget();
        });
    }
}
