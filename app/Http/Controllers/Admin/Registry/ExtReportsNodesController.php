<?php

namespace App\Http\Controllers\Admin\Registry;

use App\Http\Controllers\Controller;

use App\Models\ExtReport;

use App\Models\Nodes\ExtReportNode;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;

class ExtReportsNodesController extends Controller
{
    public function create(ExtReport $parent,$lang)
    {
        $item = ExtReportNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
        if(!empty($item))
            return redirect()->back()->with('error','Выбранный язык уже существует!');
        $item = new ExtReportNode();
        $text = $item->getEncodedText();
        JavaScript::put([
            'vek_text'=> $text,
        ]);
        return view('admin.univer.nodes.ext_report',[
            'item' => $item,
            'parent' => $parent,
            'lang' => $lang
        ]);
    }
    public function store(ExtReport $parent, $lang, Request $request)
    {
        $validator = Validator::make($request->all(), [

        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new ExtReportNode();
        if(isset($request->documents))
        {
            $result = ExtReport::encodeText($request->documents);
            if($result)
                $item->text = $result;
        }

        $item->parent_id = $parent->id;
        $item->lang = $lang;

        $item->save();
        return redirect()->route('edit_vek_report',['item' => $parent->id])->with('status','Данные о переводе успешно добавлены!');

    }
    public function edit (ExtReportNode $item)
    {
        $text = $item->getEncodedText();
        JavaScript::put([
            'vek_text'=> $text,
        ]);
        $parent = ExtReport::where('id',$item->parent_id)->first();
        return view('admin.univer.nodes.ext_report',[
            'item' => $item,
            'parent' => $parent,
            'lang' => $item->lang,
        ]);
    }
    public function update(ExtReportNode $item, Request $request)
    {

        $validator = Validator::make($request->all(), [

        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        if(isset($request->documents))
        {
            $result = ExtReport::encodeText($request->documents);
            if($result)
                $item->text = $result;
        }
        else $item->text = null;
        $item->save();
        $parent = ExtReport::where('id',$item->parent_id)->first();
        return redirect()->route('edit_vek_report',['item' => $parent->id])->with('status','Данные о переводе успешно изменены!');


    }
    public function delete(ExtReportNode $item)
    {
        $item->delete();
        return redirect()->back()->with('status','Данные об аккредитации успешно удалены!');
    }


}
