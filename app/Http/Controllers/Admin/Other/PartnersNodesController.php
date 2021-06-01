<?php

namespace App\Http\Controllers\Admin\Other;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\Nodes\PartnerNode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class PartnersNodesController extends Controller
{

    public function create( Partner $parent, $lang)
    {
        $item = PartnerNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
        if(!empty($item))
            return redirect()->back()->with('error','Выбранный язык уже существует!');
        $item = new PartnerNode();
        return view('admin.other.nodes.partner',[
            'item' => $item,
            'lang' => $lang,
            'parent' => $parent
        ]);
    }
    public function store( Partner $parent, $lang, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new PartnerNode();
        $item->title = $request->title;
        $item->text = str_replace(url('/'),'',$request->text);
        $item->og_title = $request->og_title;
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;

        $item->parent_id = $parent->id;
        $item->lang = $lang;
        $item->save();
        if($parent->type_id == 0)
            return redirect()->route('edit_main_partner',['item' => $parent->id])->with('status','Новый перевод успешно создан!');
        else
            return redirect()->route('edit_acceptance_partner',['item' => $parent->id])->with('status','Новый перевод успешно создан!');

    }
    public function edit(PartnerNode $item)
    {
        $parent = Partner::where('id',$item->parent_id)->first();
        return view('admin.other.nodes.partner',[
            'item' => $item,
            'lang' => $item->lang,
            'parent' => $parent
        ]);
    }
    public function update(PartnerNode $item, Request $request)
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
        $item->og_title = $request->og_title;
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        $parent = Partner::where('id',$item->parent_id)->first();
        if($parent->type_id == 0)
            return redirect()->route('edit_main_partner',['item' => $parent->id])->with('status','Данные о переводе изменены!');
        else
            return redirect()->route('edit_acceptance_partner',['item' => $parent->id])->with('status','Данные о переводе изменены!');

    }
    public function delete(PartnerNode $item)
    {
        $item->delete();
        return redirect()->back()->with('status','Перевод успешно удален!');
    }


}
