<?php

namespace App\Http\Controllers\Admin\Naar;

use App\Http\Controllers\Controller;
use App\Models\CommisionTab;
use App\Models\Nodes\CommisionTabNode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class CommisionTabsNodesController extends Controller
{

    public function create( CommisionTab $parent, $lang)
    {
        $item = CommisionTabNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
        if(!empty($item))
            return redirect()->back()->with('error','Выбранный язык уже существует!');
        $item = new CommisionTabNode();
        return view('admin.naar.board.nodes.tab',[
            'item' => $item,
            'lang' => $lang,
            'parent' => $parent
        ]);
    }
    public function store( CommisionTab $parent, $lang, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new CommisionTabNode();
        $item->title = $request->title;

        $item->parent_id = $parent->id;
        $item->lang = $lang;
        $item->save();
       
        return redirect('/admin/naar/board/57')->with('status','Новый перевод успешно создан!');

    }
    public function edit(CommisionTabNode $item)
    {
        $parent = CommisionTab::where('id',$item->parent_id)->first();
        return view('admin.naar.board.nodes.tab',[
            'item' => $item,
            'parent' => $parent,
            'lang' => $item->lang
        ]);
    }
    public function update(CommisionTabNode $item, Request $request)
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
        $parent = CommisionTab::where('id',$item->parent_id)->first();
        return redirect('/admin/naar/board/57')->with('status','Данные о переводе изменены!');

    }
    public function delete(CommisionTabNode $item)
    {
        $item->delete();
        return redirect()->back()->with('status','Перевод успешно удален!');
    }


}
