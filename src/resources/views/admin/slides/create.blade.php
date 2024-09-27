@extends('admin.layout')

@section('page-title', 'Слайды - ')
@section('header-title', 'Слайды')

@section('admin')
    @can("viewAny", \App\Slide::class)
        @include("sliders::admin.sliders.includes.pills")
        @include("sliders::admin.slides.includes.pills")
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route("admin.slides.store") }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="title">Название<span class="text-danger">*</span></label>
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
                            <label for="short">Заголовок</label>
                            <input type="text"
                                   id="short"
                                   name="short"
                                   value="{{ old('short') }}"
                                   class="form-control @error("short") is-invalid @enderror">
                            @error("short")
                            <div class="invalid-feedback" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="url">Ссылка со слайда</label>
                            <input type="text"
                                   id="url"
                                   name="url"
                                   value="{{ old('url') }}"
                                   class="form-control @error("url") is-invalid @enderror">
                            @error("url")
                            <div class="invalid-feedback" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="published_at">Дата начала показа</label>
                            <input type="date"
                                   id="published_at"
                                   name="published_at"
                                   value="{{ old('published_at') }}"
                                   class="form-control @error("published_at") is-invalid @enderror">
                            @error("published_at")
                            <div class="invalid-feedback" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="unpublished_at">Дата окончания показа</label>
                            <input type="date"
                                   id="unpublished_at"
                                   name="unpublished_at"
                                   value="{{ old('unpublished_at') }}"
                                   class="form-control @error("unpublished_at") is-invalid @enderror">
                            @error("unpublished_at")
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
                            <label for="ckDescription">Описание</label>
                            <textarea class="tiny form-control @error("description") is-invalid @enderror" name="description" id="ckDescription" rows="3">
                            {{ old('description') }}
                        </textarea>
                            @error("description")
                            <div class="invalid-feedback" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="custom-file-input">Изображение</label>
                            <div class="custom-file">
                                <input type="file"
                                       class="custom-file-input{{ $errors->has('image') ? ' is-invalid' : '' }}"
                                       id="custom-file-input"
                                       lang="ru"
                                       name="image"
                                       aria-describedby="inputGroupImage">
                                <label class="custom-file-label"
                                       for="custom-file-input">
                                    Выберите файл
                                </label>
                                @if ($errors->has('image'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </div>
                                @endif
                            </div>
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
