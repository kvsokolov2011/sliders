@extends('admin.layout')

@section('page-title', 'Слайды - ')
@section('header-title', 'Слайды')

@section('admin')
{{--    @can("viewAny", \App\Slides::class)--}}
        @include("sliders::admin.sliders.includes.pills")
        @include("sliders::admin.slides.includes.pills")

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Название</th>
                                    <th>Заголовок</th>
                                    <th>Ссылка со слайда</th>
                                    <th>Начало показа слайда</th>
                                    <th>Окончание показа слайда</th>
                                    @canany(["view", "create", "update", "delete", "publish"], \App\Slide::class)
                                        <th>Действия</th>
                                    @endcanany
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($slides as $slide)
                                    <tr>
                                        <td>{{ $slide->title }}</td>
                                        <td>{{ $slide->short }}</td>
                                        <td>{{ $slide->url }}</td>
                                        <td>{{ $slide->published_at }}</td>
                                        <td>{{ $slide->unpublished_at }}</td>
                                        <td>
                                            <div role="toolbar" class="btn-toolbar">
                                                <div class="btn-group mr-1">

                                                    @can("update", \App\Slide::class)
                                                        <a href="{{ route("admin.slides.edit", ["slide" => $slide]) }}" class="btn btn-primary">
                                                            <i class="far fa-edit"></i>
                                                        </a>
                                                    @endcan
                                                    @canany(["view", "create", "update", "publish"], \App\Slide::class)
                                                        <a href="{{ route('admin.slides.show', ['slide' => $slide]) }}" class="btn btn-dark">
                                                            <i class="far fa-eye"></i>
                                                        </a>
                                                    @endcanany
                                                    @can("delete", \App\Slide::class)
                                                        <button type="button" class="btn btn-danger" data-confirm="{{ "delete-form-{$slide->id}" }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    @endcan
                                                </div>
                                            </div>
                                            <confirm-form :id="'{{ "delete-form-{$slide->id}" }}'">
                                                <template>
                                                    <form action="{{ route('admin.slides.destroy', ['slide' => $slide]) }}"
                                                          id="delete-form-{{ $slide->id }}"
                                                          class="btn-group"
                                                          method="post">
                                                        @csrf
                                                        <input type="hidden" name="_method" value="DELETE">
                                                    </form>
                                                </template>
                                            </confirm-form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


{{--    @endcan--}}
@endsection
