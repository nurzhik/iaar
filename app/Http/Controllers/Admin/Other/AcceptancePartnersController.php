<?php

namespace App\Http\Controllers\Admin\Other;

use App\Http\Controllers\Controller;
use App\Models\AcceptancePartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class AcceptancePartnersController extends Controller
{

    public function index()
    {
        $items = AcceptancePartner::where('id','>',0)->orderBy('sort_order')->get();
        return view('admin.other.acceptance_partners',[
            'items' => $items,
        ]);

    }
    public function create()
    {
        $item = new AcceptancePartner();;
        return view('admin.other.acceptance_partner',[
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
        $item = new AcceptancePartner();
        $item->title = $request->title;
        if(isset($request->logo))
            $item->logo  = str_replace(url('/'),'',$request->logo);
        if(isset($request->image))
            $item->image  = str_replace(url('/'),'',$request->image);
        $item->text = str_replace(url('/'),'',$request->text);
        $item->sort_order = $request->sort_order;
        $item->link = $request->link;
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
    public function edit(AcceptancePartner $item)
    {
        return view('admin.other.acceptance_partner',[
            'item' => $item,
        ]);
    }
    public function update(AcceptancePartner $item, Request $request)
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
        $item->save();
        return redirect()->back()->with('status','Данные о записи успешно изменены!');

    }
    public function delete(AcceptancePartner $item)
    {
        $item->delete();
        return redirect()->back()->with('status','Партнер успешно удален!');
    }


}
