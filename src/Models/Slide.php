<?php

namespace Cher4geo35\Sliders\Models;

use App\Image;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PortedCheese\BaseSettings\Traits\ShouldGallery;
use PortedCheese\BaseSettings\Traits\ShouldImage;
use PortedCheese\BaseSettings\Traits\ShouldSlug;
use PortedCheese\SeoIntegration\Traits\HasMetas;

class Slide extends Model
{
    use HasFactory;
    use ShouldImage, ShouldGallery, ShouldSlug, HasMetas;

    protected $fillable = [
        "title",
        "slug",
        "description",
        "short",
        "slider_id",
        "url",
        "published_at",
        "unpublished_at",
    ];

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    static function deleteSlide($slug){
        try{
            $slide = Slide::query()->where('slug', $slug)->firstOrFail();
            $slide->delete();
            return true;
        }catch ( Exception $e){
            return false;
        }
    }
}
