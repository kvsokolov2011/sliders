@extends('admin.layout')

@section('page-title', 'Слайдеры - ')
@section('header-title', 'Слайдеры')

@section('admin')
    @can("viewAny", \App\Slider::class)
        @include("sliders::admin.sliders.includes.pills")
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="h4 mb-3">Добавить слайдер</h2>
                    <form action="{{ route("admin.sliders.store") }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="title">Название слайдера<span class="text-danger">*</span></label>
                            <input type="text"
                                   id="title"
                                   name="title"
                                   required
                                   value="{{ old('title') }}"
                                   class="form-control @error("title") is-invalid @enderror">
                            @error("title")
                            <div class="invalid-feedback" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="slug">Адресная строка</label>
                            <input type="text"
                                   id="slug"
                                   name="slug"
                                   value="{{ old('slug') }}"
                                   class="form-control @error("slug") is-invalid @enderror">
                            @error("slug")
                            <div class="invalid-feedback" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Описание</label>
                            <textarea class="form-control @error("description") is-invalid @enderror"
                                      name="description"
                                      id="description"
                                      rows="1">{{ old('description') }}</textarea>
                            @error("description")
                            <div class="invalid-feedback" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="btn-group"
                             role="group">
                            <button type="submit" class="btn btn-success">Добавить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
@endsection
