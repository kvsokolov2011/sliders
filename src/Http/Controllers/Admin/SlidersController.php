<?php

namespace Cher4geo35\Sliders\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Image;
use Cher4geo35\Sliders\Models\Slide;
use Cher4geo35\Sliders\Models\Slider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SlidersController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(Sliders::class, "sliders");
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
        return view("sliders::admin.sliders.index");
    }

    public function storageSlider(Request $request)
    {
        try{
            Slider::query()->where('slug', $request->slug??Str::slug($request->title, '-'))->firstOrFail();
            return response()->json(['success' => false, 'message' => 'Такая адресная строка уже существует.']);
        } catch ( Exception $e) {
            $query = Slider::create([
                'title' => $request->title,
                'slug' => $request->slug??Str::slug($request->title, '-'),
                'description' => $request->description,
            ]);
            if($query) return response()->json(['success' => true, 'message' => 'Слайдер сохранен.']);
            return response()->json(['success' => false, 'message' => 'Ошибка сохранения слайдера.']);
        }
    }

    public function storageSlide(Request $request)
    {
        try{
            Slide::query()->where('slug', $request->slug??Str::slug($request->title, '-'))->firstOrFail();
            return response()->json(['success' => false, 'message' => 'Такая адресная строка уже существует.']);
        } catch ( Exception $e) {
            $slider = Slider::query()->where('slug', $request->slug_slider)->first();
            if($slider){
                $slide = new Slide();
                $slide->slider_id = $slider->id;
                $slide->title = $request->title;
                $slide->short = $request->short;
                $slide->slug = $request->slug??Str::slug($request->title, '-');
                $slide->priority = 1;
                $slide->url = $request->url;
                $slide->description = $request->description;
                $slide->published_at = $request->published_at;
                $slide->unpublished_at = $request->unpublished_at;
                if($request->hasFile('image')) $slide->image_id = $this->uploadImage($request->image);
                $slide->save();
                return response()->json(['success' => true, 'message' => 'Слайд сохранен.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Слайдер не найден']);
            }
        }
    }

    private function uploadImage($image){
        $path = $image->store('slides');
        $fileName = $image->getClientOriginalName();
        $image = Image::create([
            'path' => $path,
            'name' => $fileName,
        ]);
        return $image->id;
    }

    public function updateSlide(Request $request)
    {
        try{
            if(count(Slide::whereNotIn('id', [$request->id] )->where('slug', $request->slug)->get() )) {
                return response()->json(['success' => false, 'message' => 'Такая адресная строка уже существует.']);
            }
            $slide = Slide::query()->where('id', $request->id)->firstOrFail();
            $slide->title = $request->title;
            $slide->short = $request->short;
            $slide->slug = $request->slug;
            $slide->priority = 1;
            $slide->url = $request->url;
            $slide->description = $request->description;
            $slide->published_at = $request->published_at;
            $slide->unpublished_at = $request->unpublished_at;
            if($request->hasFile('image')) $slide->image_id = $this->uploadImage($request->image);
            $slide->save();
            return response()->json(['success' => true, 'message' => 'Слайд сохранен.']);
        } catch ( Exception $e) {
            return response()->json(['success' => false, 'message' => 'Слайд не найден!']);
        }
    }

    public function updateSlider(Request $request)
    {
        try{
            if(count(Slider::whereNotIn('id', [$request->id] )->where('slug', $request->slug)->get() )) {
                return response()->json(['success' => false, 'message' => 'Такая адресная строка уже существует.']);
            }
            $slider = Slider::query()->where('id', $request->id)->firstOrFail();
            $slider->title = $request->title;
            $slider->slug = $request->slug;
            $slider->description = $request->description;
            $slider->save();
            return response()->json(['success' => true, 'message' => 'Слайдер сохранен.']);
        } catch ( Exception $e) {
            return response()->json(['success' => false, 'message' => 'Слайдер не найден!']);
        }
    }

    public function getSlides(Request $request)
    {
        try{
            $slider = Slider::query()->where('slug', $request->slug_slider )->firstOrFail();
            $slides = $slider->slides;
        } catch (Exception $e){
            $slides = [];
        }
        return response()->json(['slides' => $slides]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSliders()
    {
        $sliders = Slider::query()->get();
        return response()->json(['sliders' => $sliders]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteSlider(Request $request)
    {
        if(Slider::deleteSlider($request->slug)) return response()->json(['success' => true, 'message' => 'Слайдер удален.']);
        return response()->json(['success' => false, 'message' => 'Слайдер не найден.']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteSlide(Request $request)
    {
        if(Slide::deleteSlide($request->slug)) return response()->json(['success' => true, 'message' => 'Слайд удален.']);
        return response()->json(['success' => false, 'message' => 'Слайд не найден.']);
    }

}
