# sliders

**Редактируемые слайдеры на основе bootstrap. Laravel 9**

## Установка

    php artisan migrate

    php artisan vendor:publish --provider="Cher4geo35\Sliders\SlidersServiceProvider" --tag=public --force

    php artisan make:sliders {--all : Run all}
                             {--menu : Config menu}
                             {--models : Export models}
                             {--policies : Export and create rules}
                             {--config : Make config}
                             {--controllers : Export controllers}
                             {--vue : Export vue files}


### Components
progress-bar:
    <sliders>
    </sliders>

### Versions

