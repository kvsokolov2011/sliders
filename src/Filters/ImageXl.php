<?php

namespace Cher4geo35\Sliders\Filters;

use Intervention\Image\Facades\Image;
use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image as File;

class ImageXl implements FilterInterface {
    public function applyFilter(File $image)
    {
        return $image
            ->fit(282, 200);
    }
}
