<?php

namespace Cher4geo35\Sliders\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Image;
use App\Slides;
use Cher4geo35\Sliders\Models\Slide;
use Cher4geo35\Sliders\Models\Slider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SlidesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(Slides::class, "slides");
    }

    /**
     * @var
     */
    private $data;

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        if($request->slug) session(['slider_slug' => $request->slug]);
        $slider = Slider::query()->where('slug', session('slider_slug'))->first();
        $slides = Slide::query()->where('slider_id', $slider->id)->orderBy('priority')->get();
        return view("sliders::admin.slides.index")->with(compact('slides'));
    }

    public function create()
    {
        return view("sliders::admin.slides.create");
    }

    public function store(Request $request)
    {
        $this->storeValidator($request->all());
        $slider = Slider::query()->where('slug', session('slider_slug'))->first();
        $slide = Slide::create([
            'slider_id' => $slider->id,
            'title' => $request->title,
            'slug' => $request->slug ?? Str::slug($request->title, '-'),
            'description' => $request->description,
            'published_at' => $request->published_at,
            'unpublished_at' => $request->unpublished_at,
            'url' => $request->url,
            'short' => $request->short,
        ]);
        $slide->uploadImage($request, "slides");
        $slides = Slide::query()->where('slug', session('slider_slug'));
        return redirect()
            ->route("admin.slides.index", [ "slides" => $slides])
            ->with("success", "Слайд добавлен");
    }

    protected function storeValidator($data)
    {
        Validator::make($data, [
            "title" => ["required", "max:250"],
            "published_at" => ["nullable", "date"],
            "unpublished_at" => ["nullable", "date"],
            "slug" => ["nullable", "max:250", "unique:slides,slug"],
            "short" => ["nullable", "max:250"],
            "url" => ["nullable", "url"],
            "image" => ["required", "image"],
            "description" => ["nullable", "max:300"],
        ], [], [
            "title" => "Заголовок",
            "published_at" => "Дата начала показа",
            "unpublished_at" => "Дата окончания показа",
            "slug" => "Адресная строка",
            "short" => "Краткое описание",
            "url" => "Ссылка со слайда",
            "image" => "Изображение",
            "description" => "Описание",
        ])->validate();
    }

    /**
     * @param Slider $slider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Slide $slide)
    {
        $slide->delete();

        return redirect()
            ->route("admin.slides.index")
            ->with("success", "Успешно удалено");
    }

    /**
     * @param Slider $slider
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Slide $slide)
    {
        return view("sliders::admin.slides.edit", [
            "slide" => $slide,
        ]);
    }

    public function update(Request $request, Slide $slide)
    {
        $this->updateValidator($request->all(), $slide);
        $slide->update($request->all());
        return redirect()
            ->route("admin.slides.index", ["slide" => $slide])
            ->with("success", "Слайд изменен");
    }

    protected function updateValidator($data, Slide $slide)
    {
        $id = $slide->id;
        Validator::make($data, [
            "title" => ["required", "max:250"],
            "published_at" => ["nullable", "date"],
            "unpublished_at" => ["nullable", "date"],
            "slug" => ["nullable", "max:250", "unique:slides,slug,{$id}"],
            "short" => ["nullable", "max:250"],
            "url" => ["nullable", "url"],
            "image" => ["image"],
            "description" => ["nullable", "max:300"],
        ], [], [
            "title" => "Заголовок",
            "published_at" => "Дата начала показа",
            "unpublished_at" => "Дата окончания показа",
            "slug" => "Адресная строка",
            "short" => "Краткое описание",
            "url" => "Ссылка со слайда",
            "image" => "Изображение",
            "description" => "Описание",
        ])->validate();
    }

    public function show(Slide $slide)
    {
        return view("sliders::admin.slides.show", [
            "slide" => $slide,
        ]);
    }

    public function priority()
    {
        $this->authorize("update", Slide::class);
        $slider = Slider::query()->where('slug', session('slider_slug'))->first();
        $collection = Slide::query()->where('slider_id', $slider->id)
            ->orderBy("priority")
            ->get();
        $priority = [];
        foreach ($collection as $item) {
            $priority[] = [
                "id" => $item->id,
                "name" => $item->title,
                "url" => route("admin.slides.show", ["slide" => $item]),
            ];
        }
        return view("sliders::admin.slides.priority", [
            "priority" => $priority
        ]);
    }
}
