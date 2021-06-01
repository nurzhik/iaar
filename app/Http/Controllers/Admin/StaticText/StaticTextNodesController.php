<?php

namespace App\Http\Controllers\Admin\StaticText;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use App\Models\Nodes\StaticPageNode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class StaticTextNodesController extends Controller
{
    public function getPage($type,$lang)
    {
        if(in_array($type,[35,36,37]))
        {
            $parent = StaticPage::where('type_id',$type)->first();
            $item = $parent->nodes()->where('lang',$lang)->first();
            if(empty($item))
            {
                $item = new StaticPageNode();
                $item->parent_id = $parent->id;
                $item->lang = $lang;
                $item->save();
            }
            if($type == 35)
            {
                return view('admin.static_text.nodes.item',[
                    'item'=>$item,
                    'title' => 'Текста на странице Рейтинга',
                    'lang' => $lang,
                ]);
            }
            if($type == 36)
            {
                return view('admin.static_text.nodes.about_main_page',[
                    'item'=>$item,
                    'title' => 'Текста "О нас " на главной странице',
                    'lang' => $lang,
                ]);

            }
            if($type == 37)
            {
                return view('admin.static_text.nodes.item',[
                    'item'=>$item,
                    'title' => 'Текста на странице аккредитации',
                    'lang' => $lang,
                ]);
            }
            return redirect()->back();
        }
        else
            return redirect()->back();

    }
    public function postPage($type, $lang, Request $request)
    {
        if(in_array($type,[35,36,37]))
        {
            $parent = StaticPage::where('type_id',$type)->first();
            $item = $parent->nodes()->where('lang',$lang)->first();
            $item->content = str_replace(url('/'),'',$request->text);
            if(isset($request->main_image))
                $item->main_image  = str_replace(url('/'),'',$request->main_image);
            if(isset($request->title))
                $item->title = $request->title;
            if(isset($request->seo_title))
                $item->seo_title = $request->seo_title;
            if(isset($request->seo_keywords))
                $item->seo_keywords = $request->seo_keywords;
            $item->save();
            return redirect()->route('edit_static_text',['type'=>$type])->with('status','Данные о переводе успешно сохранены!');
        }
        return redirect()->back();

    }
}
