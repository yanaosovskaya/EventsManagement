<?php

namespace App\Providers;

use App\Models\Snippet;
use App\Services\SlugService;
use Illuminate\Support\ServiceProvider;

class SnippetServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->getGlobalSnippets();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function getGlobalSnippets()
    {
        $uri = \Route::getRoutes()->match(request())->uri;

        if (!app()->runningInConsole()) {
            \View::share('headerSnippets', SlugService::currentSnippets($uri, Snippet::LOCATION_HEADER));
            \View::share('footerSnippets', SlugService::currentSnippets($uri, Snippet::LOCATION_FOOTER));
        }
    }
}
