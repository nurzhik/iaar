<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Univer;
use App\Models\Nodes\UniverNode;
use App\Models\Nodes\ProgramAccrNode;
use App\Models\MainAccr;
use App\Models\ProgramAccr;
use Carbon\Carbon;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;



class RegistryController extends Controller
{
    public function getIndex(Request $request, $lang = null)
    {

        $programs = ProgramAccr::where('id','<',0)->paginate(5);
        $main_accrs = MainAccr::where('id','<',0)->paginate(8);
        $count = 0 ;
        if($request->accr_type == 1) //Институциональная аккредитация
        {
            $count = $this->searchMainAccr($lang, $request)->orderBy('date_start','DESC')->count();
            $main_accrs = $this->searchMainAccr($lang, $request)->orderBy('date_start','DESC')->paginate(8);

        }

        if($request->accr_type == 2)//Программная аккредитация
        {
            $count = $this->searchProgramAccr($lang, $request)->orderBy('date_start','DESC')->count();
            $programs = $this->searchProgramAccr($lang, $request)->orderBy('date_start','DESC')->paginate(5);
        }

        $countries = Country::where('is_registry',TRUE)->get();
        return view('front.registry.index',[
            'lang' => $lang,
            'countries' => $countries,
            'main_accrs' => $main_accrs,
            'programs' => $programs,
            'request' => $request,
            'count' => $count
        ]);

    }

    private function searchMainAccr($lang,Request $request)
    {
        $universities = Univer::where('id','>',0);
       
        if(strlen($request->title)>0)
        {

            $key = mb_strtolower($request->title);
            switch ($lang)
            {
                case 'kz':
                    $nodes = UniverNode::whereRaw('lower(title) like (?)',["%{$key}%"])->where('lang','kz')->select('parent_id')->get()->toArray();
                    $universities = $universities->whereIn('id',$nodes);
                    break;
                case 'en':
                    $nodes = UniverNode::whereRaw('lower(title) like (?)',["%{$key}%"])->where('lang','en')->select('parent_id')->get()->toArray();
                    $universities = $universities->whereIn('id',$nodes);
                    break;
                default:
                    $universities = $universities->whereRaw('lower(title) like (?)',["%{$key}%"]);
                    break;
            }
        }
        if(isset($request->country_id))
            if($request->country_id == 0){

              $country_id  = Country::where('id','>',0)->select('id')->get()->pluck('id')->toArray();
              $universities = $universities->whereIn('country_id',$country_id)->select('id')->get()->pluck('id')->toArray();
            }else {

                $country_id = $request->country_id;
                $universities = $universities->where('country_id',$country_id)->select('id')->get()->pluck('id')->toArray();
            }
        else
        {

            $country_id = Country::where('is_registry',TRUE)->first()->id;
            $request->country_id = $country_id;
            $universities = $universities->where('country_id',$country_id)->select('id')->get()->pluck('id')->toArray();
        }

      

        $main_accrs = MainAccr::whereIn('university_id',$universities);
        if($request->is_ex_ante == 1)
        {
            $main_accrs = $main_accrs->where('ex_ante',true);
        }
        else
        {

        }
        if(isset($request->year_start))
        {
            $date_start = new Carbon();
            $date_start->year = $request->year_start;
            $date_start->day = 1;
            $date_start->month = 1;
            $date_start->hour = 00;
            $date_start->minute = 00;
            $date_start->second = 00;
            $date_start = $date_start->toDateTimeString();
            $date_end = new Carbon();
            $date_end->year = $request->year_start;
            $date_end->month = 12;
            $date_end->day = 31;
            $date_end->hour = 23;
            $date_end->minute = 59;
            $date_end->second = 59;
            $date_end = $date_end->toDateTimeString();
            $main_accrs = $main_accrs->where('date_start','>=',$date_start)->where('date_start','<=',$date_end);
        }
        else
        {   

            $sec_accrs = $main_accrs->select(DB::raw('university_id, max(`date_start`) as `date_start`'))->groupBy('university_id')->get();

            $ar = [];

            foreach($sec_accrs as $ac)
            {

                $ar[] = MainAccr::where('university_id',$ac->university_id)->where('date_start',$ac->date_start)->first()->id;
            }

            $main_accrs = MainAccr::whereIn('id',$ar);

            //dump($main_accrs);
        }

        if($request->is_reaccr == 1)
        {
            $main_accrs = $main_accrs->where('reakkr',true);
        }
        else
        {

        }
        
        if($request->univer_type_id ==20){
            $main_accrs = $main_accrs->where('univer_type_id','>=','0');//
        }else {
            $main_accrs = $main_accrs->where('univer_type_id',$request->univer_type_id);
        }
        //->get()->pluck('university_id')->toArray();
        if(isset($request->years) and $request->years != 0)
            $main_accrs = $main_accrs->where('years',$request->years);
        //нужно для каждого университета найти самую недавнюю основную аккредитацию
        //\App\Models\Product::select(DB::raw('model_id, max(`id`) as `id`'))->groupBy('model_id')->select('id','model_id')->get();
        return $main_accrs;

    }

    private function searchProgramAccr($lang, Request $request)
    {


        $universities = Univer::where('id','>',0);

         $true = true;
        if(strlen($request->title)>0)
        {

            $key = mb_strtolower($request->title);

            switch ($lang)
            {
                case 'kz':
                    $nodes = UniverNode::whereRaw('lower(title) like (?)',["%{$key}%"])->where('lang','kz')->select('parent_id')->get()->toArray();
                    if(count($nodes) > 0) {
                        $universities = $universities->whereIn('id',$nodes);
                        $true = false;
                    }else {
                        $universities = Univer::where('id','>',0);
                        $true = true;
                    }
                    break;
                case 'en':
                    $nodes = UniverNode::whereRaw('lower(title) like (?)',["%{$key}%"])->where('lang','en')->select('parent_id')->get()->toArray();
                    if(count($nodes) > 0) {
                        $universities = $universities->whereIn('id',$nodes);
                        $true = false;
                    }else {
                        $universities = Univer::where('id','>',0);
                        $true = true;
                    }
                   


                    
                    break;
                default:
                    $universitiesName=$universities->whereRaw('lower(title) like (?)',["%{$key}%"])->get();
                    if(count($universitiesName) > 0) {
                        $universities = $universities->whereRaw('lower(title) like (?)',["%{$key}%"]);
                        $true = false;
                    }else {
                        $universities = Univer::where('id','>',0);
                        $true = true;
                    }
                    

                    break;
            }
        }  


        if($request->country_id == 0){

          $country_id  = Country::where('id','>',0)->select('id')->get()->pluck('id')->toArray();
          $universities = $universities->whereIn('country_id',$country_id)->select('id')->get()->pluck('id')->toArray();
        }else {

            $country_id = $request->country_id;
            $universities = $universities->where('country_id',$country_id)->select('id')->get()->pluck('id')->toArray();
        }

        
        $programs = ProgramAccr::whereIn('university_id',$universities);
        if($true)
        {   

            $key = mb_strtolower($request->title);
            switch ($lang)
            {
                case 'kz':
                    $nodes = ProgramAccrNode::whereRaw('lower(program_title) like (?)',["%{$key}%"])->where('lang','kz')->select('parent_id')->get()->toArray();
                    $programs = $programs->whereIn('id',$nodes)->orWhereRaw('lower(program_index) like (?)',["%{$key}%"]);
                    break;
                case 'en':
                    $nodes = ProgramAccrNode::whereRaw('lower(program_title) like (?)',["%{$key}%"])->where('lang','en')->select('parent_id')->get()->toArray();
                    $programs = $programs->whereIn('id',$nodes)->orWhereRaw('lower(program_index) like (?)',["%{$key}%"]);
                    break;
                default:
                    $programs = $programs->whereRaw('lower(program_title) like (?)',["%{$key}%"])->orWhereRaw('lower(program_index) like (?)',["%{$key}%"]);

                    break;
            }
        }
        if(isset($request->year_start))
        {
            $date_start = new Carbon();
            $date_start->year = $request->year_start;
            $date_start->day = 1;
            $date_start->month = 1;
            $date_start->hour = 00;
            $date_start->minute = 00;
            $date_start->second = 00;
            $date_start = $date_start->toDateTimeString();
            $date_end = new Carbon();
            $date_end->year = $request->year_start;
            $date_end->month = 12;
            $date_end->day = 31;
            $date_end->hour = 23;
            $date_end->minute = 59;
            $date_end->second = 59;
            $date_end = $date_end->toDateTimeString();
            $programs = $programs->where('date_start','>=',$date_start)->where('date_start','<=',$date_end);
        }
        else
        {
            $sec_progs = $programs->orderBy('university_id','DESC')->get();
            $univer_id = 0;
            $prog_array = [];
            $univer_array = [];
            foreach($sec_progs as $key=>$prog)
            {
                if($prog->university_id != $univer_id)
                {
                    if($univer_id!=0)
                        $prog_array[$univer_id] = $univer_array;
                    $univer_id = $prog->university_id;
                    $univer_array = [];
                    $univer_array[$prog->hidden_relation_id] = [$prog->date_start,$prog->id];
                }
                else
                {
                    if(array_key_exists($prog->hidden_relation_id,$univer_array))
                    {
                        if($prog->date_start > $univer_array[$prog->hidden_relation_id][0])
                            $univer_array[$prog->hidden_relation_id] = [$prog->date_start,$prog->id];
                    }
                    else
                        $univer_array[$prog->hidden_relation_id] = [$prog->date_start,$prog->id];
                }
            }
            $prog_array[$univer_id] = $univer_array;
            //dump($prog_array);
            $prog_array_ids = [];
            foreach($prog_array as $univer)
            {
                foreach($univer as $program)
                {
                    $prog_array_ids[] = $program[1];
                }
            }
            $programs = ProgramAccr::whereIn('id',$prog_array_ids);
        }

        if($request->is_reaccr == 1)
        {
            $programs = $programs->where('reaccr',true);
        }
        else
        {

        }

        if($request->is_ex_ante == 1)
            $programs = $programs->where('ex_ante',TRUE);

        if($request->univer_type_id ==20){
            $programs = $programs->where('univer_type_id','>=','0');//
        }else {
            $programs = $programs->where('univer_type_id',$request->univer_type_id);
        }
      
        if(isset($request->years) and $request->years != 0)
            $programs = $programs->where('years',$request->years);

        return $programs;
    }


    public function getUniverPage(Univer $item,$lang = null)
    {
        $main_accr = $item->mainAccrs()->orderBy('date_start','DESC')->first();
        $main_accrs = $item->mainAccrs()->orderBy('date_start','DESC')->get()->slice(1);
        $programs = $item->programAccrs()->orderBy('date_start','DESC')->get();
        //$programs = ProgramAccr::whereIn('id',$programs)->orderBy('date_start','DESC')->get();
       
        return view('front.registry.univer',[
            'lang' => $lang,
            'item' => $item,
            'accr' => $main_accr,
            'main_accrs' => $main_accrs,
            'programs' => $programs
        ]);

    }

    public function getProgramPage(ProgramAccr $item, $lang = null)
    {
        $univer = $item->univer;
        $programs = $univer->programAccrs()
            ->where('id','<>',$item->id)
            ->select('id')->pluck('id')->toArray();
        $programs = ProgramAccr::whereIn('id',$programs)->orderBy('date_start','DESC')->get();
        $past_programs = $item->samePrograms()->where('date_start','<',$item->date_start)->get();
        return view('front.registry.program',[
            'lang' => $lang,
            'program' => $item,
            'univer' => $univer,
            'past_programs' => $past_programs,
            'programs' => $programs
        ]);

    }




}
