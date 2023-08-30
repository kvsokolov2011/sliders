@extends('admin.layout')

@section('page-title', 'Слайдеры - ')
@section('header-title', 'Слайдеры')

@section('admin')
    @can("viewAny", \App\Sliders::class)
        <div class="col-12">
            <div class="card">
                <div class="card-body">

{{--                    <sliders url_storage_slider="{{ route('admin.sliders.storage-slider') }}"--}}
{{--                             url_update_slider="{{ route('admin.sliders.update-slider') }}"--}}
{{--                             url_get_sliders="{{ route('admin.sliders.get-sliders') }}"--}}
{{--                             url_delete_slider="{{ route('admin.sliders.delete-slider') }}"--}}
{{--                             url_get_slides="{{ route('admin.sliders.get-slides') }}"--}}
{{--                             url_storage_slide="{{ route('admin.sliders.storage-slide') }}"--}}
{{--                             url_update_slide="{{ route('admin.sliders.update-slide') }}"--}}
{{--                             url_delete_slide="{{ route('admin.sliders.delete-slide') }}"--}}
{{--                    >--}}
{{--                    </sliders>--}}
                </div>
            </div>
        </div>
    @endcan
@endsection
