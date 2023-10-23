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
                             {--scss : Export scss files}
                             {--js : Export scripts}
                             {--vue : Export vue}
                             {--observers : Export observers}
        
    npm install slick-carousel@^1.8.1

    Добавить в webpack.min.js:
    .copy('node_modules/slick-carousel/slick/fonts', 'public/slick-carousel/fonts')
    .copy('node_modules/slick-carousel/slick/ajax-loader.gif', 'public/slick-carousel')

### Слайдеры

 - slider-cetrificates (Передаем в него $slider)
      @include('sliders::site.sliders.slider-certificates', [ 'slider' => $slider ])
 - slider-images (Передаем в него $slider)
      @include('sliders::site.sliders.slider-images', [ 'slider' => $slider ])
 - slider-basic (Передаем в него $slider)
      @include('sliders::site.sliders.slider-basic', [ 'slider' => $slider ])
 - slider-reviews (необходим пакет portedcheese/site-reviews)
      @include('sliders::site.sliders.slider-reviews')
      (Для слайдера отзывов необходимо установить пакет portedcheese/site-reviews)

### Components
add-review:
    <add-review form-action="{{ route('site.reviews.store') }}"
                user-auth="{{ Auth::check() ? Auth::user()->id : false }}">
    </add-review>
(Добавляем отзыв, кнопка под слайдером)

### Versions

