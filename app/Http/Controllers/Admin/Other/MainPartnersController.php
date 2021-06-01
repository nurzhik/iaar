<?php

namespace App\Http\Controllers\Admin\Other;

use App\Http\Controllers\Controller;
use App\Models\MainPartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class MainPartnersController extends Controller
{

    public function index()
    {
        $items = MainPartner::where('id','>',0)->orderBy('sort_order')->get();
        return view('admin.other.main_partners',[
            'items' => $items,
        ]);

    }
    public function create()
    {
        $item = new MainPartner();;
        return view('admin.other.main_partner',[
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
        $item = new MainPartner();
        $item->title = $request->title;
        if(isset($request->logo))
            $item->logo  = str_replace(url('/'),'',$request->logo);
        if(isset($request->image))
            $item->image  = str_replace(url('/'),'',$request->image);
        $item->text = str_replace(url('/'),'',$request->text);
        $item->sort_order = $request->sort_order;
        $item->slug = $request->slug;
        $item->link = $request->link;
        $item->og_title = $request->og_title;
        if(isset($request->og_img))
            $item->og_img  = str_replace(url('/'),'',$request->og_img);
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        isset($request->is_international) ? $item->is_international = true : $item->is_international = false;
        $item->save();
        return redirect()->back()->with('status','Новая запись успешно создана!');

    }
    public function edit(MainPartner $item)
    {
        return view('admin.other.main_partner',[
            'item' => $item,
        ]);
    }
    public function update(MainPartner $item, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",

        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item->title = $request->title;
        if(isset($request->logo))
            $item->logo  = str_replace(url('/'),'',$request->logo);
        if(isset($request->image))
            $item->image  = str_replace(url('/'),'',$request->image);
        $item->text = str_replace(url('/'),'',$request->text);
        $item->sort_order = $request->sort_order;
        $item->slug = $request->slug;
        $item->link = $request->link;
        $item->og_title = $request->og_title;
        if(isset($request->og_img))
            $item->og_img  = str_replace(url('/'),'',$request->og_img);
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        isset($request->is_international) ? $item->is_international = true : $item->is_international = false;
        $item->save();
        return redirect()->back()->with('status','Данные о записи успешно изменены!');

    }
    public function delete(MainPartner $item)
    {
        $item->delete();
        return redirect()->back()->with('status','Партнер успешно удален!');
    }


}
