<?php

namespace Cher4geo35\Sliders\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Review;
use Illuminate\Support\Facades\Cache;

class SlidersController extends Controller
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|\Illuminate\Support\Enumerable|\Illuminate\Support\Traits\EnumeratesValues|mixed
     */
    static public function get_reviews(){
        $cacheKey = "reviews";
        $cached = Cache::get($cacheKey);
        if (!empty($cached)) {
            return $cached;
        }
        try{
            $reviews = Review::all()
                ->whereNotNull('moderated_at')
                ->whereNull('review_id')
                ->sortByDesc('registered_at')
                ->take(base_config()->get('reviews', "pager"));

            foreach ($reviews as $review){
                $review->registered_at = preg_replace(
                    '/(\d{4})-(\d{2})-(\d{2})\s(\d{2}):(\d{2}):(\d{2})/',
                    "$3.$2.$1", $review->registered_at);
            }
            Cache::forever($cacheKey, $reviews);
            return $reviews;
        } catch (\Exception $e){
            return false;
        }
    }
}
