<?php

namespace App\Http\Controllers\Admin\Comp;

use App\Http\Controllers\Controller;
use App\Models\Comp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class CompsController extends Controller
{

    public function index()
    {
        $items = Comp::all();
        return view('admin.comp.index',[
            'items' => $items,
        ]);

    }
    public function create()
    {
        $item = new Comp();;
        return view('admin.comp.item',[
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
        $item = new Comp();
        $item->title = $request->title;
        $item->text = str_replace(url('/'),'',$request->text);
      
      
        $item->save();
        return redirect()->back()->with('status','Новая запись успешно создана!');

    }
    public function edit(Comp $item)
    {
        return view('admin.comp.item',[
            'item' => $item,
        ]);
    }
    public function update(Comp $item, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",

        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item->title = $request->title;
        $item->text = str_replace(url('/'),'',$request->text);
        $item->save();
        return redirect()->back()->with('status','Данные о записи успешно изменены!');

    }
    public function delete(Comp $item)
    {   
        $item->delete();
        return redirect()->back()->with('status','Новость успешно удалена!');
    }


}
