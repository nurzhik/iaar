<?php

namespace App\Http\Controllers\Admin\StaticText;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class StaticTextController extends Controller
{
    public function getPage($type)
    {
        if(in_array($type,[35,36,37]))
        {
            $item = StaticPage::where('type_id',$type)->firstorCreate(['type_id'=>$type]);
            if($type == 35)
            {
                return view('admin.static_text.item',[
                    'item'=>$item,
                    'title' => 'Текста на странице Рейтинга',
                ]);
            }
            if($type == 36)
            {
                return view('admin.static_text.about_main_page',[
                    'item'=>$item,
                    'title' => 'Текста "О нас " на главной странице',
                ]);

            }
            if($type == 37)
            {
                return view('admin.static_text.item',[
                    'item'=>$item,
                    'title' => 'Текста на странице аккредитации',
                ]);
            }
            return redirect()->back();
        }
        else
            return redirect()->back();

    }
    public function postPage($type, Request $request)
    {
        if(in_array($type,[35,36,37]))
        {
            $item = StaticPage::where('type_id',$type)->first();
            $item->content = str_replace(url('/'),'',$request->text);
            if(isset($request->main_image))
                $item->main_image  = str_replace(url('/'),'',$request->main_image);
            else
                $item->main_image = null;

            if(isset($request->title))
                $item->title = $request->title;
            if(isset($request->seo_title))
                $item->seo_title = $request->seo_title;
            if(isset($request->seo_keywords))
                $item->seo_keywords = $request->seo_keywords;
            $item->save();
            return redirect()->back()->with('status','Данные успешно сохранены!');
        }
        return redirect()->back();

    }
}
