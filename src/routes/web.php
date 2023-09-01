<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'App\Http\Controllers\Vendor\Sliders\Site',
    'middleware' => ['web', 'management'],
    'prefix' => 'site',
], function () {
    Route::resource("sliders", "SlidersController", [ "as" => "site" ]);
    Route::resource("slides", "SlidesController", [ "as" => "site" ]);
});
