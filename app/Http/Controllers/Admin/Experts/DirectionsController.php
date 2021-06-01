<?php

namespace App\Http\Controllers\Admin\Experts;

use App\Http\Controllers\Controller;
use App\Models\ExpertSpec;
use App\Models\ExpertDirection;
use App\Models\Univer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;

class DirectionsController extends Controller
{
    public function index()
    {
        $items = ExpertDirection::all();
        return view('admin.expert.directions.index',[
            'items' => $items
        ]);
    }
    private function validateBaseType($val)
    {
        $ar = Univer::availableTypeIdArray();
        if(!in_array($val,$ar))
            return false;
        else
            return true;

    }
    public function getDirections(Request $request)
    {
        if(!isset($request->base_type) or !$this->validateBaseType($request->base_type))
            return ['error' => 'error'];
        $items = ExpertDirection::where('base_type',$request->base_type)->get();
        return ['items' => $items->toArray()];

    }

    public function getSpecs(Request $request)
    {
        if(!isset($request->direction_id))
            return ['error' => 'error'];
        $items = ExpertSpec::where('direction_id',$request->direction_id)->get();
        return ['items' => $items->toArray()];

    }

    public function createDirection(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
            "base_type" => "required|integer|max:7|min:0",
        ]);
        if($validator->fails())
        {
            return ['error' => 'error'];
        }
        $item = new ExpertDirection();
        $item->title= $request->title;
        $item->base_type = $request->base_type;
        $item->save();
        return ['success' => 'success'];

    }

    public function createSpec(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
            "direction_id" => "required|exists:expert_directions,id",
        ]);
        if($validator->fails())
        {
            return ['error' => 'error'];
        }
        $item = new ExpertSpec();
        $item->title= $request->title;
        $item->direction_id = $request->direction_id;
        $item->save();
        return ['success' => 'success'];

    }
    public function updateDirection(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id" => "required|exists:expert_directions,id",
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return ['error' => 'error'];
        }
        $item =  ExpertDirection::find($request->id);
        $item->title= $request->title;
        //$item->base_type = $request->base_type;
        $item->save();
        return ['success' => 'success'];
    }
    public function updateSpec(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
            "id" => "required|exists:expert_specializations,id",
        ]);
        if($validator->fails())
        {
            return ['error' => 'error'];
        }
        $item = ExpertSpec::find($request->id);
        $item->title= $request->title;
        $item->save();
        return ['success' => 'success'];

    }
    public function deleteSpec(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id" => "required|exists:expert_directions,id",
        ]);
        if($validator->fails())
        {
            return ['error' => 'error'];
        }
        $item =  ExpertDirection::find($request->id);
        $item->delete();
        return ['success' => 'success'];

    }
    public function deleteDirection(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id" => "required|exists:expert_specializations,id",
        ]);
        if($validator->fails())
        {
            return ['error' => 'error'];
        }
        $item =  ExpertSpec::find($request->id);
        $item->delete();
        return ['success' => 'success'];

    }
}
