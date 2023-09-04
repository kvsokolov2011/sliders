<?php

namespace Cher4geo35\Sliders\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Review;
use App\Sliders;
use Cher4geo35\Sliders\Models\Slider;
use Illuminate\Support\Str;

class SlidersController extends Controller
{

    static public function get_reviews(){
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

//
//        $list = [];
//        foreach ($reviews as $review) {
//            $list[] = [
//                'description' => $review['description'],
//                'from' => $review['from'],
//                'registered_at' =>
//                    preg_replace(
//                        '/(\d{4})-(\d{2})-(\d{2})\s(\d{2}):(\d{2}):(\d{2})/',
//                        "$3.$2.$1", $review['registered_at']),
//            ];
//        }
        return $reviews;
    }


}
