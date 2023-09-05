<?php

namespace Cher4geo35\Sliders\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function slides()
    {
        return $this->hasMany(Slide::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function get_slides()
    {
        $cacheKey = "slides:{$this->id}";
        $cached = Cache::get($cacheKey);
        if (!empty($cached)) {
            return $cached;
        }
        $collection = Slide::query()
            ->where(function($query) {
                $query->where("unpublished_at", ">", now())
                    ->where("published_at", "<", now())->where('slider_id', $this->id );
            })
            ->orWhere(function($query) {
                $query->where("unpublished_at", NULL)
                    ->where("published_at", "<", now())->where('slider_id', $this->id );
            })
            ->orderBy('priority')
            ->get();
        Cache::forever($cacheKey, $collection);
        return $collection;
    }
}
