<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class SmiEventsController extends Controller
{
    public function create()
    {
        $item = new StaticPage();
        return view('admin.reports.smi_event',[
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
        $item = new StaticPage();
        $item->type_id = 30;
        $item->title = $request->title;
        if(isset($request->main_image))
            $item->main_image  = str_replace(url('/'),'',$request->main_image);
        $item->created_at = $request->published_at;
        $item->content = str_replace(url('/'),'',$request->text);
        $item->additional_documents = $request->short_desc;
        $item->slug = $request->slug;
        $item->og_title = $request->og_title;
        if(isset($request->og_img))
            $item->og_img  = str_replace(url('/'),'',$request->og_img);
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        return redirect()->route('edit_reports_page',['type'=>16])->with('status','Новая запись успешно создана!');

    }
    public function edit(StaticPage $item)
    {
        if($item->type_id != 30)
            return redirect()->back()->with('error','Неверный тип страницы!');
        return view('admin.reports.smi_event',[
            'item' => $item,
        ]);
    }
    public function update(StaticPage $item, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",

        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        if($item->type_id != 30)
            return redirect()->back()->with('error','Неверный тип страницы!');
        $item->title = $request->title;
        if(isset($request->main_image))
            $item->main_image  = str_replace(url('/'),'',$request->main_image);
        $item->created_at = $request->published_at;
        $item->content = str_replace(url('/'),'',$request->text);
        $item->additional_documents = $request->short_desc;
        $item->slug = $request->slug;
        $item->og_title = $request->og_title;
        if(isset($request->og_img))
            $item->og_img  = str_replace(url('/'),'',$request->og_img);
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        return redirect()->route('edit_reports_page',['type'=>16])->with('status','Данные о записи успешно изменены!');

    }
    public function delete(StaticPage $item)
    {
        if($item->type_id != 30)
            return redirect()->back()->with('error','Неверный тип страницы!');
        $item->delete();
        return redirect()->back()->with('status','Новость успешно удалена!');
    }


}
