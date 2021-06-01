<?php

namespace App\Http\Controllers\Admin\Postmonitorings;

use App\Http\Controllers\Controller;
use App\Models\Tab;
use App\Models\Postmonitoring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class TabsController extends Controller
{

   
    public function create(Postmonitoring $parent)
    {   
        $item = new Tab();;
        return view('admin.postmonitoring.tab',[
            'item' => $item,
            'parent' => $parent
        ]);
    }
    public function store(Request $request,Postmonitoring $parent)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new Tab();
        $item->title = $request->title;
        $item->sort_order = $request->sort_order;
        $item->page_id = $parent->id;
   
        $item->save();
        return redirect()->back()->with('status','Новая запись успешно создана!');

    }
    public function edit(Tab $item, Postmonitoring $parent)
    {
        return view('admin.postmonitoring.tab',[
            'item' => $item,
            'parent' => $parent
        ]);
    }
    public function update(Tab $item, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",

        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item->title = $request->title;
        $item->sort_order = $request->sort_order;
      
        $item->save();
        return redirect()->back()->with('status','Данные о записи успешно изменены!');

    }
    public function delete(Tab $item)
    {
        $item->delete();
        return redirect()->back()->with('status','Новость успешно удалена!');
    }


}
