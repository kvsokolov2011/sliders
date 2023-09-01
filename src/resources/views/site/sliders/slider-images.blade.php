@if($slider->get_slides() && count($slider->get_slides()))
    <div class="slider-images mx-0 mx-md-5">
        @foreach($slider->get_slides() as $slide)
            <div class="px-2 bg-transparent">
                <div class="overflow-hidden d-flex justify-content-center align-items-center">
                    @imgLazy([
                    "image" => $slide->image,
                    "template" => "image-xs",
                    "lightbox" => "{{$slider->slug}}",
                    "imgClass" => "slider-images__slide",
                    "grid" => [
                            "image-xl" => 1200,
                            "image-lg" => 992,
                            "image-md" => 768,
                            "image-sm" => 576
                        ],
                    ])
                </div>
            </div>
        @endforeach
    </div>
@endif

