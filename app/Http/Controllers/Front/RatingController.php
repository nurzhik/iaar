<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use App\Models\StaticPage;
use App\Models\Article;
use Carbon\Carbon;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App;



class RatingController extends Controller
{

    public function getIndex(Request $request, $lang = null)
    {
        $countries = Country::where('is_rating',TRUE)->get();
        $item = StaticPage::where('type_id',35)->firstOrnew([]);
        return view('front.rating.index',[
            'lang' =>$lang,
            'countries' => $countries,
            'item' => $item
        ]);
    }
    public function getPage($country_id, $univer_type_id, $year, $lang = null)
    {
        $item = StaticPage::where('type_id',10)
            ->where('country_id',$country_id)
            ->where('univer_type_id',$univer_type_id)
            ->where('year',$year)
            ->first();
        $countries = Country::where('is_rating',TRUE)->get();
        if(empty($item))
            return view('front.rating.index',[
                'lang' =>$lang,
                'countries' => $countries,
                'is_empty_result' => 1,
            ]);
        return view('front.rating.index',[
            'lang' =>$lang,
            'countries' => $countries,
            'item' => $item,
            'country_id' => $country_id,
            'univer_type_id' => $univer_type_id,
            'year' => $year
        ]);

    }
    public function getCouncil($lang = null)
    {
        $item = StaticPage::where('type_id',32)->first();
        $news = Article::where('is_event',false)->orderBy('published_at','DESC')->get()->take(5);
        $board_members  = $item->boardMembers()->orderBy('sort_order')->get();
        return view('front.rating.council',[
            'item' => $item,
            'board_members' => $board_members,
            'news' => $news,
            'lang' => $lang
        ]);
    }

}
