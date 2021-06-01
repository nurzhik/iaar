<?php

namespace App\Http\Controllers\Admin\Rating;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use App\Models\Nodes\StaticPageNode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class RatingPagesNodesController extends Controller
{

    //Board members in JournalsNodesController

    public function editCouncilPageNode($lang)
    {
        $parent = StaticPage::where('type_id',32)->first();
        $item = StaticPageNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
        if(empty($item))
        {
            $item = new StaticPageNode();
            $item->lang = $lang;
            $item->parent_id = $parent->id;
            $item->save();
        }
        $documents_array = $item->getDecodedDocuments();
        $add_document_array = $item->getDecodedAddDocuments();
        JavaScript::put([
            'list'=> $documents_array,
            'list_add' => $add_document_array
        ]);
        return view('admin.reports.journals.nodes.rating_council',[
            'item' => $item,
            'parent' => $parent,
            'lang' => $lang
        ]);


    }
    public function updateCouncilPageNode($lang, Request $request)
    {

        $parent = StaticPage::where('type_id',32)->first();
        if(empty($parent))
            return redirect()->back();
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
        return redirect()->route('edit_rating_council')->with('status','Данные о переводе успешно сохранены!');
    }

    public function create( StaticPage $parent, $lang)
    {
        $item = StaticPageNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
        if(!empty($item))
            return redirect()->back()->with('error','Выбранный язык уже существует!');
        $item = new StaticPageNode();
        $documents_array = $item->getDecodedDocuments();
        $add_document_array = $item->getDecodedAddDocuments();
        JavaScript::put([
            'list'=> $documents_array,
            'list_add' => $add_document_array
        ]);
        return view('admin.rating.nodes.item',[
            'item' => $item,
            'parent' => $parent,
            'lang' => $lang,
        ]);
    }
    public function store( StaticPage $parent, $lang, Request $request)
    {

        $validator = Validator::make($request->all(), [
            "title"    => "required",

        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new StaticPageNode();
        $item->title = $request->title;
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
        if(isset($request->og_img))
            $item->og_img  = str_replace(url('/'),'',$request->og_img);
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;


        $item->parent_id = $parent->id;
        $item->lang = $lang;
        $item->save();
        return redirect()->route('edit_rating_page',['item' => $parent->id,'type' => $parent->univer_type_id])->with('status','Новый перевод успешно добавлен');

    }
    public function edit(StaticPageNode $item)
    {
        $parent = StaticPage::where('id',$item->parent_id)->first();
        $documents_array = $item->getDecodedDocuments();
        $add_document_array = $item->getDecodedAddDocuments();
        JavaScript::put([
            'list'=> $documents_array,
            'list_add' => $add_document_array
        ]);
        return view('admin.rating.nodes.item',[
            'item' => $item,
            'parent' => $parent,
            'lang' => $item->lang,
        ]);
    }
    public function update(StaticPageNode $item, Request $request)
    {

        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $validator = Validator::make($request->all(), [
            "title"    => "required",

        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item->title = $request->title;
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
        if(isset($request->og_img))
            $item->og_img  = str_replace(url('/'),'',$request->og_img);
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        $parent = StaticPage::where('id',$item->parent_id)->first();
        return redirect()->route('edit_rating_page',['item' => $parent->id,'type' => $parent->univer_type_id])->with('status','Данные о переводе изменены!');


    }
    public function delete(StaticPageNode $item)
    {
        $item->delete();
        return redirect()->back()->with('status','Перевод успешно удален!');
    }


}