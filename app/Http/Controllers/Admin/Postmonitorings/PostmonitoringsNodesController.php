<?php

namespace App\Http\Controllers\Admin\Postmonitorings;

use App\Http\Controllers\Controller;
use App\Models\Postmonitoring;
use App\Models\Nodes\PostmonitoringNode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class PostmonitoringsNodesController extends Controller
{

    public function create( Postmonitoring $parent, $lang)
    {
        $item = PostmonitoringNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
        if(!empty($item))
            return redirect()->back()->with('error','Выбранный язык уже существует!');
        $item = new PostmonitoringNode();
        return view('admin.postmonitoring.nodes.item',[
            'item' => $item,
            'lang' => $lang,
            'parent' => $parent
        ]);
    }
    public function store( Postmonitoring $parent, $lang, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new PostmonitoringNode();
        $item->title = $request->title;
        $item->content = str_replace(url('/'),'',$request->content);

        $item->parent_id = $parent->id;
        $item->lang = $lang;
        $item->save();
       
            return redirect()->route('postmonitoring_edit_page',['item' => $parent->id])->with('status','Новый перевод успешно создан!');

    }
    public function edit(PostmonitoringNode $item)
    {
        $parent = Postmonitoring::where('id',$item->parent_id)->first();
        return view('admin.postmonitoring.nodes.item',[
            'item' => $item,
            'parent' => $parent,
            'lang' => $item->lang
        ]);
    }
    public function update(PostmonitoringNode $item, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",

        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item->title = $request->title;
        $item->content = str_replace(url('/'),'',$request->content);
       
        $item->save();
        $parent = Postmonitoring::where('id',$item->parent_id)->first();
        return redirect()->route('postmonitoring_edit_page',['item' => $parent->id])->with('status','Данные о переводе изменены!');

    }
    public function delete(PostmonitoringNode $item)
    {
        $item->delete();
        return redirect()->back()->with('status','Перевод успешно удален!');
    }


}
