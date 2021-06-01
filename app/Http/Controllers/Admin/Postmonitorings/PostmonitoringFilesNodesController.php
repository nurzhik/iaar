<?php

namespace App\Http\Controllers\Admin\Postmonitorings;

use App\Http\Controllers\Controller;
use App\Models\PostmonitoringFile;
use App\Models\Nodes\PostmonitoringFileNode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class PostmonitoringFilesNodesController extends Controller
{
    public function create( PostmonitoringFile $parent, $lang)
    {

        $item = PostmonitoringFileNode::where('lang',$lang)->where('parent_id',$parent->id)->first();
        if(!empty($item))
            return redirect()->back()->with('status','Выбранный язык уже существует!');
        $item = new PostmonitoringFileNode();
        return view('admin.postmonitoring.nodes.files_item',[
            'item' =>$item,
            'parent' => $parent,
            'lang' => $lang,
        ]);

    }
    public function store(  PostmonitoringFile $parent, $lang,Request $request)
    {

        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new PostmonitoringFileNode();
        $item->title = $request->title;

       
        if(isset($request->file))
            $item->file  = str_replace(url('/'),'',$request->file);
        $item->parent_id = $parent->id;
        $item->lang = $lang;
        $item->save();
        return redirect()->route('edit_postmonitoring_file',['item' => $parent->page_id])->with('status','Данные о переводе изменены!');
    }

    public function edit( PostmonitoringFileNode $item)
    {
        $parent = PostmonitoringFile::where('id',$item->parent_id)->first();
        return view('admin.postmonitoring.nodes.files_item',[
            'item' =>$item,
            'parent' => $parent,
            'lang' => $item->lang,
        ]);

    }
    public function update(PostmonitoringFileNode $item,  Request $request)
    {

        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $parent = PostmonitoringFile::where('id',$item->parent_id)->first();
        $item->title = $request->title;
        if(isset($request->short_desc))
            $item->short_desc = $request->short_desc;
        if(isset($request->image))
            $item->image  = str_replace(url('/'),'',$request->image);
        if(isset($request->file))
            $item->file  = str_replace(url('/'),'',$request->file);
        $item->parent_id = $parent->id;
        $item->save();
         return redirect()->route('edit_postmonitoring_file',['item' => $parent->page_id])->with('status','Данные о переводе изменены!');



    }
    public function delete( PostmonitoringFileNode $item)
    {

        $item->delete();
        return redirect()->back()->with('status','Запись успешно удалена!');

    }


}