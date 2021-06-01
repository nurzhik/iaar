<?php

namespace App\Http\Controllers\Admin\AccrRequests;

use App\Http\Controllers\Controller;
use App\Models\AccrRequestForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class AccrRequestFormsController extends Controller
{

    public function index()
    {
        $langs = ['kz','en'];
        $existing_langs =[];
        $check = AccrRequestForm::where('id','>',0)->first();
        if(!empty($check))
            foreach(AccrRequestForm::where('id','>',0)->first()->nodes()->get() as $node)
            {
                foreach($langs as $lang)
                {
                    if($node->lang == $lang)
                        $existing_langs[] = $lang;
                }
            }
        $existing_langs = array_unique($existing_langs);
        return view('admin.accr_requests.forms',[
            'existing_langs' => $existing_langs,
            'check' => $check
        ]);
    }
    public function update(Request $request)
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
            $item = AccrRequestForm::where('type_id',$key)->firstOrCreate(['type_id'=>$key]);
            $item->file  = str_replace(url('/'),'',$file);
            $item->save();
        }
        return redirect()->back()->with('status','Данные изменены!');
    }
}
