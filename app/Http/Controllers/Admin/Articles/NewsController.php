<?php

namespace App\Http\Controllers\Admin\Articles;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class NewsController extends Controller
{

    public function index()
    {
        $items = News::all();
        return view('admin.articles.news',[
            'items' => $items,
        ]);

    }
    public function create()
    {
        $item = new News();;
        return view('admin.articles.article',[
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
        $item = new News();
        $item->title = $request->title;
        if(isset($request->main_image))
            $item->main_image  = str_replace(url('/'),'',$request->main_image);
        isset($request->published) ? $item->published = true : $item->published = false;
        $item->published_at = $request->published_at;
        $item->text = str_replace(url('/'),'',$request->text);
        $item->short_desc = $request->short_desc;
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
    public function edit(News $item)
    {
        return view('admin.articles.article',[
            'item' => $item,
        ]);
    }
    public function update(News $item, Request $request)
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
    public function delete(News $item)
    {
        $item->delete();
        return redirect()->back()->with('status','Новость успешно удалена!');
    }


}
