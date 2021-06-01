<?php

namespace App\Http\Controllers\Admin\Registry;

use App\Http\Controllers\Controller;
use App\Models\Univer;
use App\Models\MainAccr;
use App\Models\ProgramAccr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;

class UniverController extends Controller
{
    public function index(Request $request)
    {
        //Функция поиска будет тут
        $countUniver = MainAccr::where('allow_deqar_sending', true)
            ->where('deqar_sent_status', '<=', 0)
            ->count();
        $countProgram = ProgramAccr::where('allow_deqar_sending', true)
            ->where('deqar_sent_status', '<=',0)
            ->count()
        ;
        $items = Univer::where('id','>',0)->get();
        return view('admin.univer.index',[
            'items' => $items,
            'countUniver' =>$countUniver,
            'countProgram'  =>$countProgram
        ]);
    }
    public function create()
    {
        $item = new Univer();
        return view('admin.univer.item',[
            'item' => $item
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
            "country_id" => "required|exists:countries,id",

        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new Univer();
        $item->title = $request->title;
        $item->country_id = $request->country_id;
        if(isset($request->deqar_univer_id))
        {
            $item->deqar_univer_id = $request->deqar_univer_id;
        }
        if($request->unique_index) {
            $item->unique_index = $request->unique_index;
            $item->save();
        }else {
            $item->save();
            $lastInsertedId = $item->id;
            $item->unique_index = $lastInsertedId;
            $item->save();
        }
        // $item->save();
        return redirect()->to('/admin/univer')->with('status','новый университет успешно добавлен!');

    }
    public function edit(Univer $item)
    {
        return view('admin.univer.item',[
            'item' => $item
        ]);
    }
    public function update(Univer $item, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
            "country_id" => "required|exists:countries,id",

        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        if(isset($request->deqar_univer_id))
        {
            $item->deqar_univer_id = $request->deqar_univer_id;
        }
        $item->title = $request->title;
        $item->country_id = $request->country_id;
        $item->unique_index = $request->unique_index;
        $item->save();
        return redirect()->back()->with('status','Данные успешно изменены!');


    }
    public function delete(Univer $item)
    {
        $item->delete();
        return redirect()->back()->with('status','Данные об эксперте успешно удалены!');
    }


}
