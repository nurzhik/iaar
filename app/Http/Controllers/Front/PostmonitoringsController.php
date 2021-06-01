<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Postmonitoring;
use App\Models\News;
use App\Models\Article;
use App\Models\Tab;
use App\Models\File;
use App\Models\PostmonitoringFile;
use Carbon\Carbon;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App;



class PostmonitoringsController extends Controller
{
   
    public function getPage($slug, $lang=null)
    {
        $item = Postmonitoring::where('slug',$slug)->first();
        $tabs = Tab::where('page_id',$item->id)->orderBy('sort_order','DESC')->get();
        $news = Article::where('is_event',false)->orderBy('published_at','DESC')->get()->take(5);
        $documents = PostmonitoringFile::orderBy('id','DESC')->get();
        if(empty($item))
            return redirect()->to('/404');
        return view('front.postmonitoring.index',[
            'item' => $item,
            'lang' => $lang,
            'tabs' =>$tabs,
            'news' => $news,
            'documents'=>$documents
        ]);

    }
    
    

}
