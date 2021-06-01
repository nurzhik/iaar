<?php

namespace App\Http\Controllers\Admin\StaticP;

use App\Http\Controllers\Controller;
use App\Models\Nodes\StaticPageNode;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class PagesNodesController extends Controller
{



    public function getHiddenPageNode($category, $lang)
    {
        $type = StaticPage::getTypeIdArray();
        $parent = StaticPage::where('type_id',$type[$category])
            -> where('appearance_type',0)
            ->firstOrCreate(['type_id' => $type[$category],'appearance_type' => 0]);
        $item = StaticPageNode::where('parent_id', $parent->id)->where('lang',$lang)->first();
        if(empty($item))
        {
            $item = new StaticPageNode();
            $item->parent_id = $parent->id;
            $item->lang = $lang;
            $item->save();
        }
        $add_document_array = $item->getDecodedAddDocuments();
        JavaScript::put([
            'list_add' => $add_document_array
        ]);
        return view('admin.static_pages.nodes.hidden_page',[
            'item' => $item,
            'category' => $category,
            'parent' => $parent,
            'lang' => $lang
        ]);

    }
    public function postHiddenPageNode($category, $lang, Request $request)
    {
        // return dump($request);
        $type = StaticPage::getTypeIdArray();
        $parent = StaticPage::where('type_id',$type[$category])
            -> where('appearance_type',0)
            ->first();
        if(empty($parent))
            return redirect()->back()->with(['error' => 'Ошибка существования']);
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = StaticPageNode::where('parent_id', $parent->id)->where('lang',$lang)->first();
        $item->title = $request->title;

        $item->content = str_replace(url('/'),'',$request->text);

        $item->og_title = $request->og_title;
        if(isset($request->add_documents))
        {
            $encoded_data = StaticPage::encodeAddDocuments($request->add_documents);
            if($encoded_data)
                $item->additional_documents = $encoded_data;
            else
            {
                $encoded_data = StaticPage::encodePartners($request->add_documents);
                if($encoded_data)
                    $item->additional_documents = $encoded_data;
                else
                    return redirect()->back()->with(['error' => 'Неверный формат прикрепленных документов']);
            }

        }
        else $item->additional_documents = null;
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        return redirect()->back()->with('status','Данные сохранены!');
    }


    public function editPageNode($category, StaticPage $parent, $lang, Request $request)
    {
        $type = StaticPage::getTypeIdArray();
        if($parent->type_id !== $type[$category])
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
        $add_document_array = $item->getDecodedAddDocuments();
        JavaScript::put([
            'list'=> $documents_array,
            'list_add' => $add_document_array
        ]);
        return view('admin.static_pages.nodes.item',[
            'item' => $item,
            'category' => $category,
            'parent' => $parent,
            'lang' => $lang
        ]);


    }
    public function updatePageNode($category, StaticPage $parent, $lang, Request $request)
    {
        $type = StaticPage::getTypeIdArray();
        if($parent->type_id !== $type[$category])
            return redirect()->back()->with(['error' => 'Неверный тип страницы']);
        $validator = Validator::make($request->all(), [
            "title"    => "required",
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
        return redirect()->back()->with('status','Данные изменены!');

    }
    public function deletePageNode($category,StaticPageNode $item)
    {

        $item->delete();
        return redirect()->back()->with('status','Запись удалена!');
    }
}
