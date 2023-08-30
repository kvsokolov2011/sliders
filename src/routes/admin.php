<?php

use Illuminate\Support\Facades\Route;

//Route::group([
//    'namespace' => 'App\Http\Controllers\Vendor\Sliders\Admin',
//    'middleware' => ['web', 'management'],
//    'as' => 'admin.sliders.',
//    'prefix' => 'admin',
//], function () {
////    Route::get('/sliders', 'SlidersController@index')->name('index');
////    Route::post('/sliders/storage-slider', 'SlidersController@storageSlider')->name('storage-slider');
//});

Route::group([
    'namespace' => 'App\Http\Controllers\Vendor\Sliders\Admin',
    'middleware' => ['web', 'management'],
    'prefix' => 'admin',
], function () {
    Route::resource("sliders", "SlidersController", [ "as" => "admin" ]);
    Route::resource("slides", "SlidesController", [ "as" => "admin" ]);
    Route::get("/list/priority", "SlidesController@priority")
        ->name("admin.slides.priority");
});

