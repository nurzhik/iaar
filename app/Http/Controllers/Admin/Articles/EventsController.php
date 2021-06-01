<?php

namespace App\Http\Controllers\Admin\Articles;

use App\Http\Controllers\Controller;
use App\Models\Events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class EventsController extends Controller
{

    public function index()
    {
        $items = Events::all();
        return view('admin.articles.events',[
            'items' => $items,
        ]);

    }
    public function create()
    {
        $item = new Events();;
        return view('admin.articles.event',[
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
        $item = new Events();
        $item->title = $request->title;
        if(isset($request->main_image))
            $item->main_image  = str_replace(url('/'),'',$request->main_image);
        isset($request->published) ? $item->published = true : $item->published = false;
        $item->published_at = $request->published_at;
        $item->text = str_replace(url('/'),'',$request->text);
        $item->short_desc = $request->short_desc;
        $item->event_date = $request->event_date;
        $item->slug = $request->slug;
        $item->og_title = $request->og_title;
        if(isset($request->og_img))
            $item->og_img  = str_replace(url('/'),'',$request->og_img);
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        return redirect()->back()->with('status','Новая запись успешно создана!');

    }
    public function edit(Events $item)
    {
        return view('admin.articles.event',[
            'item' => $item,
        ]);
    }
    public function update(Events $item, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",

        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item->title = $request->title;
        if(isset($request->main_image))
            $item->main_image  = str_replace(url('/'),'',$request->main_image);
        isset($request->published) ? $item->published = true : $item->published = false;
        $item->published_at = $request->published_at;
        $item->text = str_replace(url('/'),'',$request->text);
        $item->short_desc = $request->short_desc;
        $item->event_date = $request->event_date;
        $item->slug = $request->slug;
        $item->og_title = $request->og_title;
        if(isset($request->og_img))
            $item->og_img  = str_replace(url('/'),'',$request->og_img);
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        return redirect()->back()->with('status','Данные о записи успешно изменены!');

    }
    public function delete(Events $item)
    {
        $item->delete();
        return redirect()->back()->with('status','Событие успешно удалено!');
    }


}
