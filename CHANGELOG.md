## Versions
### v3.0.3 cert slider
- фильтр slider-certificates-xxl

Обновление:


    php artisan config:clear
    php artisan cache:clear
    php artisan image-filters:clear

### v3.0.0-v3.0.2 base-settings 5 (bootstrap 5)
- фильтр image-xxl 
- Font Awesome 6 Free
- tiny 
- обновлен шаблон site.sliders.slider-images & slider-certificates
- обновлен компонент AddReview
Обновление:


    php artisan vendor:publish --provider="Cher4geo35\Sliders\SlidersServiceProvider" --tag=public --force
