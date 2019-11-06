<?php

namespace App\Providers;

use App\Contracts\Menu\MenuContract;
use App\Contracts\Menu\MenuContractInterface;
use App\Contracts\Snippet\SnippetContract;
use App\Contracts\Snippet\SnippetContractInterface;
use App\Services\Captcha;
use App\Services\SettingService;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Schema::defaultStringLength(191);

        if (!$this->app->runningInConsole()) {
            $this->bladeDirectives();
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(IdeHelperServiceProvider::class);
        }

        $this->app->bind('setting', function () {
            return new SettingService();
        });

        $this->app->bind('captcha', function () {
            return new Captcha();
        });

        $this->app->bind(MenuContractInterface::class, MenuContract::class);
        $this->app->bind(SnippetContractInterface::class, SnippetContract::class);
    }

    /**
     * @return void
     */
    private function bladeDirectives()
    {
        $packages = event(config('platform.event_admin_dashboard_name'));
        $hasRoleModule = in_array(config('platform.role_module_name'), array_pluck($packages, 'module'));
        $hasPageModule = in_array(config('platform.page_module_name'), array_pluck($packages, 'module'));

        \View::share('packages', $packages);
        \View::share('hasRoleModule', $hasRoleModule);
        \View::share('hasPageModule', $hasPageModule);

        \Blade::directive('userCan', function ($expression) {
            return "<?php if (!\$hasRoleModule || (\$hasRoleModule && \\Permission::hasAnyPermission({$expression}))) : ?>";
        });
        \Blade::directive('endUserCan', function () {
            return "<?php endif; ?>";
        });
    }
}
