<?php

namespace Cher4geo35\Sliders;

use App\Review;
use Cher4geo35\Sliders\Filters\CertificatesSlider;
use Cher4geo35\Sliders\Filters\ImageXs;
use Cher4geo35\Sliders\Filters\ImageSm;
use Cher4geo35\Sliders\Filters\ImageMd;
use Cher4geo35\Sliders\Filters\ImageLg;
use Cher4geo35\Sliders\Filters\ImageXl;
use Cher4geo35\Sliders\Filters\BasicXs;
use Cher4geo35\Sliders\Filters\BasicSm;
use Cher4geo35\Sliders\Filters\BasicMd;
use Cher4geo35\Sliders\Filters\BasicLg;
use Cher4geo35\Sliders\Filters\BasicXl;
use Cher4geo35\Sliders\Console\Commands\SlidersMakeCommand;
use Cher4geo35\Sliders\Observers\ReviewObserver;
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
            __DIR__ . '/resources/js/components' => resource_path('js/components/vendor/sliders'),
        ], 'public');

        $imagecache = app()->config['imagecache.paths'];
        $imagecache[] = 'storage/slides';
        app()->config['imagecache.paths'] = $imagecache;

        $imagecache = app()->config['imagecache.templates'];
        $imagecache['certificates-slider'] = CertificatesSlider::class;

        $imagecache['image-xs'] = ImageXs::class;
        $imagecache['image-sm'] = ImageSm::class;
        $imagecache['image-md'] = ImageMd::class;
        $imagecache['image-lg'] = ImageLg::class;
        $imagecache['image-xl'] = ImageXl::class;

        $imagecache['basic-xs'] = BasicXs::class;
        $imagecache['basic-sm'] = BasicSm::class;
        $imagecache['basic-md'] = BasicMd::class;
        $imagecache['basic-lg'] = BasicLg::class;
        $imagecache['basic-xl'] = BasicXl::class;

        app()->config['imagecache.templates'] = $imagecache;

        if (class_exists(ReviewObserver::class) && class_exists(Review::class)) {
            Review::observe(ReviewObserver::class);
        }

    }

    public function register()
    {

    }
}
