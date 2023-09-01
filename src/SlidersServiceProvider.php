<?php

namespace Cher4geo35\Sliders;

use Cher4geo35\Sliders\Filters\CertificatesSlider;
use Cher4geo35\Sliders\Console\Commands\SlidersMakeCommand;
use Illuminate\Support\ServiceProvider;

class SlidersServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Подгрузка миграций.
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

         // Подгрузка шаблонов.
         $this->loadViewsFrom(__DIR__ . '/resources/views', 'sliders');

        // Подгрузка роутов.
        $this->loadRoutesFrom(__DIR__ . '/routes/admin.php');
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        // Console.
        if ($this->app->runningInConsole()) {
            $this->commands([
                SlidersMakeCommand::class,
            ]);
        }

        $this->publishes([
            __DIR__ . '/resources/js/scripts' => resource_path('js/vendor/sliders'),
            __DIR__ . '/resources/sass' => resource_path('sass/vendor'),
        ], 'public');

        $imagecache = app()->config['imagecache.paths'];
        $imagecache[] = 'storage/slides';
        app()->config['imagecache.paths'] = $imagecache;

        $imagecache = app()->config['imagecache.templates'];
        $imagecache['certificates-slider'] = CertificatesSlider::class;
        app()->config['imagecache.templates'] = $imagecache;

    }

    public function register()
    {

    }
}
