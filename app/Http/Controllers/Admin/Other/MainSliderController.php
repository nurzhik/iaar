<?php

namespace App\Http\Controllers\Admin\Other;

use App\Http\Controllers\Controller;
use App\Models\MainSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class MainSliderController extends Controller
{

    public function index()
    {
        $items = MainSlider::where('id','>',0)->orderBy('sort_order')->get();
        return view('admin.other.sliders',[
            'items' => $items,
        ]);
    }
    public function create()
    {
        $item = new MainSlider();;
        return view('admin.other.slider',[
            'item' => $item,
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new MainSlider();
        $item->title = $request->title;
        if(isset($request->image))
            $item->image  = str_replace(url('/'),'',$request->image);
        $item->short_desc = $request->short_desc;
        $item->sort_order = $request->sort_order;
        $item->link = $request->link;
        $item->show_date  = $request->show_date;
        $item->save();
        return redirect()->back()->with('status','Новая запись успешно создана!');

    }
    public function edit(MainSlider $item)
    {
        return view('admin.other.slider',[
            'item' => $item,
        ]);
    }
    public function update(MainSlider $item, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",

        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item->title = $request->title;
        if(isset($request->image))
            $item->image  = str_replace(url('/'),'',$request->image);
        $item->short_desc = $request->short_desc;
        $item->sort_order = $request->sort_order;
        $item->link = $request->link;
        $item->show_date  = $request->show_date;
        $item->save();
        return redirect()->back()->with('status','Данные о записи успешно изменены!');

    }
    public function delete(MainSlider $item)
    {
        $item->delete();
        return redirect()->back()->with('status','Элемент слайдера успешно удален!');
    }


}
