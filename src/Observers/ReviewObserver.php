<?php

namespace Cher4geo35\Sliders\Observers;

use App\Review;
use Illuminate\Support\Facades\Cache;

class ReviewObserver {

    /**
     * @param Review $review
     * @return void
     */
    public function updated(Review $review) {
        Cache::forget("reviews");
    }

    /**
     * @param Review $review
     * @return void
     */
    public function deleting(Review $review) {
        Cache::forget("reviews");
    }
}
