<?php

use App\ProgressParseNews;
use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'App\Http\Controllers\Vendor\Sliders\Admin',
    'middleware' => ['web', 'management'],
    'as' => 'admin.',
    'prefix' => 'admin',
], function () {
    Route::get('/sliders', 'SlidersController@index')->name('sliders.index');
    Route::get('/sliders/get-sliders', 'SlidersController@getSliders')->name('sliders.get-sliders');
    Route::post('/sliders/storage-slider', 'SlidersController@storageSlider')->name('sliders.storage-slider');
    Route::post('/sliders/update-slider', 'SlidersController@updateSlider')->name('sliders.update-slider');
    Route::post('/sliders/delete-slider', 'SlidersController@deleteSlider')->name('sliders.delete-slider');
    Route::post('/sliders/get-slides', 'SlidersController@getSlides')->name('sliders.get-slides');
    Route::post('/sliders/storage-slide', 'SlidersController@storageSlide')->name('sliders.storage-slide');
    Route::post('/sliders/update-slide', 'SlidersController@updateSlide')->name('sliders.update-slide');
    Route::post('/sliders/delete-slide', 'SlidersController@deleteSlide')->name('sliders.delete-slide');
});
