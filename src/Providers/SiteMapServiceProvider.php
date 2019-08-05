<?php

namespace Artjoker\Sitemap\Providers;

use Artjoker\Sitemap\Commands\LoadUrlsCommand;
use Artjoker\Sitemap\Commands\SiteMapGeneratorCommand;
use Illuminate\Support\ServiceProvider;

class SiteMapServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'sitemap');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'sitemap');
        $this->commands([
            SiteMapGeneratorCommand::class,
            LoadUrlsCommand::class
        ]);

        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/sitemap'),
        ], 'sitemap-lang');

        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/sitemap'),
        ], 'sitemap-styles');

        $this->publishes([
            __DIR__.'/../config/sitemap.php' => config_path('sitemap.php'),
        ], 'sitemap-config');

        $this->publishes([
            __DIR__.'/../database/migrations' => base_path('database/migrations'),
        ], 'sitemap-migrations');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/sitemap'),
        ], 'sitemap-views');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/sitemap.php', 'sitemap'
        );
    }
}