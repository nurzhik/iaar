<?php

namespace App\Http\Controllers\Admin\Accreditation;

use App\Http\Controllers\Controller;
use App\Models\Nodes\StaticPageNode;
use App\Models\StaticPage;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;

class AccreditationNodesController extends Controller
{

    public function editNode(int $type,StaticPage $parent, $lang)
    {
        if($type < 0 or $type >7 )
            return redirect()->back();
        if($parent->type_id !== 9 or $parent->univer_type_id !== $type)
            return redirect()->back()->with(['error' => 'Неверный тип страницы']);
        $item = StaticPageNode::where('parent_id', $parent->id)->where('lang',$lang)->first();
        if(empty($item))
        {
            $item = new StaticPageNode();
            $item->parent_id = $parent->id;
            $item->lang = $lang;
            $item->save();
        }
        $documents_array = $item->getDecodedDocuments();
        $add_documents_array = $item->getDecodedAddDocuments();
        JavaScript::put([
            'list'=> $documents_array,
            'list_add' => $add_documents_array
        ]);
        return view('admin.accreditation.nodes.item',[
            'item' => $item,
            'type' => $type,
            'lang' => $lang,
            'parent' => $parent
        ]);
    }


    public function updateNode(int $type,StaticPage $parent, $lang, Request $request)
    {
        if($type < 0 or $type >7 )
            return redirect()->back();
        if($parent->type_id !== 9 or $parent->univer_type_id !== $type)
            return redirect()->back()->with(['error' => 'Неверный тип страницы']);
        $validator = Validator::make($request->all(), [
            "title"    => "required",
            "country_id" => "exists:countries,id",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = StaticPageNode::where('parent_id', $parent->id)->where('lang',$lang)->first();
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
        return redirect()->route('accr_pages_index',['type'=>$type])->with('status','Страница успешно изменена!');

    }


    public function deleteNode(int $type, StaticPage $item)
    {
        if($type < 0 or $type >7 )
            return redirect()->back();
        if($item->type_id !== 9 or $item->univer_type_id !== $type)
            return redirect()->back()->with(['error' => 'Неверный тип страницы']);
        $item->delete();
        return redirect()->back()->with('status','Страница акккредитации успешно удалена!');
    }


}
