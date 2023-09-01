<?php

namespace Cher4geo35\Sliders\Filters;

use Intervention\Image\Facades\Image;
use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image as File;

class BasicXs implements FilterInterface {
    public function applyFilter(File $image)
    {
        return $image
            ->fit(575, 550);
    }
}
