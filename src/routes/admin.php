<?php

use Illuminate\Support\Facades\Route;

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

