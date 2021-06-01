<?php

namespace App\Http\Controllers\Admin\Articles;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Nodes\ArticleNode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class ArticleNodesController extends Controller
{

    public function create( Article $parent, $lang)
    {
        $item = ArticleNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
        if(!empty($item))
            return redirect()->back()->with('error','Выбранный язык уже существует!');
        $item = new ArticleNode();
        return view('admin.articles.nodes.item',[
            'item' => $item,
            'lang' => $lang,
            'parent' => $parent
        ]);
    }
    public function store( Article $parent, $lang, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new ArticleNode();
        $item->title = $request->title;
        $item->text = str_replace(url('/'),'',$request->text);
        $item->short_desc = $request->short_desc;
        $item->og_title = $request->og_title;
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;

        $item->parent_id = $parent->id;
        $item->lang = $lang;
        $item->save();
        if($parent->is_event)
            return redirect()->route('edit_event',['item' => $parent->id])->with('status','Новый перевод успешно создан!');
        else
            return redirect()->route('edit_news',['item' => $parent->id])->with('status','Новый перевод успешно создан!');

    }
    public function edit(ArticleNode $item)
    {
        $parent = Article::where('id',$item->parent_id)->first();
        return view('admin.articles.nodes.item',[
            'item' => $item,
            'parent' => $parent,
            'lang' => $item->lang
        ]);
    }
    public function update(ArticleNode $item, Request $request)
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
        $item->short_desc = $request->short_desc;
        $item->og_title = $request->og_title;
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        $parent = Article::where('id',$item->parent_id)->first();
        if($parent->is_event)
            return redirect()->route('edit_event',['item' => $parent->id])->with('status','Данные о переводе изменены!');
        else
            return redirect()->route('edit_news',['item' => $parent->id])->with('status','Данные о переводе изменены!');

    }
    public function delete(ArticleNode $item)
    {
        $item->delete();
        return redirect()->back()->with('status','Перевод успешно удален!');
    }


}
