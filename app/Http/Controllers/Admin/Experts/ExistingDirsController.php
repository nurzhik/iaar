<?php

namespace App\Http\Controllers\Admin\Experts;

use App\Http\Controllers\Controller;
use App\Models\Expert;
use App\Models\Univer;
use App\Models\ExpertsExistDirection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ExistingDirsController extends Controller
{
    public function create(Expert $parent)
    {
        $item = new ExpertsExistDirection();
        return view('admin.expert.existing_direction',[
            'item' => $item,
            'parent' => $parent
        ]);

    }
    public function store(Expert $parent, Request $request)
    {
        $univer_types = Univer::availableTypeIdArray();
        $validator = Validator::make($request->all(), [
            'accr_type' => "integer|min:0|max:1",
            'organization_type_id' => "required|in:".implode(',',$univer_types),
            'direction_id' => "required|exists:expert_directions,id",
            'spec_id' => "required|exists:expert_specializations,id",

        ]);
        
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }

        $item = new ExpertsExistDirection();
        $item->accr_type = $request->accr_type;
        $item->organization_title = $request->organization_title;
        $item->organization_type_id = $request->organization_type_id;
        $item->date_start =$request->date_start;
        $item->date_end = $request->date_end;
        $item->direction_id = $request->direction_id;
        $item->spec_id = $request->spec_id;
        $item->expert_id = $parent->id;
        $item->save();
        return redirect()->to('admin/experts/'.$parent->id)->with('status','Новое фактическое направление добавлено!');

    }
    public function edit(Expert $parent,ExpertsExistDirection $item )
    {
        return view('admin.expert.existing_direction',[
            'item' => $item,
            'parent' => $parent
        ]);
    }
    public function update(Expert $parent,ExpertsExistDirection $item, Request $request)
    {
        $univer_types = Univer::availableTypeIdArray();
        $validator = Validator::make($request->all(), [
            'accr_type' => "integer|min:0|max:1",
            'organization_type_id' => "required|in:" . implode(',',$univer_types),
            'direction_id' => "required|exists:expert_directions,id",
            'spec_id' => "required|exists:expert_specializations,id",

        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        if($item->expert_id !== $parent->id)
            return redirect()->back()->with(['error' => 'Это не родитель!']);
        $item->accr_type = $request->accr_type;
        $item->organization_title = $request->organization_title;
        $item->organization_type_id = $request->organization_type_id;
        $item->date_start =$request->date_start;
        $item->date_end = $request->date_end;
        $item->direction_id = $request->direction_id;
        $item->spec_id = $request->spec_id;
        $item->save();
        return redirect()->to('admin/experts/'.$parent->id)->with('status','Данные о фактическом направлении изменены!');

    }
    public function delete(ExpertsExistDirection $item)
    {

        $item->delete();
        return redirect()->back()->with('status','Запись успешно удалена!');
    }


}
