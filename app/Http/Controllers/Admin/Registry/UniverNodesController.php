<?php

namespace App\Http\Controllers\Admin\Registry;

use App\Http\Controllers\Controller;

use App\Models\Univer;
use App\Models\Nodes\UniverNode;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UniverNodesController extends Controller
{
    public function create(Univer $parent,$lang)
    {
        $item = UniverNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
        if(!empty($item))
            return redirect()->back()->with('error','Выбранный язык уже существует!');
        $item = new UniverNode();
        return view('admin.univer.nodes.item',[
            'item' => $item,
            'parent' => $parent,
            'lang' => $lang
        ]);
    }
    public function store(Univer $parent,$lang, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required"
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new UniverNode();
        $item->title = $request->title;
        $item->parent_id = $parent->id;
        $item->lang = $lang;
        $item->save();
        return redirect()->route('edit_univer',['item' => $parent->id])->with('status','Данные о переводе успешно добавлены!');

    }
    public function edit( UniverNode $item)
    {
        $parent = Univer::where('id',$item->parent_id)->first();
        return view('admin.univer.nodes.item',[
            'item' => $item,
            'parent' => $parent,
            'lang' => $item->lang,
        ]);
    }
    public function update( UniverNode $item, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        };
        $item->title = $request->title;
        $item->save();
        $parent = Univer::where('id',$item->parent_id)->first();
        return redirect()->route('edit_univer',['item' => $parent->id])->with('status','Данные о переводе успешно изменены!');


    }
    public function delete(UniverNode $item)
    {
        $item->delete();
        return redirect()->back()->with('status','Данные успешно удалены!');
    }


}
