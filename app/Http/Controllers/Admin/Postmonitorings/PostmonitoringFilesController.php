<?php

namespace App\Http\Controllers\Admin\Postmonitorings;

use App\Http\Controllers\Controller;
use App\Models\PostmonitoringFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class PostmonitoringFilesController extends Controller
{   
    public function index()
    {
        $items = PostmonitoringFile::where('id','>',0)->get();
        return view('admin.postmonitoring.files',[
            'items' => $items,
        ]);

    }
    public function create( )
    {
        $item = new PostmonitoringFile();
        return view('admin.postmonitoring.files_item',[
            'item' => $item,
        ]);

    }
    public function store(  Request $request)
    {   

        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new PostmonitoringFile();
        $item->title = $request->title;

        
        if(isset($request->file))
            $item->file  = str_replace(url('/'),'',$request->file);
        $item->save();
        return redirect()->back()->with('status','Новое вложение успешно создано!');

    }
    public function edit( PostmonitoringFile $item)
    {
   
        return view('admin.postmonitoring.files_item',[
            'item' => $item,
        ]);


    }
    public function update(PostmonitoringFile $item, Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item->title = $request->title;
        
        $item->file  = str_replace(url('/'),'',$request->file);
        $item->save();
        return redirect()->back()->with('status','Данные о вложении успешно изменены!');



    }
    public function delete(PostmonitoringFile $item)
    {
        $item->delete();
        return redirect()->back()->with('status','Запись успешно удалена!');
    }


}