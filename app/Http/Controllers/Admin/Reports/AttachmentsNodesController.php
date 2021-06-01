<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use App\Models\Attachment;
use App\Models\Nodes\AttachmentNode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class AttachmentsNodesController extends Controller
{
    public function create( Attachment $parent, $lang)
    {

        $item = AttachmentNode::where('lang',$lang)->where('parent_id',$parent->id)->first();
        if(!empty($item))
            return redirect()->back()->with('status','Выбранный язык уже существует!');
        $item = new AttachmentNode();
        $ar = array_flip(StaticPage::getTypeIdArray());
        return view('admin.reports.attachments.nodes.'.$ar[$parent->parentPage->type_id],[
            'item' =>$item,
            'parent' => $parent,
            'lang' => $lang,
        ]);

    }
    public function store( Request $request, Attachment $parent, $lang)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new AttachmentNode();
        $item->title = $request->title;

        if(isset($request->short_desc))
            $item->short_desc = $request->short_desc;
        if(isset($request->image))
            $item->image  = str_replace(url('/'),'',$request->image);
        if(isset($request->file))
            $item->file  = str_replace(url('/'),'',$request->file);
        $item->parent_id = $parent->id;
        $item->lang = $lang;
        $item->save();
        return redirect()->route('edit_attachment',['type'=> $parent->parentPage->type_id,'parent' => $parent->page_id,'item' => $parent->id])->with('status','Новый перевод успешно добавлен!');
    }

    public function edit( AttachmentNode $item, $lang)
    {
        $parent = Attachment::where('id',$item->parent_id)->first();
        $ar = array_flip(StaticPage::getTypeIdArray());
        return view('admin.reports.attachments.nodes.'.$ar[$parent->parentPage->type_id],[
            'item' =>$item,
            'parent' => $parent,
            'lang' => $lang,
        ]);

    }
    public function update(AttachmentNode $item, $lang, Request $request)
    {

        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $parent = Attachment::where('id',$item->parent_id)->first();
        $item->title = $request->title;
        if(isset($request->short_desc))
            $item->short_desc = $request->short_desc;
        if(isset($request->image))
            $item->image  = str_replace(url('/'),'',$request->image);
        if(isset($request->file))
            $item->file  = str_replace(url('/'),'',$request->file);
        $item->parent_id = $parent->id;
        $item->lang = $lang;
        $item->save();
        return redirect()->route('edit_attachment',['type'=> $parent->parentPage->type_id,'parent' => $parent->page_id,'item' => $parent->id])->with('status','Данные о переводе успешно изменены!');



    }
    public function delete( AttachmentNode $item)
    {

        $item->delete();
        return redirect()->back()->with('status','Запись успешно удалена!');

    }


}