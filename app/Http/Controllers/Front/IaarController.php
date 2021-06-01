<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use App\Models\Article;
use App\Models\Partner;
use App\Models\CommisionTab;
use App\Models\CommisionFile;
use App\Models\MainSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class IaarController extends Controller
{

    private function checkAvailablePageType(int $type)
    {
        if(in_array($type,[1,2,3,4,5,6,7,8,19,20,21,22,23,24,33,34]))
            return true;
        return false;
    }

    public function getPage(Request $request, $slug, $lang = null)
    {
        $item = StaticPage::where('slug',$slug)->first();
        if(empty($item) or !$this->checkAvailablePageType($item->type_id))
        {
            return redirect()->to('/404');
        }
        $news = Article::where('is_event',false)->orderBy('published_at','DESC')->get()->take(5);
        if($item->type_id ==1)//Организационная структура
        {
            $news = Article::where('is_event',false)->orderBy('published_at','DESC')->get()->take(5);
            return view('front.iaar.organization.hidden',[
                'item' => $item,
                'news' => $news,
                'lang' => $lang
            ]);
        }
        if($item->type_id == 2)//Страница списка советов
        {


            $board_members = $item->boardMembers()->orderBy('sort_order')->get();
            $tabs = CommisionTab::where('page_id',$item->id)->orderBy('sort_order','DESC')->get();
            $news = Article::where('is_event',false)->orderBy('published_at','DESC')->get()->take(5);
            return view('front.iaar.organization.board',[
                'item' => $item,
                'board_members' => $board_members,
                'news' => $news,
                'lang' => $lang,
                'tabs' => $tabs
            ]);
        }
        if($item->type_id == 3)//Страница наша команда
        {
            $director = $item->teamMembers()->orderBy('sort_order')->first();
            $team_members = $item->teamMembers()->orderBy('sort_order')->get()->slice(1);
            $news = Article::where('is_event',false)->orderBy('published_at','DESC')->get()->take(5);
            return view('front.iaar.organization.team',[
                'item' => $item,
                'director' => $director,
                'team_members' => $team_members,
                'news' => $news,
                'lang' => $lang
            ]);
        }
        if($item->type_id == 4)//Эксперты
        {
            $news = Article::where('is_event',false)->orderBy('published_at','DESC')->get()->take(5);
            return view('front.iaar.organization.experts',[
                'item' => $item,
                'news' => $news,
                'lang' => $lang
            ]);
        }
        if($item->type_id == 5)//Стратегия наар
        {
            if($item->appearance_type == 0)
                return view('front.iaar.other.hidden',[
                    'item' => $item,
                    'news' => $news,
                    'lang' => $lang

                ]);
            else
                return view('front.iaar.other.static',[
                    'item' => $item,
                    'news' => $news,
                    'lang' => $lang
                ]);

        }
        if($item->type_id == 6)//Нормативные документы
        {
            if($item->appearance_type == 0)
                return view('front.iaar.other.hidden',[
                    'item' => $item,
                    'news' => $news,
                    'lang' => $lang
                ]);
            else
                return view('front.iaar.other.static',[
                    'item' => $item,
                    'news' => $news,
                    'lang' => $lang
                ]);

        }
        if($item->type_id == 7)//Внутренняя система качества(только 1 страница)
        {
            if($item->appearance_type == 0)
                return view('front.iaar.other.hidden',[
                    'item' => $item,
                    'news' => $news,
                    'lang' => $lang
                ]);
            else
                return redirect()->to('/404');

        }
        if($item->type_id == 8 or $item->type_id == 33  )//Внешняя оценка качества
        {
            if($item->appearance_type == 0)
                return view('front.iaar.other.hidden',[
                    'item' => $item,
                    'news' => $news,
                    'lang' => $lang
                ]);
            else
                return view('front.iaar.other.static',[
                    'item' => $item,
                    'news' => $news,
                    'lang' => $lang
                ]);

        }
        if($item->type_id == 19)
        {
            return view('front.iaar.international.intern_cooperation_hidden',[
                'item' => $item,
                'news' =>$news,
                'lang' => $lang
            ]);
        }
        if($item->type_id == 20)
        {
            return view('front.iaar.international.intern_networks',[
                'item' => $item,
                'news' => $news,
                'lang' => $lang
            ]);
        }
        if($item->type_id == 21)
        {
            return view('front.iaar.international.intern_partners',[
                'item' => $item,
                'news' => $news,
                'lang' => $lang
            ]);
        }
        if($item->type_id == 22)
        {
            return view('front.iaar.international.intern_projects',[
                'item' => $item,
                'news' => $news,
                'lang' => $lang
            ]);
        }
        if($item->type_id == 23)
        {
            $events = StaticPage::where('type_id',24)->orderBy('created_at','DESC')->get();
            return view('front.iaar.international.intern_events',[
                'item' => $item,
                'news' => $news,
                'lang' => $lang,
                'events' => $events
            ]);
        }
        if($item->type_id == 34)
        {
            return view('front.iaar.other.national_partners',[
                'item' => $item,
                'news' => $news,
                'lang' => $lang
            ]);
        }

        return redirect()->to('/404');

    }

    public function getIntEvent($slug, $lang = null)
    {
        $item = StaticPage::where('slug',$slug)->where('type_id',24)->first();
        if(empty($item))
            return redirect()->to('/404');
        return view('front.iaar.international.event',[
            'item' => $item,
            'lang' => $lang
        ]);
    }


    public function getTeamMember(Request $request)
    {

    }
    public function getBoardMember(Request $request)
    {

    }



}
