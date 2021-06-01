<?php

namespace App\Http\Controllers\Admin\Postmonitorings;

use App\Http\Controllers\Controller;
use App\Models\Postmonitoring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class PostmonitoringsController extends Controller
{

    public function index()
    {
        $items = Postmonitoring::where('type_id',0)->get();
        return view('admin.postmonitoring.index',[
            'items' => $items,
        ]);

    }
    public function create()
    {
        $item = new Postmonitoring();;
        return view('admin.postmonitoring.item',[
            'item' => $item,
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new Postmonitoring();
        $item->title = $request->title;
        $item->content = str_replace(url('/'),'',$request->text);
        $item->slug = $request->slug;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
      
        $item->save();
        return redirect()->back()->with('status','Новая запись успешно создана!');

    }
    public function edit(Postmonitoring $item)
    {
        return view('admin.postmonitoring.item',[
            'item' => $item,
        ]);
    }
    public function update(Postmonitoring $item, Request $request)
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
       
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        return redirect()->back()->with('status','Данные о записи успешно изменены!');

    }
    public function delete(Postmonitoring $item)
    {   
        $item->delete();
        return redirect()->back()->with('status','Новость успешно удалена!');
    }


}
