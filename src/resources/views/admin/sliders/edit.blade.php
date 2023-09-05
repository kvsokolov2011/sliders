@extends('admin.layout')

@section('page-title', 'Слайдеры - ')
@section('header-title', 'Слайдеры')

@section('admin')
    @can("viewAny", \App\Slider::class)
        @include("sliders::admin.sliders.includes.pills")
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="h4 mb-3">Редактировать слайдер слайдер</h2>
                    <form action="{{ route("admin.sliders.update", ["slider" => $slider]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method("put")

                        <div class="form-group">
                            <label for="title">Название слайдера<span class="text-danger">*</span></label>
                            <input type="text"
                                   id="title"
                                   name="title"
                                   required
                                   value="{{ old('title', $slider->title) }}"
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
                                   value="{{ old('slug', $slider->slug) }}"
                                   class="form-control @error("slug") is-invalid @enderror">
                            @error("slug")
                            <div class="invalid-feedback" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="ckDescription">Описание</label>
                            <textarea class="form-control @error("description") is-invalid @enderror" name="description" id="ckDescription" rows="3">
                            {{ old('description', $slider->description) }}
                        </textarea>
                            @error("description")
                            <div class="invalid-feedback" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="btn-group"
                             role="group">
                            <button type="submit" class="btn btn-success">Изменить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
@endsection
