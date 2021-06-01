<?php

namespace App\Http\Controllers\Admin\Countries;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Nodes\CountryNode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class CountriesNodesController extends Controller
{
    public function create(Country $parent, $lang)
    {
        $item = CountryNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
        if(!empty($item))
            return redirect()->back()->with('error','Выбранный язык уже существует!');
        $item = new CountryNode();;
        return view('admin.countries.nodes.item',[
            'item' => $item,
            'parent' => $parent,
            'lang' => $lang
        ]);
    }
    public function store(Country $parent, $lang,Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new CountryNode();
        $item->title = $request->title;
        $item->parent_id = $parent->id;
        $item->lang = $lang;
        $item->save();
        return redirect()->route('edit_country',['item' => $parent->id])->with('status','Новый перевод успешно создан!');

    }
    public function edit(CountryNode $item)
    {
        $parent = Country::where('id',$item->parent_id)->first();
        $lang = $item->lang;
        return view('admin.countries.nodes.item',[
            'item' => $item,
            'parent' => $parent,
            'lang' => $lang
        ]);
    }
    public function update(CountryNode $item, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",

        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item->title = $request->title;
        $item->save();
        $parent = Country::where('id',$item->parent_id)->first();
        return redirect()->route('edit_country',['item' => $parent->id])->with('status','Данные о переводе успешно изменены!');

    }
    public function delete(CountryNode $item)
    {
        $item->delete();
        return redirect()->back()->with('status','Страна успешно удалена!');
    }


}
