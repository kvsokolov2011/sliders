<?php

namespace Cher4geo35\Sliders\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Cher4geo35\Sliders\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SlidersController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(Slider::class, "slider");
    }

    /**
     * @var
     */
    private $data;

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $sliders = Slider::all();
        return view("sliders::admin.sliders.index")->with(compact('sliders'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view("sliders::admin.sliders.create");
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->storeValidator($request->all());
        $slider = Slider::create([
                                    'title' => $request->title,
                                    'slug' => $request->slug ?? Str::slug($request->title, '-'),
                                    'description' => $request->description,
                                ]);
        return redirect()
            ->route("admin.sliders.index", ["slider" => $slider])
            ->with("success", "Слайдер добавлен");
    }

    /**
     * @param $data
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function storeValidator($data)
    {
        Validator::make($data, [
            "title" => ["required", "max:250"],
            "slug" => ["nullable", "max:250", "unique:sliders,slug"],
            "description" => ["nullable", "max:300"],
        ], [], [
            "title" => "Заголовок",
            "slug" => "Адресная строка",
            "description" => "Описание",
        ])->validate();
    }

    /**
     * @param Slider $slider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Slider $slider)
    {
        $slider->delete();
        return redirect()
            ->route("admin.sliders.index")
            ->with("success", "Успешно удалено");
    }

    /**
     * @param Slider $slider
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Slider $slider)
    {
        return view("sliders::admin.sliders.edit", [
            "slider" => $slider,
        ]);
    }

    /**
     * @param Request $request
     * @param Slider $slider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Slider $slider)
    {
        $this->updateValidator($request->all(), $slider);
        $slider->update($request->all());
        return redirect()
            ->route("admin.sliders.index", ["slider" => $slider])
            ->with("success", "Слайдер изменен");
    }

    /**
     * @param $data
     * @param Slider $slider
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function updateValidator($data, Slider $slider)
    {
        $id = $slider->id;
        Validator::make($data, [
            "title" => ["required", "max:250"],
            "slug" => ["nullable", "max:250", "unique:sliders,slug,{$id}"],
            "description" => ["nullable", "max:300"],
        ], [], [
            "title" => "Заголовок",
            "slug" => "Адресная строка",
            "description" => "Описание",
        ])->validate();
    }
}
