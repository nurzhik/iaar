<?php

namespace App\Http\Controllers\Admin\Naar;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use App\Models\CommisionTab;
use App\Models\BoardMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class CommisionTabsController extends Controller
{

   
    public function create(StaticPage $parent)
    {   
     
        $item = new CommisionTab();
        return view('admin.naar.board.tab',[
            'item' => $item,
            'parent' => $parent
        ]);
    }
    public function store(Request $request,StaticPage $parent)
    {   

        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new CommisionTab();
        $item->title = $request->title;
        $item->sort_order = $request->sort_order;
        $item->page_id = $parent->id;
   
        $item->save();
        return redirect()->back()->with('status','Новая запись успешно создана!');

    }
    public function edit(CommisionTab $item, StaticPage $parent)
    {
        return view('admin.naar.board.tab',[
            'item' => $item,
            'parent' => $parent
        ]);
    }
    public function update(CommisionTab $item, Request $request)
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
    public function delete(CommisionTab $item)
    {
        $item->delete();
        return redirect()->back()->with('status','Новость успешно удалена!');
    }


}
