<?php

namespace Cher4geo35\Sliders\Models;

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
