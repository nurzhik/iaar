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


class IndexController extends Controller
{
    public function getIndex(Request $request, $lang = null)
    {

        $news = Article::where('is_event',FALSE)->orderBy('published_at','DESC')->get()->take(4);
      //  $partners = Partner::where('type_id',0)->orderBy('sort_order')->get();
        $sliders = MainSlider::where('id','>',0)->orderBy('sort_order')->get();
        $acceptance = Partner::where('type_id',1)->orderBy('sort_order')->get();
        $about = StaticPage::where('type_id',36)->firstOrNew([]);
        return view('front.index',[
            'news' => $news,
           // 'partners' => $partners,
            'lang' =>$lang,
            'sliders' => $sliders,
            'acceptance' => $acceptance,
            'about' => $about,
        ]);

    }


}
