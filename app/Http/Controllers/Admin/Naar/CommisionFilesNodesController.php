<?php

namespace App\Http\Controllers\Admin\Naar;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use App\Models\CommisionFile;
use App\Models\Nodes\CommisionFileNode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class CommisionFilesNodesController extends Controller
{
    public function create( CommisionFile $parent, $lang)
    {

        $item = CommisionFileNode::where('lang',$lang)->where('parent_id',$parent->id)->first();
        if(!empty($item))
            return redirect()->back()->with('status','Выбранный язык уже существует!');
        $item = new CommisionFileNode();
        return view('admin.naar.board.nodes.file',[
            'item' =>$item,
            'parent' => $parent,
            'lang' => $lang,
        ]);

    }
    public function store(  CommisionFile $parent, $lang,Request $request)
    {

        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new CommisionFileNode();
        $item->title = $request->title;

     
        if(isset($request->file))
            $item->file  = str_replace(url('/'),'',$request->file);
        $item->parent_id = $parent->id;
        $item->lang = $lang;


        $item->save();
       return redirect()->back()->with('status','Перевод  успешно создано!');
    }

    public function edit( CommisionFileNode $item)
    {
        $parent = CommisionFile::where('id',$item->parent_id)->first();
        return view('admin.naar.board.nodes.file',[
            'item' =>$item,
            'parent' => $parent,
            'lang' => $item->lang,
        ]);

    }
    public function update(CommisionFileNode $item,  Request $request)
    {

        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $parent = CommisionFile::where('id',$item->parent_id)->first();
        $item->title = $request->title;
      
        if(isset($request->file))
            $item->file  = str_replace(url('/'),'',$request->file);
        $item->parent_id = $parent->id;
        $item->save();
         return redirect()->back()->with('status','Данные о переводе изменены!');



    }
    public function delete( CommisionFileNode $item)
    {

        $item->delete();
        return redirect()->back()->with('status','Запись успешно удалена!');

    }


}