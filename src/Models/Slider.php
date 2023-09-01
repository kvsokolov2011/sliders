<?php

namespace Cher4geo35\Sliders\Models;

use Cher4geo35\Sliders\Models\Slide;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function get_slides()
    {
        $collection = Slide::query()
            ->with(["image"])->where('slider_id', $this->id )
            ->where(function($query) {
                $query->where("unpublished_at", ">", now())
                    ->where("published_at", "<", now());
            })
            ->orWhere(function($query) {
                $query->where("unpublished_at", NULL)
                    ->where("published_at", "<", now());
            })
            ->orderBy("priority")
            ->get();
        return $collection;
    }

    static function deleteSlider($slug){
        try{
            $slider = Slider::query()->where('slug', $slug)->firstOrFail();
            foreach ($slider->slides as $slide){
                $slide->delete();
            }
            $slider->delete();
            return true;
        }catch ( Exception $e){
            return false;
        }
    }
}
