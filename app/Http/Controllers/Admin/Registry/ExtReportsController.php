<?php

namespace App\Http\Controllers\Admin\Registry;

use App\Http\Controllers\Controller;
use App\Models\Univer;
use App\Models\ExtReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;

class ExtReportsController extends Controller
{

    public function create(Univer $parent)
    {
        $item = new ExtReport();

        $text = $item->getEncodedText();
        JavaScript::put([
            'vek_text'=> $text,
        ]);
        return view('admin.univer.ext_report',[
            'item' => $item,
            'parent' => $parent
        ]);
    }
    public function store(Univer $parent,Request $request)
    {
        $validator = Validator::make($request->all(), [
            "date_start"    => "required",

        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new ExtReport();
        $item->date_start = $request->date_start;
        $item->date_end = $request->date_end;
        $item->univer_type_id = $request->univer_type_id;
        if(isset($request->documents))
        {
            $result = ExtReport::encodeText($request->documents);
            if($result)
                $item->text = $result;
        }
        $item->university_id = $parent->id;
        $item->save();
        return redirect()->route('edit_univer',['item' => $parent->id])->with('status','Новый отчет ВЭК успешно добавлен!');

    }
    public function edit(ExtReport $item)
    {
        $text = $item->getEncodedText();
        JavaScript::put([
            'vek_text'=> $text,
        ]);
        $parent = Univer::where('id',$item->university_id)->first();
        return view('admin.univer.ext_report',[
            'item' => $item,
            'parent' => $parent
        ]);
    }
    public function update(ExtReport $item, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "date_start"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item->date_start = $request->date_start;
        $item->date_end = $request->date_end;
        $item->univer_type_id = $request->univer_type_id;
        if(isset($request->documents))
        {
            $result = ExtReport::encodeText($request->documents);
            if($result)
                $item->text = $result;
        }
        else $item->text = null;

        $item->save();
        $parent = Univer::where('id',$item->university_id)->first();
        return redirect()->route('edit_univer',['item' => $parent->id])->with('status','Данные об отчете ВЭК успешно изменены!');


    }
    public function delete(ExtReport $item)
    {
        $item->delete();
        return redirect()->back()->with('status','Данные об отчете ВЭК успешно удалены!');
    }


}
