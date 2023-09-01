@extends("admin.layout")

@section("page-title", "Просмотр {$slide->title} - ")

@section('header-title', "Просмотр {$slide->title}")

@section('admin')

    @include("sliders::admin.sliders.includes.pills")
    @include("sliders::admin.slides.includes.pills")

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table>
                    <thead>
                    <tr>
                        <th class="p-2 border border-dark">Элемент</th>
                        <th class="p-2 border border-dark">Контент</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="p-2 border border-dark">Фоновая картинка</td>
                        <td class="p-2 border border-dark">
                            @img([
                            "image" => $slide->image,
                            "template" => "medium",
                            "lightbox" => "lightGroupExample",
                            "imgClass" => "img-fluid",
                            "grid" => [],
                            ])
                        </td>
                    </tr>
                    <tr>
                        <td class="p-2 border border-dark">Название слайда</td>
                        <td class="p-2 border border-dark">{{ $slide->title }}</td>
                    </tr>
                    <tr>
                        <td class="p-2 border border-dark">Заголовок слайда</td>
                        <td class="p-2 border border-dark">{{ $slide->short }}</td>
                    </tr>
                    <tr>
                        <td class="p-2 border border-dark">Начало показа слайда</td>
                        <td class="p-2 border border-dark">{{ $slide->published_at }}</td>
                    </tr>
                    <tr>
                        <td class="p-2 border border-dark">Конец показа слайда</td>
                        <td class="p-2 border border-dark">{{ $slide->unpublished_at }}</td>
                    </tr>
                    <tr>
                        <td class="p-2 border border-dark">Ссылка со слайда</td>
                        <td class="p-2 border border-dark">{{ $slide->url }}</td>
                    </tr>
                    <tr>
                        <td class="p-2 border border-dark">Описание</td>
                        <td class="p-2 border border-dark">{!! $slide->description !!}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
