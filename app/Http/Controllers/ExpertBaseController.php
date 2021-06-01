<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Expert;
use App\Models\Univer;
use App\Models\Country;
use App\Models\ExpertsExistDirection;
use App\Models\ExpertsPossibleDirection;

use App\Models\ExpertDirection;
use App\Models\ExpertSpec;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;

class ExpertBaseController extends Controller
{
    public function getSearch(Request $request, $lang = null)
    {
        $countries = Country::all();
        $directions = ExpertDirection::where('base_type','0')->whereHas('existingDirections')
            ->orderBy('title')->select('id','title')->get();
        $results = [];
        if(!isset($request->univer_type_id))
            $univer_type_id = 0;
        else
            $univer_type_id = $request->univer_type_id;

         $results = Expert::query();
        if($request->country_id != 0)
        {
           $results = $results->where('country_id',$request->country_id);
        }
        if($request->expert_category_id!==null && $request->expert_category_id!=-1)
        {
            $results = $results->where('category_id',$request->expert_category_id);
        }
        if($request->category_number!==null && $request->category_number!=-1)
        {
            $results = $results->where('category_number',$request->category_number);
        }
        if($request->foreign_expert_type)
        {
            $results = $results->where('foreign_expert_type',$request->foreign_expert_type);
        }
            if($request->is_chairman == 1)
                $results =  $results->where('is_chairman',TRUE);
            if($request->is_chairman == 2)
                $results =  $results->where('is_chairman',FALSE);
            if($request->is_participated == 1)
                $results =  $results->where('is_participated',TRUE);
            if($request->is_participated == 2)
                $results =  $results->where('is_participated',FALSE);
            if($request->direction_type_id == 1)
            {
                $results  = $results->whereHas('existDirections',function($query) use($request, $univer_type_id){
                    $query->where('direction_id',$request->expert_direction_id ? $request->expert_direction_id : '>',0)
                        ->where('accr_type', $request->accr_type ? $request->accr_type - 1 : '>', -1)
                        ->where('spec_id', $request->expert_spec_id ? $request->expert_spec_id : '>',0);
                    if($request->univer_type_id != 1001 )
                    {
                        $query =  $query->where('organization_type_id',$request->univer_type_id );
                    }
                });
            }

            if($request->direction_type_id == 2)
            {
                $results  = $results->whereHas('possibleDirections',function($query) use($request ){
                    $query->where('direction_id',$request->expert_direction_id ? $request->expert_direction_id : '>',0)
                        ->where('accr_type', $request->accr_type ? $request->accr_type - 1 : '>', -1)
                        ->where('spec_id', $request->expert_spec_id ? $request->expert_spec_id : '>',0);
                        //->where('organization_type_id',$request->univer_type_id ); - у Возможных направлений не существует типа организации образования
                });
            }
            $count = $results->count();

            $results = $results->paginate(10);

        return view('experts.index',[
            'request' => $request,
            'results' => $results,
            'lang' =>$lang,
            'count' => $count,
            'countries' => $countries,
            'directions' => $directions
        ]);
    }
    public function getExpert(Expert $item, $lang = null)
    {
        return view('experts.item',[
            'item' => $item,
            'lang' =>$lang,
        ]);
    }
    public function getAjaxDirs(Request $request)
    {

        $type_id = $request['univer_type_id'];
        $direction_type_id = $request['direction_type_id'];
        if($direction_type_id == 1)
        {
            $directions = ExpertDirection::where('base_type',$type_id)->whereHas('existingDirections')
            ->orderBy('title')->select('id','title')->get();
        }
        else
        {
            $directions = ExpertDirection::where('base_type',$type_id)->whereHas('possibleDirections')
                ->orderBy('title')->select('id','title')->get();
        }
        return ['directions' => $directions] ;
    }
    public function getAjaxSpecs(Request $request)
    {
        $direction_id = $request->expert_direction_id;
        $specs = [];
        $direction = ExpertDirection::where('id',$direction_id)->first();
        if(!empty($direction))
        {
            $specs = $direction->specs()->orderBy('title')->get();
        }
        return ['specs' => $specs];

    }

}
