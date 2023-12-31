<?php

namespace Cher4geo35\Sliders\Console\Commands;

use App\Menu;
use App\MenuItem;
use PortedCheese\BaseSettings\Console\Commands\BaseConfigModelCommand;

class SlidersMakeCommand extends BaseConfigModelCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:sliders
                    {--all : Run all}
                    {--menu : Config menu}
                    {--models : Export models}
                    {--policies : Export and create rules}
                    {--config : Make config}
                    {--controllers : Export controllers}
                    {--scss : Export scss files}
                    {--js : Export scripts}
                    {--vue : Export vue files}
                    {--observers : Export observers}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    protected $vendorName = 'Cher4geo35';
    protected $packageName = "Sliders";

    protected $models = ['Slider', 'Slide'];

    protected $controllers = [
        "Admin" => ["SlidersController", "SlidesController"],
        'Site' => ['SlidersController'],
    ];

    protected $observers = ["ReviewObserver"];

    protected $scssIncludes = [
        "app" => [
            "settings-slick-carousel",
            "slider-certificates",
            "slider-images",
            "slider-basic",
            "slider-reviews",]
    ];

    protected $vueFolder = "sliders";
    protected $vueIncludes = [
                'app' => [
                        'add-review' => "AddReview",
                    ],
            ];

    protected $jsIncludes = [
        "app" => [
            "sliders/sliders",
        ],
    ];

    protected $configName = "sliders";
    protected $configTitle = "Слайдеры";
    protected $configTemplate = "sliders::admin.settings";
    protected $configValues = [
        'pager' => 20,
        'path' => 'sliders',
    ];

    protected $ruleRules = [
        [
            "title" => "Слайдеры",
            "slug" => "slider",
            "policy" => "SliderPolicy",
        ],
        [
            "title" => "Слайды",
            "slug" => "slide",
            "policy" => "SlidePolicy",
        ],
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $all = $this->option("all");

        if ($this->option("menu") || $all) {
            $this->makeMenu();
        }

        if ($this->option("vue") || $all) {
            $this->makeVueIncludes('app');
        }

        if ($this->option("observers") || $all) {
            $this->exportObservers();
        }

        if ($this->option("js") || $all) {
            $this->makeJsIncludes("app");
        }

        if ($this->option("models") || $all) {
            $this->exportModels();
        }

        if ($this->option("controllers") || $all) {
            $this->exportControllers("Admin");
            $this->exportControllers("Site");
        }

        if ($this->option("config") || $all) {
            $this->makeConfig();
        }

        if ($this->option("policies") || $all) {
            $this->makeRules();
        }

        if ($this->option("scss") || $all) {
            $this->makeScssIncludes("app");
        }
    }

    protected function makeMenu()
    {
        try {
            $menu = Menu::query()
                ->where('key', 'admin')
                ->firstOrFail();
        }
        catch (\Exception $e) {
            return;
        }

        $title = "Слайдеры";
        $itemData = [
            'title' => $title,
            'template' => "sliders::admin.sliders.menu",
            'url' => "#",
            'ico' => 'fab fa-slideshare',
            'menu_id' => $menu->id,
        ];

        try {
            $menuItem = MenuItem::query()
                ->where("menu_id", $menu->id)
                ->where('title', $title)
                ->firstOrFail();
            $menuItem->update($itemData);
            $this->info("Элемент меню '$title' обновлен");
        }
        catch (\Exception $e) {
            MenuItem::create($itemData);
            $this->info("Элемент меню '$title' создан");
        }
    }
}
