<?php

namespace Intelliants\LaravelSitemap;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class LaravelSitemapServiceProvider extends IlluminateServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-sitemap');

        $this->app->singleton('laravelsitemap', function () {
            //echo 'INIT';
            return new LaravelSitemap(new Writer());
        });
//echo 'SERV.PROV';
        $this->app->alias('laravelsitemap', LaravelSitemap::class);
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('laravel-sitemap.php'),
        ], 'config');
    }

    protected function registerCommands()
    {
        $this->app->singleton('laravelsitemap.generate', Commands\SitemapGenerationCommand::class);

        $this->commands(['laravelsitemap.generate']);
    }
}
