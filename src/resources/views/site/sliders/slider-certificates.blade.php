@if($slider->slides && count($slider->slides))
    <div class="slider-certificates {{ $slider->slug }} mx-0 mx-md-5">
        @foreach($slider->get_slides() as $slide)
            <div class="px-2 bg-transparent">
                <div class="p-2 bg-light d-flex justify-content-center align-items-center slider-certificates__slide">
                    @imgLazy([
                        "image" => $slide->image,
                        "template" => "certificates-slider",
                        "lightbox" => "{{$slider->slug}}",
                        "imgClass" => "border-0",
                    "grid" => [],
                    ])
                </div>
            </div>
        @endforeach
    </div>
@endif

