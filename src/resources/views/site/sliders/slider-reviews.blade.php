@php($reviews = new \Cher4geo35\Sliders\Http\Controllers\Site\SlidersController())
@if ($reviews->get_reviews() && count($reviews->get_reviews()))
    <div class="position-relative">
        <div class="slider-reviews__title text-center">
            <h2>Отзывы о нас</h2>
            <div class="line mx-auto"></div>
        </div>
        <div class="slider-reviews">
            @foreach ($reviews->get_reviews() as $review)
                @include('sliders::site.sliders.includes.slide-review', ['registered' => $review->registered_at,
                                                                         'from' => $review->from,
                                                                         'description' => $review->description,
                                                                        ])
            @endforeach
        </div>
    </div>
@endif

@if(\Schema::hasTable('reviews'))
    <div class="container">
        <div class="row">
            <div class="mt-3 ml-0 col-12">
                <add-review form-action="{{ route('site.reviews.store') }}"
                            user-auth="{{ Auth::check() ? Auth::user()->id : false }}">
                </add-review>
            </div>
        </div>
    </div>
@endif
