<?php

namespace App\Http\Controllers\Admin\Postmonitoring;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use App\Models\Nodes\StaticPageNode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class PostmonitoringNodesController extends Controller
{
    public function edit($lang)
    {
        $parent = StaticPage::where('type_id',18)->first();
        $item = StaticPageNode::where('parent_id',$parent->id)->where('lang',$lang)->firstOrCreate([]);
        $item->parent_id = $parent->id;
        $item->lang = $lang;
        $item->save();
        $documents_array = $item->getDecodedDocuments();
        $add_document_array = $item->getDecodedAddDocuments();
        JavaScript::put([
            'list'=> $documents_array,
            'list_add' => $add_document_array
        ]);
        return view('admin.postmonitoring.nodes.index',[
            'item' => $item,
            'lang' => $lang,
            'parent' => $parent
        ]);
    }
    public function update($lang,Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $parent = StaticPage::where('type_id',18)->first();
        $item = StaticPageNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
        $item->title = $request->title;
        $item->content = str_replace(url('/'),'',$request->text);
        if(isset($request->documents))
        {
            $encoded_data = StaticPage::encodeDocuments($request->documents);
            if($encoded_data)
                $item->documents = $encoded_data;
            else
                return redirect()->back()->with(['error' => 'Неверный формат прикрепленных документов']);
        }
        else $item->documents = null;
        if(isset($request->add_documents))
        {
            $encoded_data = StaticPage::encodeAddDocuments($request->add_documents);
            if($encoded_data)
                $item->additional_documents = $encoded_data;
            else
                return redirect()->back()->with(['error' => 'Неверный формат прикрепленных документов']);
        }
        else $item->additional_documents = null;
        $item->og_title = $request->og_title;
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        return redirect()->route('edit_postmonitoring')->with('status','Данные о переводе успешно изменены!');

    }

}
