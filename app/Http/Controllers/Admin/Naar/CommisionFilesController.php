<?php

namespace App\Http\Controllers\Admin\Naar;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use App\Models\CommisionFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class CommisionFilesController extends Controller
{
    public function create( StaticPage $parent)
    {
        $item = new CommisionFile();
        return view('admin.naar.board.file',[
            'item' => $item,
            'parent' => $parent,
        ]);

    }
    public function store( StaticPage $parent, Request $request)
    {   

        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new CommisionFile();
        $item->title = $request->title;
        $item->sort_order = $request->sort_order;

        
        if(isset($request->file))
            $item->file  = str_replace(url('/'),'',$request->file);
         $item->type_id = $request->type_id;
        $item->page_id = $parent->id;
        $item->save();
        return redirect()->back()->with('status','Новое вложение успешно создано!');

    }
    public function edit( CommisionFile $item,Staticpage $parent)
    {
        if($item->page_id !== $parent->id )
            return redirect()->back()->with('error','Неправильные данные!');
        return view('admin.naar.board.file',[
            'item' => $item,
            'parent' => $parent,
        ]);


    }
    public function update(Staticpage $parent, CommisionFile $item, Request $request)
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
      
        if(isset($request->file))
            $item->file  = str_replace(url('/'),'',$request->file);
        $item->type_id = $request->type_id;
        $item->page_id = $parent->id;
        $item->save();
        return redirect()->back()->with('status','Данные о вложении успешно изменены!');



    }
    public function delete(Staticpage $parent, CommisionFile $item)
    {
       
            $item->delete();
            return redirect()->back()->with('status','Запись успешно удалена!');
       



    }


}