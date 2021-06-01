<?php

namespace App\Http\Controllers\Admin\Naar\InternationalCoop\Nodes;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use App\Models\Nodes\StaticPageNode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class InternationalEventsNodesController extends Controller
{

    public function create( StaticPage $parent, $lang)
    {
        if($parent->type_id!=24)
            return redirect()->back()->with('error','Неверный тип страницы');
        $item = StaticPageNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
        if(!empty($item))
            return redirect()->back()->with('error','Выбранный язык уже существует!');
        $item = new StaticPageNode();
        return view('admin.naar.intern_coop.nodes.event',[
            'item' => $item,
            'lang' => $lang,
            'parent' => $parent
        ]);
    }
    public function store( StaticPage $parent, $lang, Request $request)
    {
        if($parent->type_id!=24)
            return redirect()->back()->with('error','Неверный тип страницы');
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new StaticPageNode();
        $item->title = $request->title;
        $item->content = str_replace(url('/'),'',$request->text);
        $item->additional_documents = $request->short_desc;
        $item->og_title = $request->og_title;
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;

        $item->parent_id = $parent->id;
        $item->lang = $lang;
        $item->save();
        return redirect()->route('edit_int_event',['item' => $parent->id])->with('status','Новый перевод успешно создан!');

    }
    public function edit(StaticPageNode $item)
    {
        $parent = StaticPage::where('id',$item->parent_id)->first();
        return view('admin.naar.intern_coop.nodes.event',[
            'item' => $item,
            'parent' => $parent,
            'lang' => $item->lang
        ]);
    }
    public function update(StaticPageNode $item, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",

        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item->title = $request->title;
        $item->content = str_replace(url('/'),'',$request->text);
        $item->additional_documents = $request->short_desc;
        $item->og_title = $request->og_title;
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        $parent = StaticPage::where('id',$item->parent_id)->first();
        return redirect()->route('edit_int_event',['item' => $parent->id])->with('status','Новый перевод успешно создан!');
    }
    public function delete(StaticPageNode $item)
    {
        $item->delete();
        return redirect()->back()->with('status','Перевод успешно удален!');
    }


}
