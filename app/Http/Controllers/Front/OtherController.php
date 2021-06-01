<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Events;
use App\Models\Article;
use App\Models\StaticPage;
use App\Models\Contacts;
use Carbon\Carbon;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App;



class OtherController extends Controller
{


    public function getContactsPage($lang = null)
    {
        $item = Contacts::where('id','>',0)->first();
        return view('front.other.contacts',[
            'item' => $item,
            'lang' => $lang
        ]);
    }

    public function getStudentsHiddenPage( $lang = null)
    {
        $item = StaticPage::where('type_id',17)->where('appearance_type',0)->first();
        $news = Article::where('is_event',false)->orderBy('published_at','DESC')->get()->take(5);
        return view('front.iaar.other.hidden',[
            'item' => $item,
            'lang' => $lang,
            'news' => $news
        ]);
    }

    public function getStudentsPage($slug, $lang = null)
    {
        $item = StaticPage::where('type_id',17)->where('slug',$slug)->where('appearance_type','<>',0)->first();
        if(empty($item))
        {
            return redirect()->to('/404');
        }
        $news = Article::where('is_event',false)->orderBy('published_at','DESC')->get()->take(5);
        return view('front.iaar.other.static',[
            'item' => $item,
            'lang' => $lang,
            'news' => $news
        ]);
    }

    public function getForumHiddenPage( $lang = null)
    {
        $item = StaticPage::where('type_id',31)->where('appearance_type',0)->first();
        $news = Article::where('is_event',false)->orderBy('published_at','DESC')->get()->take(5);
        return view('front.iaar.other.hidden',[
            'item' => $item,
            'lang' => $lang,
            'news' => $news
        ]);
    }

    public function getForumPage($slug, $lang = null)
    {
        $item = StaticPage::where('type_id',31)->where('slug',$slug)->where('appearance_type','<>',0)->first();
        if(empty($item))
        {
            return redirect()->to('/404');
        }
        $news = Article::where('is_event',false)->orderBy('published_at','DESC')->get()->take(5);
        return view('front.iaar.other.static',[
            'item' => $item,
            'lang' => $lang,
            'news' => $news
        ]);
    }

    public function getPostmonitoringPage($lang = null)
    {
        $news = Article::where('is_event',false)->orderBy('published_at','DESC')->get()->take(5);
        $item = StaticPage::where('type_id',18)->first();
        return view('front.other.postmonitoring',[
            'item' => $item,
            'lang' => $lang,
            'news' => $news
        ]);
    }

}
