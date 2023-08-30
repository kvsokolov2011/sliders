<div class="col-12">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills">

                @can("view", \App\Slider::class)
                    <li class="nav-item">
                        <a href="{{ route("admin.sliders.index") }}"
                        class="nav-link{{ $currentRoute === "admin.sliders.index" ? " active" : "" }}">
                            Список
                        </a>
                    </li>
                @endcan

                @can("update", \App\Slider::class)
                    <li class="nav-item">
                        <a href="{{ route("admin.sliders.create") }}"
                        class="nav-link{{ $currentRoute === "admin.sliders.create" ? " active" : "" }}">
                            Добавить слайдер
                        </a>
                    </li>
                @endcan

{{--                @can("create", \App\Slide::class)--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route("admin.slides.create") }}"--}}
{{--                        class="nav-link{{ $currentRoute === "admin.slides.create" ? " active" : "" }}">--}}
{{--                            Добавить--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}

{{--                @if (! empty($slide))--}}
{{--                    @canany(["viewAny", "view", "create", "update", "publish"], \App\Slide::class)--}}
{{--                        <li class="nav-item">--}}
{{--                            <a href="{{ route("admin.slides.show", ['slide' => $slide]) }}"--}}
{{--                            class="nav-link{{ $currentRoute === "admin.slides.show" ? " active" : "" }}">--}}
{{--                                Просмотр--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    @endcanany--}}
{{--                    @can("update", \App\Slide::class)--}}
{{--                        <li class="nav-item">--}}
{{--                            <a href="{{ route("admin.slides.edit", ['slide' => $slide]) }}"--}}
{{--                            class="nav-link{{ $currentRoute === "admin.slides.edit" ? " active" : "" }}">--}}
{{--                                Редактировать--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    @endcan--}}

{{--                    @can("viewAny", \App\Meta::class)--}}
{{--                        <li class="nav-item">--}}
{{--                            <a href="{{ route("admin.slides.meta", ['slide' => $slide]) }}"--}}
{{--                               class="nav-link{{ $currentRoute === "admin.slides.meta" ? " active" : "" }}">--}}
{{--                                Meta--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    @endcan--}}
{{--                    @can("delete", \App\Slide::class)--}}
{{--                    <li class="nav-item">--}}
{{--                        <button type="button" class="btn btn-danger ml-2" data-confirm="{{ "delete-form-{$slide->id}" }}">--}}
{{--                            <i class="fas fa-trash-alt"></i>--}}
{{--                        </button>--}}
{{--                        <confirm-form :id="'{{ "delete-form-{$slide->id}" }}'">--}}
{{--                            <template>--}}
{{--                                <form action="{{ route('admin.slides.destroy', ['slide' => $slide]) }}"--}}
{{--                                      id="delete-form-{{ $slide->id }}"--}}
{{--                                      class="btn-group"--}}
{{--                                      method="post">--}}
{{--                                    @csrf--}}
{{--                                    <input type="hidden" name="_method" value="DELETE">--}}
{{--                                </form>--}}
{{--                            </template>--}}
{{--                        </confirm-form>--}}
{{--                    </li>--}}
{{--                    @endcan--}}
{{--                @endif--}}
            </ul>
        </div>
    </div>
</div>
