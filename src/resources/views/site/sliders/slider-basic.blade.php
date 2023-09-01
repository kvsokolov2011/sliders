@if($slider->get_slides() && count($slider->get_slides()))
    <div class="slider-basic">
        @foreach ($slider->get_slides() as $slide)
            <div class="card overflow-hidden slider-basic__slide">
                @isset($slide->url)
                    <a href="{{ $slide->url }}" target="_blank">
                @endisset
                        @picLazy([
                        "image" => $slide->image,
                        "template" => "basic-xs",
                        "grid" => [
                        "basic-xl" => 1200,
                        "basic-lg" => 992,
                        "basic-md" => 768,
                        "basic-sm" => 576,
                        ],
                        "imgClass" => "image-fluid slider-basic__image",
                        ])
                        <div class="card-img-overlay slider-basic__content">
                            <div class="container">
                                <h1>{{ $slide->short }}</h1>
                                {!! $slide->description !!}
                            </div>
                        </div>
                @isset($slide->url)
                    </a>
                @endisset
            </div>
        @endforeach
    </div>
@endif
