@canany(["view", "create"], \App\Slider::class)
    <div class="col-12 mb-2">
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

                    @can("create", \App\Slider::class)
                        <li class="nav-item">
                            <a href="{{ route("admin.sliders.create") }}"
                            class="nav-link{{ $currentRoute === "admin.sliders.create" ? " active" : "" }}">
                                Добавить слайдер
                            </a>
                        </li>
                    @endcan

                </ul>
            </div>
        </div>
    </div>
@endcan
