@canany(["view", "update", "create"], \App\Slide::class)
    <div class="col-12 mb-2">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-pills">

                    @can("view", \App\Slide::class)
                        <li class="nav-item">
                            <a href="{{ route("admin.slides.index") }}"
                            class="nav-link{{ $currentRoute === "admin.slides.index" ? " active" : "" }}">
                                Список слайдов
                            </a>
                        </li>
                    @endcan

                    @can("update", \App\Slide::class)
                        <li class="nav-item">
                            <a href="{{ route("admin.slides.priority") }}"
                               class="nav-link{{ $currentRoute === "admin.slides.priority" ? " active" : "" }}">
                                Приоритет
                            </a>
                        </li>
                    @endcan

                    @can("create", \App\Slide::class)
                        <li class="nav-item">
                            <a href="{{ route("admin.slides.create") }}"
                            class="nav-link{{ $currentRoute === "admin.slides.create, " ? " active" : "" }}">
                                Добавить слайд
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
        </div>
    </div>
@endcanany
