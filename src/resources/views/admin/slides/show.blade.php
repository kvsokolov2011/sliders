@extends("admin.layout")

@section("page-title", "Просмотр {$slide->title} - ")

@section('header-title', "Просмотр {$slide->title}")

@section('admin')

    @include("sliders::admin.sliders.includes.pills")
    @include("sliders::admin.slides.includes.pills")

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-4">
                        @img([
                        "image" => $slide->image,
                        "template" => "medium",
                        "lightbox" => "lightGroupExample",
                        "imgClass" => "img-fluid",
                        "grid" => [],
                        ])
                        <div class="d-flex flex-column">
                            @if ($slide->description)
                                <div class="mt-0">Начало показа слайда: {{ $slide->published_at }}</div>
                            @endif
                            @if ($slide->description)
                                <div class="mt-0">Конец показа слайда:  {{ $slide->unpublished_at }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-md-8">
                        @if ($slide->title)
                            <h4 class="mt-0">Краткое описание</h4>
                            <div>
                                {{ $slide->title }}
                            </div>
                        @endif
                        @if ($slide->short)
                            <h4 class="mt-0">Краткое описание</h4>
                            <div>
                                {{ $slide->short }}
                            </div>
                        @endif
                        @if ($slide->description)
                            <h4 class="mt-0">Описание</h4>
                            <div>
                                {!! $slide->description !!}
                            </div>
                        @endif


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
