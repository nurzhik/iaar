<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Events;
use App\Models\News;
use App\Models\Article;
use App\Models\Partner;
use Carbon\Carbon;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App;



class ArticleController extends Controller
{
    public function getEvents($type,$lang = null,Request $request)
    {
        $now = Carbon::now();
        $now = $now->toDateTimeString();
        $future_events = Events::where('event_date','>=',$now)->orderBy('event_date')->get();
        if(isset($request->year))
        {
            $past_events = Events::where('event_date','<=',$now)
                ->where('event_date','>=',$request->year.'-01-01 00:00:00')
                ->where('event_date','<=',$request->year.'-12-31 23:59:59')
                ->orderBy('event_date')->get();
        }
        else
        {
            $date = Carbon::now();
            $past_events = Events::where('event_date','<=',$now)
                ->where('event_date','>=',$date->year.'-01-01 00:00:00')
                ->where('event_date','<=',$date->year.'-12-31 23:59:59')
                ->orderBy('event_date')->get();
        }
        return view('front.articles.events',[
            'future_events' => $future_events,
            'type' => $type,
            'past_events' => $past_events,
            'request' => $request,
            'lang' => $lang
        ]);

    }

    public function getEvent($slug, $lang=null)
    {
        $item = Events::where('slug',$slug)->first();
        if(empty($item))
            return redirect()->to('/404');
        return view('front.articles.article',[
            'item' => $item,
            'lang' => $lang
        ]);

    }
    public function getNews($slug, $lang = null)
    {
        $item = News::where('slug',$slug)->first();
        if(empty($item))
            return redirect()->to('/404');
        return view('front.articles.article',[
            'item' => $item,
            'lang' => $lang
        ]);

    }
    public function getNewsList($lang = null, Request $request)
    {
        $items = News::where('published',TRUE)->orderBy('published_at','DESC')->paginate(8);
        return view('front.articles.news',[
            'items' => $items,
            'lang' => $lang,
            'request' => $request
        ]);
    }
    public function getPartner($slug, $lang = null)
    {
        $item = Partner::where('slug',$slug)->first();
        if(empty($item))
            return redirect()->to('/404');
        return view('front.articles.partner',[
            'item' => $item,
            'lang' => $lang
        ]);
    }

}
