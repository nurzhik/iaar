<?php

namespace App\Http\Controllers\Admin\Experts;

use App\Http\Controllers\Controller;
use App\Models\Expert;
use App\Models\Univer;
use App\Models\ExpertsExistDirection;
use App\Models\ExpertsPossibleDirection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;

class ExpertsController extends Controller
{
    public function index(Request $request)
    {
        //Функция поиска будет тут
        $items = Expert::query();
        if(isset($request->title))
        {
            $items= $items->where('name','like','%'.$request->title.'%');
        }
        $items = $items->get();
        return view('admin.expert.index',[
            'items' => $items,
            'request' => $request
        ]);
    }
    public function create()
    {
        $item = new Expert();
        return view('admin.expert.item',[
            'item' => $item
        ]);
    }
    public function store(Request $request)
    {
        $category_array = Expert::availableCategoryId();
        $foreign = Expert::availableForeignExpertType();
        $validator = Validator::make($request->all(), [
            "name"    => "required",
            "country_id" => "exists:countries,id",
            "category_id" => "required|in:" . implode(',',$category_array),
            "foreign_expert_type" => "in:" . implode(',',$foreign),
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new Expert();
        $item->name = $request->name;
        $item->country_id = $request->country_id;
        $item->category_id = $request->category_id;
        $item->certificate_date = $request->certificate_date;
        $item->certificate_number = $request->certificate_number;
        $item->place_of_work = $request->place_of_work;
        $item->position = $request->position;
        $item->academic_degrees = $request->academic_degrees;
        $item->languages = $request->langs;//!!
        $item->contacts = $request->contacts;
        $item->category_number = $request->category_number;
        isset($request->is_participated) ?  $item->is_participated = true : $item->is_participated = false;
        isset($request->is_chairman) ?  $item->is_chairman = true : $item->is_chairman = false;
        if(isset($request->photo))
            $item->photo  = str_replace(url('/'),'',$request->photo);
        $item->save();
        return redirect()->back()->with('status','Запись успешно создана!');

    }
    public function edit(Expert $item)
    {
        return view('admin.expert.item',[
            'item' => $item
        ]);
    }
    public function update(Expert $item, Request $request)
    {
        $category_array = Expert::availableCategoryId();
        $foreign = Expert::availableForeignExpertType();
        $validator = Validator::make($request->all(), [
            "name"    => "required",
            "country_id" => "exists:countries,id",
            "category_id" => "required|in:" . implode(',',$category_array),
            "foreign_expert_type" => "in:" . implode(',',$foreign),

        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item->name = $request->name;
        $item->country_id = $request->country_id;
        $item->category_id = $request->category_id;
        $item->certificate_date = $request->certificate_date;
        $item->certificate_number = $request->certificate_number;
        $item->place_of_work = $request->place_of_work;
        $item->position = $request->position;
        $item->academic_degrees = $request->academic_degrees;
        $item->languages = $request->langs;//!!
        $item->contacts = $request->contacts;
        $item->category_number = $request->category_number;
        isset($request->is_participated) ?  $item->is_participated = true : $item->is_participated = false;
        isset($request->is_chairman) ?  $item->is_chairman = true : $item->is_chairman = false;
        if(isset($request->photo))
            $item->photo  = str_replace(url('/'),'',$request->photo);
        $item->save();
        return redirect()->back()->with('status','Запись успешно обновлена!');


    }
    public function delete(Expert $item)
    {   
        $item->delete();
        return redirect()->back()->with('status','Данные об эксперте успешно удалены!');
    }


}
