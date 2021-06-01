<?php

namespace App\Http\Controllers\Admin\Countries;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class CountriesController extends Controller
{

    public function index()
    {
        $items = Country::all();
        return view('admin.countries.index',[
            'items' => $items,
        ]);

    }
    public function create()
    {
        $item = new Country();;
        return view('admin.countries.item',[
            'item' => $item,
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",

        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new Country();
        $item->title = $request->title;
        $item->sort_order = $request->sort_order;
        if(isset($request->icon))
            $item->icon  = str_replace(url('/'),'',$request->icon);
        isset($request->is_searchable) ? $item->is_searchable = true : $item->is_searchable = false;
        isset($request->is_registry) ? $item->is_registry = true : $item->is_registry = false;
        isset($request->is_accr) ? $item->is_accr = true : $item->is_accr = false;
        isset($request->is_rating) ? $item->is_rating = true : $item->is_rating = false;
        isset($request->is_expert) ? $item->is_expert = true : $item->is_expert = false;
        $item->save();
        return redirect('/admin/countries')->with('status','Новая запись успешно создана!');

    }
    public function edit(Country $item)
    {
        return view('admin.countries.item',[
            'item' => $item,
        ]);
    }
    public function update(Country $item, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",

        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item->title = $request->title;
        $item->sort_order = $request->sort_order;
        if(isset($request->icon))
            $item->icon  = str_replace(url('/'),'',$request->icon);
        isset($request->is_searchable) ? $item->is_searchable = true : $item->is_searchable = false;
        isset($request->is_registry) ? $item->is_registry = true : $item->is_registry = false;
        isset($request->is_accr) ? $item->is_accr = true : $item->is_accr = false;
        isset($request->is_rating) ? $item->is_rating = true : $item->is_rating = false;
        isset($request->is_expert) ? $item->is_expert = true : $item->is_expert = false;
        $item->save();
        return redirect('/admin/countries')->with('status','Данные о записи успешно изменены!');

    }
    public function delete(Country $item)
    {
        $item->delete();
        return redirect()->back()->with('status','Страна успешно удалена!');
    }


}
