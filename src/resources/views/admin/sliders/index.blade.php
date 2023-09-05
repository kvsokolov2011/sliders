@extends('admin.layout')

@section('page-title', 'Слайдеры - ')
@section('header-title', 'Слайдеры')

@section('admin')
    @can("viewAny", \App\Slider::class)
        @include("sliders::admin.sliders.includes.pills")

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Заголовок</th>
                                <th>Slug</th>
                                <th>Описание</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($sliders && count($sliders))
                                @foreach($sliders as $slider)
                                        <td>{{ $slider->id }}</td>
                                        <td>{{ $slider->title }}</td>
                                        <td>{{ $slider->slug }}</td>
                                        <td>{{ $slider->description }}</td>
                                        <td>
                                            <div role="toolbar" class="btn-toolbar">
                                                <div class="btn-group mr-1">
                                                    @can("update", \App\Slider::class)
                                                        <a href="{{ route("admin.sliders.edit", ["slider" => $slider]) }}" class="btn btn-primary">
                                                            <i class="far fa-edit"></i>
                                                        </a>
                                                    @endcan
                                                    @canany(["view", "create", "update"], \App\Slider::class)
                                                        <form action="{{ route("admin.slides.index") }}" method="get" enctype="multipart/form-data">
                                                            @csrf
                                                            <input hidden name="slug" value="{{ $slider->slug }}">
                                                            <div class="btn-group"
                                                                 role="group">
                                                                <button type="submit" class="btn btn-dark"><i class="far fa-eye"></i></button>
                                                            </div>
                                                        </form>
                                                    @endcanany
                                                    @can("delete", \App\Slider::class)
                                                        <button type="button" class="btn btn-danger" data-confirm="{{ "delete-form-{$slider->id}" }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    @endcan
                                                </div>
                                            </div>
                                            <confirm-form :id="'{{ "delete-form-{$slider->id}" }}'">
                                                <template>
                                                    <form action="{{ route('admin.sliders.destroy', ['slider' => $slider]) }}"
                                                          id="delete-form-{{ $slider->id }}"
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
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection
