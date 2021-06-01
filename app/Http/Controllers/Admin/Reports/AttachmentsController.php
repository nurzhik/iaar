<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class AttachmentsController extends Controller
{
    public function create(int $type, StaticPage $parent)
    {
        $item = new Attachment();
        $ar = array_flip(StaticPage::getTypeIdArray());
        return view('admin.reports.attachments.'.$ar[$type],[
            'item' => $item,
            'parent' => $parent,
            'type' => $type
        ]);

    }
    public function store(int $type, StaticPage $parent, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new Attachment();
        $item->title = $request->title;
        $item->sort_order = $request->sort_order;

        if(isset($request->year))
            $item->year = $request->year;
        if(isset($request->short_desc))
            $item->short_desc = $request->short_desc;
        if(isset($request->show_date))
            $item->show_date = $request->show_date;
        if(isset($request->image))
            $item->image  = str_replace(url('/'),'',$request->image);
        if(isset($request->file))
            $item->file  = str_replace(url('/'),'',$request->file);
        $item->page_id = $parent->id;
         
        $item->save();
        return redirect()->back()->with('status','Новое вложение успешно создано!');

    }
    public function edit(int $type,StaticPage $parent, Attachment $item)
    {
        if($item->page_id !== $parent->id or $parent->type_id !== $type)
            return redirect()->back()->with('error','Неправильные данные!');
        $ar = array_flip(StaticPage::getTypeIdArray());
        return view('admin.reports.attachments.'.$ar[$type],[
            'item' => $item,
            'parent' => $parent,
            'type' => $type
        ]);


    }
    public function update(int $type,StaticPage $parent, Attachment $item, Request $request)
    {
        if($item->page_id !== $parent->id or $parent->type_id !== $type)
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

        if(isset($request->year))
            $item->year = $request->year;
        if(isset($request->short_desc))
            $item->short_desc = $request->short_desc;
        if(isset($request->show_date))
            $item->show_date = $request->show_date;
        if(isset($request->image))
            $item->image  = str_replace(url('/'),'',$request->image);
        if(isset($request->file))
            $item->file  = str_replace(url('/'),'',$request->file);
        $item->page_id = $parent->id;
        $item->save();
        return redirect()->back()->with('status','Данные о вложении успешно изменены!');



    }
    public function delete(int $type,StaticPage $parent, Attachment $item)
    {
        if($parent->type_id  == $type)
        {
            $item->delete();
            return redirect()->back()->with('status','Запись успешно удалена!');
        }
        else
            return redirect()->back()->with('status','Неправильный тип!');



    }


}