<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Nodes\UniverNode;
use App\Models\Nodes\ProgramAccrNode;
use App\Models\StaticPage;
use App\Models\Univer;
use App\Models\ExtReport;
use App\Models\ProgramAccr;
use Carbon\Carbon;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;



class ReportsController extends Controller
{
    public function getVekPage(Request $request, $lang = null)
    {

        $results = ExtReport::where('id','<',0)->get();
        $countries = Country::where('is_registry',TRUE)->get();
        if(isset($request->year_start))
        {
            $results = $this->searchVekReports($request);
        }

        
        return view('front.reports.vek_reports',[
            'lang' => $lang,
            'request' => $request,
            'countries' => $countries,
            'results' => $results
        ]);
    }

    private function searchVekReports(Request $request)
    {   
        if($request->country_id == 'all') {
             $universities = Univer::where('id','>',0)->select('id')->get()->pluck('id')->toArray();
        }else {
            $universities = Univer::where('country_id',$request->country_id)->select('id')->get()->pluck('id')->toArray();
        }
        if($request->univer_type_id ==9) {
            $kek = "'>',0";
        }
        else if(!isset($request->univer_type_id)) {
            $kek = 0;
        }
        else {
            $kek = $request->univer_type_id;
        }
        $items = ExtReport::where('univer_type_id',$kek)
            ->where('date_start','>=',$request->year_start.'-01-01 00:00:00')
            ->where('date_start','<=',$request->year_start.'-12-31 23:59:59')
            ->whereIn('university_id',$universities)->orderBy('date_start','DESC')->get();
       

        return $items;
    }
    public function getSmiEvent($slug, $lang = null)
    {
        $item = StaticPage::where('slug',$slug)->where('type_id',30)->first();
        if(empty($item))
            return redirect()->to('/404');
        return view('front.reports.smi_event',[
            'item' => $item,
            'lang' => $lang
        ]);
    }

    public function getPage($slug, $lang = null)
    {
        $item = StaticPage::where('slug',$slug)->first();
        if(empty($item))
            return redirect()->to('/404');
        $news = Article::where('is_event',false)->orderBy('published_at','DESC')->get()->take(5);
        switch($item->type_id)
        {
            case(11):

                return view('front.reports.naar_report',[
                    'item' => $item,
                    'lang' => $lang,
                    'page_type' => 'year'
                ]);
                break;
            case(12):
                return view('front.reports.naar_report',[
                    'item' => $item,
                    'lang' => $lang,
                    'page_type' => 'anal'
                ]);
                break;
            case(14):
                $documents = $item->attachments()->orderBy('year','DESC')->get();
                return view('front.reports.publications',[
                    'item' => $item,
                    'documents' => $documents,
                    'lang' => $lang,
                    'news' => $news
                ]);
                break;
            case(15):
                $documents = $item->attachments()->orderBy('show_date','DESC')->paginate(6);
                return view('front.reports.video_archive',[
                    'item' => $item,
                    'documents' => $documents,
                    'lang' => $lang,
                ]);
                break;
            case(16):
                $events = StaticPage::where('type_id',30)->orderBy('created_at','DESC')->get();
                return view('front.reports.smi_page',[
                    'item' => $item,
                    'lang' => $lang,
                    'news' => $news,
                    'events' => $events,
                ]);
                break;
            case(13):
                $documents = $item->attachments()->orderBy('year','DESC')->orderBy('sort_order')->get();
                return view('front.reports.magazine.archive',[
                    'item' => $item,
                    'documents' => $documents,
                    'lang' => $lang,
                    'news' => $news,
                ]);
                break;
            case(25):
                $members = $item->boardMembers()->orderBy('sort_order')->get();
                return view('front.reports.magazine.council',[
                    'item' => $item,
                    'board_members' => $members,
                    'lang' => $lang,
                    'news' => $news,
                ]);
                break;
            case(26):
                return view('front.reports.magazine.order',[
                    'item' => $item,
                    'lang' => $lang,
                    'news' => $news,
                ]);
                break;
            case(27):
                return view('front.reports.magazine.require',[
                    'item' => $item,
                    'lang' => $lang,
                    'news' => $news,
                ]);
                break;
            case(28):
                return view('front.reports.magazine.subscription',[
                    'item' => $item,
                    'lang' => $lang,
                    'news' => $news,
                ]);
                break;
            case(29):
                $documents = $item->attachments()->orderBy('year','DESC')->paginate(6);
                return view('front.reports.magazine.about',[
                    'item' => $item,
                    'lang' => $lang,
                    'documents' => $documents,
                    'news' => $news,
                ]);
                break;
            default:
                return redirect()->to('/404');

        }
    }
}
