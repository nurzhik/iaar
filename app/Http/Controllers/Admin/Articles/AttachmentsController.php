<?php

namespace App\Http\Controllers\Admin\Articles;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class AttachmentsController extends Controller
{
    public function create(Article $parent)
    {
        $item = new Attachment();
        return view('admin.articles.attachment',[
            'item' => $item,
            'parent' => $parent,
        ]);

    }
    public function store( Article $parent, Request $request)
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
        $item->article_id = $parent->id;

        $item->save();
        return redirect()->back()->with('status','Новое вложение успешно создано!');

    }
    public function edit(Article $parent, Attachment $item)
    {
        if($item->article_id !== $parent->id )
            return redirect()->back()->with('error','Неправильные данные!');
        return view('admin.articles.attachment',[
            'item' => $item,
            'parent' => $parent,
        ]);


    }
    public function update(Article $parent, Attachment $item, Request $request)
    {
        if($item->article_id !== $parent->id)
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
        $item->article_id = $parent->id;
        $item->save();
        return redirect()->back()->with('status','Данные о вложении успешно изменены!');



    }
    public function delete(Article $parent, Attachment $item)
    {
            $item->delete();
            return redirect()->back()->with('status','Запись успешно удалена!');
    }


}
