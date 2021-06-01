<?php

namespace App\Http\Controllers\Admin\Registry\Deqar;

use App\Http\Controllers\Controller;
use App\Models\Deqar\DeqarAccrType;
use App\Models\Univer;
use App\Models\MainAccr;
use App\Models\ExtReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Service\DeqarApiService;
use GuzzleHttp\Client;
use JavaScript;

class DeqarAccrTypesController extends Controller
{
    public function index()
    {
        $items = DeqarAccrType::all();
        return view('admin.deqar_accr_types.index',[
            'items' => $items,
        ]);

    }
    public function create()
    {
        $item = new DeqarAccrType();;
        return view('admin.deqar_accr_types.item',[
            'item' => $item,
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "value"    => "required",

        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new DeqarAccrType();
        $item->value = $request->value;
        $item->save();
        return redirect('/admin/deqar_accr_types')->with('status','Новая запись успешно создана!');

    }
    public function edit(DeqarAccrType $item)
    {
        return view('admin.deqar_accr_types.item',[
            'item' => $item,
        ]);
    }
    public function update(DeqarAccrType $item, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "value"    => "required",

        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item->value = $request->value;
        $item->save();
        return redirect('/admin/deqar_accr_types')->with('status','Данные о записи успешно изменены!');

    }
    public function delete(DeqarAccrType $item)
    {
        //return false;
        $item->delete();
        return redirect()->back()->with('status','Успешно удалена!');
    }


}
