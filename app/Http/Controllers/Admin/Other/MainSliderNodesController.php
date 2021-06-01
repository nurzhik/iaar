<?php

namespace App\Http\Controllers\Admin\Other;

use App\Http\Controllers\Controller;
use App\Models\MainSlider;
use App\Models\Nodes\MainSliderNode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class MainSliderNodesController extends Controller
{

    public function create( MainSlider $parent, $lang)
    {
        $item = MainSliderNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
        if(!empty($item))
            return redirect()->back()->with('error','Выбранный язык уже существует!');
        $item = new MainSliderNode();
        return view('admin.other.nodes.slider',[
            'item' => $item,
            'lang' => $lang,
            'parent' => $parent
        ]);
    }
    public function store(MainSlider $parent, $lang, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new MainSliderNode();
        $item->title = $request->title;
        $item->short_desc = $request->short_desc;
        $item->link = $request->link;
        $item->parent_id = $parent->id;
        $item->lang = $lang;
        $item->save();
        return redirect()->route('edit_slider',['item' => $parent->id])->with('status','Данные о переводе изменены!');

    }
    public function edit(MainSliderNode $item)
    {
        $parent = MainSlider::where('id',$item->parent_id)->first();
        return view('admin.other.nodes.slider',[
            'item' => $item,
            'lang' => $item->lang,
            'parent' => $parent
        ]);
    }
    public function update(MainSliderNode $item, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",

        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item->title = $request->title;
        $item->short_desc = $request->short_desc;
        $item->link = $request->link;
        $item->save();
        $parent = MainSlider::where('id',$item->parent_id)->first();
        return redirect()->route('edit_slider',['item' => $parent->id])->with('status','Данные о переводе изменены!');

    }
    public function delete(MainSliderNode $item)
    {
        $item->delete();
        return redirect()->back()->with('status','Элемент слайдера успешно удален!');
    }


}
