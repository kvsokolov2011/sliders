@extends("admin.layout")

@section("page-title", "Приоритет слайдов - ")

@section('header-title', "Приоритет слайдов")

@section('admin')
    @include("sliders::admin.sliders.includes.pills")
    @include("sliders::admin.slides.includes.pills")

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <universal-priority
                        :elements="{{ json_encode($priority) }}"
                        url="{{ route("admin.vue.priority", ['table' => "slides", "field" => "priority"]) }}">
                </universal-priority>
            </div>
        </div>
    </div>
@endsection
