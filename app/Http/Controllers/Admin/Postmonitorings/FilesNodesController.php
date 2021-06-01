<?php

namespace App\Http\Controllers\Admin\Postmonitorings;

use App\Http\Controllers\Controller;
use App\Models\Postmonitoring;
use App\Models\File;
use App\Models\Nodes\FileNode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class FilesNodesController extends Controller
{
    public function create( File $parent, $lang)
    {

        $item = FileNode::where('lang',$lang)->where('parent_id',$parent->id)->first();
        if(!empty($item))
            return redirect()->back()->with('status','Выбранный язык уже существует!');
        $item = new FileNode();
        return view('admin.postmonitoring.nodes.file',[
            'item' =>$item,
            'parent' => $parent,
            'lang' => $lang,
        ]);

    }
    public function store(  File $parent, $lang,Request $request)
    {

        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new FileNode();
        $item->title = $request->title;

        if(isset($request->short_desc))
            $item->short_desc = $request->short_desc;
        if(isset($request->image))
            $item->image  = str_replace(url('/'),'',$request->image);
        if(isset($request->file))
            $item->file  = str_replace(url('/'),'',$request->file);
        $item->parent_id = $parent->id;
        $item->lang = $lang;


        $item->save();
       return redirect()->route('postmonitoring_edit_page',['item' => $parent->page_id])->with('status','Новый перевод успешно создан!');
    }

    public function edit( FileNode $item)
    {
        $parent = File::where('id',$item->parent_id)->first();
        return view('admin.postmonitoring.nodes.file',[
            'item' =>$item,
            'parent' => $parent,
            'lang' => $item->lang,
        ]);

    }
    public function update(FileNode $item,  Request $request)
    {

        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $parent = File::where('id',$item->parent_id)->first();
        $item->title = $request->title;
        if(isset($request->short_desc))
            $item->short_desc = $request->short_desc;
        if(isset($request->image))
            $item->image  = str_replace(url('/'),'',$request->image);
        if(isset($request->file))
            $item->file  = str_replace(url('/'),'',$request->file);
        $item->parent_id = $parent->id;
        $item->save();
         return redirect()->route('postmonitoring_edit_page',['item' => $parent->page_id])->with('status','Данные о переводе изменены!');



    }
    public function delete( FileNode $item)
    {

        $item->delete();
        return redirect()->back()->with('status','Запись успешно удалена!');

    }


}