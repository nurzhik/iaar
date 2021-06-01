<?php

namespace App\Http\Controllers\Admin\Postmonitorings;

use App\Http\Controllers\Controller;
use App\Models\Tab;
use App\Models\Nodes\TabNode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class TabsNodesController extends Controller
{

    public function create( Tab $parent, $lang)
    {
        $item = TabNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
        if(!empty($item))
            return redirect()->back()->with('error','Выбранный язык уже существует!');
        $item = new TabNode();
        return view('admin.postmonitoring.nodes.tab',[
            'item' => $item,
            'lang' => $lang,
            'parent' => $parent
        ]);
    }
    public function store( Tab $parent, $lang, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new TabNode();
        $item->title = $request->title;

        $item->parent_id = $parent->id;
        $item->lang = $lang;
        $item->save();
       
        return redirect()->route('edit_tab',['item' => $parent->id,'parent'=> $parent->page_id])->with('status','Новый перевод успешно создан!');

    }
    public function edit(TabNode $item)
    {
        $parent = Tab::where('id',$item->parent_id)->first();
        return view('admin.postmonitoring.nodes.tab',[
            'item' => $item,
            'parent' => $parent,
            'lang' => $item->lang
        ]);
    }
    public function update(TabNode $item, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",

        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item->title = $request->title;
       
        $item->save();
        $parent = Tab::where('id',$item->parent_id)->first();
       return redirect()->back()->with('status','Новая запись успешно создана!');

    }
    public function delete(TabNode $item)
    {
        $item->delete();
        return redirect()->back()->with('status','Перевод успешно удален!');
    }


}
