<?php

namespace App\Http\Controllers\Admin\Postmonitorings;

use App\Http\Controllers\Controller;
use App\Models\Postmonitoring;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class FilesController extends Controller
{
    public function create( Postmonitoring $parent)
    {
        $item = new File();
        return view('admin.postmonitoring.file',[
            'item' => $item,
            'parent' => $parent,
        ]);

    }
    public function store( Postmonitoring $parent, Request $request)
    {   

        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new File();
        $item->title = $request->title;
        $item->sort_order = $request->sort_order;

        if(isset($request->short_desc))
            $item->short_desc = $request->short_desc;
        if(isset($request->image))
            $item->image  = str_replace(url('/'),'',$request->image);
        if(isset($request->file))
            $item->file  = str_replace(url('/'),'',$request->file);
         $item->type_id = $request->type_id;
        $item->page_id = $parent->id;
        $item->save();
        return redirect()->back()->with('status','Новое вложение успешно создано!');

    }
    public function edit( File $item,Postmonitoring $parent)
    {
        if($item->page_id !== $parent->id )
            return redirect()->back()->with('error','Неправильные данные!');
        return view('admin.postmonitoring.file',[
            'item' => $item,
            'parent' => $parent,
        ]);


    }
    public function update(Postmonitoring $parent, File $item, Request $request)
    {
        if($item->page_id !== $parent->id )
            return redirect()->back()->with('error','Неправильные данные!');
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item->title = $request->title;
        $item->sort_order = $request->sort_order;

        
        if(isset($request->short_desc))
            $item->short_desc = $request->short_desc;
       
        if(isset($request->image))
            $item->image  = str_replace(url('/'),'',$request->image);
        if(isset($request->file))
            $item->file  = str_replace(url('/'),'',$request->file);
        $item->type_id = $request->type_id;
        $item->page_id = $parent->id;
        $item->save();
        return redirect()->back()->with('status','Данные о вложении успешно изменены!');



    }
    public function delete(Postmonitoring $parent, File $item)
    {
       
            $item->delete();
            return redirect()->back()->with('status','Запись успешно удалена!');
       



    }


}