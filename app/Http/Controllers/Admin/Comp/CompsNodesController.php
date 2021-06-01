<?php

namespace App\Http\Controllers\Admin\Comp;

use App\Http\Controllers\Controller;
use App\Models\Comp;
use App\Models\Nodes\CompNode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class CompsNodesController  extends Controller
{

    public function create( Comp $parent, $lang)
    {
        $item = CompNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
        if(!empty($item))
            return redirect()->back()->with('error','Выбранный язык уже существует!');
        $item = new CompNode();
        return view('admin.comp.nodes.item',[
            'item' => $item,
            'lang' => $lang,
            'parent' => $parent
        ]);
    }
    public function store( Comp $parent, $lang, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "text"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new CompNode();
        $item->text = str_replace(url('/'),'',$request->text);

        $item->parent_id = $parent->id;
        $item->lang = $lang;
        $item->save();
       
       return redirect()->route('comp_edit',['item' => $parent->id])->with('status','Новый перевод успешно создан!');

    }
    public function edit(CompNode $item)
    {
        $parent = Comp::where('id',$item->parent_id)->first();
        return view('admin.comp.nodes.item',[
            'item' => $item,
            'parent' => $parent,
            'lang' => $item->lang
        ]);
    }
    public function update(CompNode $item, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "text"    => "required",

        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item->text = str_replace(url('/'),'',$request->text);
       
        $item->save();
        $parent = Comp::where('id',$item->parent_id)->first();
        return redirect()->route('comp_edit',['item' => $parent->id])->with('status','Данные о переводе изменены!');

    }
    public function delete(CompNode $item)
    {
        $item->delete();
        return redirect()->back()->with('status','Перевод успешно удален!');
    }


}
