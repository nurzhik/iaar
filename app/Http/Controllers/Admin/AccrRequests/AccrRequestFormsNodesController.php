<?php

namespace App\Http\Controllers\Admin\AccrRequests;

use App\Http\Controllers\Controller;
use App\Models\AccrRequestForm;
use App\Models\Nodes\AccrRequestFormNode;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class AccrRequestFormsNodesController extends Controller
{

    public function create($lang)
    {
        $item = AccrRequestFormNode::where('lang',$lang)->first();
        if(!empty($item))
            return redirect()->back()->with('error','Выбранный язык уже существует!');
       // $item = new AccrRequestFormNode();
        $create = true;
        return view('admin.accr_requests.nodes.forms',[
            //'item' => $item,
            'create' => $create,
            'lang' => $lang

        ]);

    }
    public function store($lang, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "file"    => "required|array",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }

        foreach($request->file as $key=>$file)
        {
            $parent = AccrRequestForm::where('type_id',$key)->first();
            $item = new AccrRequestFormNode();
            $item->file  = str_replace(url('/'),'',$file);
            $item->parent_id = $parent->id;
            $item->lang = $lang;
            $item->save();
        }
        return redirect()->route('edit_request_form')->with('status','Данные о переводе созданы');

    }

    public function edit($lang)
    {
        $create = false;
        return view('admin.accr_requests.nodes.forms',[
            //'item' => $item,
            'create' => $create,
            'lang' => $lang
        ]);
    }
    public function update($lang, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "file"    => "required|array",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        foreach($request->file as $key=>$file)
        {
            $parent = AccrRequestForm::where('type_id',$key)->first();
            $item = AccrRequestFormNode::where('lang',$lang)->where('parent_id',$parent->id)->first();
            $item->file  = str_replace(url('/'),'',$file);
            $item->save();
        }
        return redirect()->route('edit_request_form')->with('status','Данные о переводе изменены!');
    }
   /* public function delete(AccrRequestFormNode $item )
    {
        $item->delete();
        return redirect()->back()->with('status','Данные о переводе удалены!');

    }
   */

}
