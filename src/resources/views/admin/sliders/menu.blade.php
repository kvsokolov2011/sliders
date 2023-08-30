@can("viewAny", \App\Sliders::class)
    <li class="nav-item">
        <a href="{{ route('admin.sliders.index') }}"
           class="nav-link{{ strstr($currentRoute, 'admin.sliders') !== FALSE ? ' active' : '' }}">
            @isset($ico)
                <i class="{{ $ico }}"></i>
            @endisset
            <span>Слайдеры</span>
        </a>
    </li>
@endcan

