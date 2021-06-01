<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use App\Models\Article;
use App\Models\Partner;
use App\Models\MainSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class SearchController extends Controller
{

    public function getSearch(Request $request, $lang = null)
    {
        $results =Article::where('id','<',0)->paginate(8);
        if(isset($request->search))
        {
            $key = mb_strtolower($request->search);
            if($lang == null or $lang == 'ru')
            {
                $results = Article::whereRaw('lower(title) like (?)',["%{$key}%"])
                    ->orWhereRaw('lower(short_desc) like (?)',["%{$key}%"])
                    ->orWhereRaw('lower(text) like (?)',["%{$key}%"])
                    ->orderBy('created_at','DESC')->paginate(7);
            }
            else
            {
                $results = Article::whereHas('nodes',function($query) use($request, $lang,$key){
                    $query->where('lang',$lang)->where(function($article_node) use($key){
                        $article_node->whereRaw('lower(title) like (?)',["%{$key}%"])
                            ->orWhereRaw('lower(short_desc) like (?)',["%{$key}%"])
                            ->orWhereRaw('lower(text) like (?)',["%{$key}%"]);
                    });
                })->orderBy('created_at','DESC')->paginate(7);
            }
        }
        return view('front.search_results',[
            'results' => $results,
            'lang' => $lang,
            'request' => $request
        ]);
    }

}
