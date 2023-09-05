<?php

namespace Cher4geo35\Sliders\Models;

use App\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
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

    /**
     * @return void
     */
    protected static function booting()
    {
        parent::booting();

        static::updated(function (Slide $model) {
            $model->forgetCache('slides', $model->slider_id);
        });
    }

    /**
     * @param $first_key
     * @param $second_key
     * @return void
     */
    public function forgetCache($first_key, $second_key)
    {
        Cache::forget("{$first_key}:{$second_key}");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
