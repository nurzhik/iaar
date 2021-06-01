<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\Nodes\BoardMemberNode;
use App\Models\Nodes\StaticPageNode;
use App\Models\StaticPage;
use App\Models\BoardMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class JournalsNodesController extends Controller
{

    public function editNode($slug, $lang)
    {
        $type = StaticPage::getTypeIdArray();
        $type_id  = $type[$slug];
        if(!in_array($type_id,[25,26,27,28,29]))
            return redirect()->back()->with('error','Неверный тип страницы!');
        $parent = StaticPage::where('type_id',$type_id)->firstOrCreate(['type_id' => $type_id]);
        $item = StaticPageNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
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
            'list_tab' => $add_document_array
        ]);

        return view('admin.reports.journals.nodes.'.$slug,[
            'item' => $item,
            'parent' => $parent,
            'lang' => $lang
        ]);
    }

    public function updateNode($slug, $lang, Request $request)
    {
        $type = StaticPage::getTypeIdArray();
        $type_id  = $type[$slug];
        if(!in_array($type_id,[25,26,27,28,29]))
            return redirect()->back()->with('error','Неверный тип страницы!');
        $parent = StaticPage::where('type_id',$type_id)->first();
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
        return redirect()->route('edit_journals_page',['slug' => $slug])->with('status','Данные о переводе успешно сохранены!');
    }


    public function editMemberNode(BoardMember $parent, $lang)
    {
        $item = BoardMemberNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
        if(empty($item))
        {
            $item = new BoardMemberNode();
            $item->parent_id = $parent->id;
            $item->lang = $lang;
            $item->save();
        }
        return view('admin.reports.journals.nodes.rating_board_member',[
            'item' => $item,
            'parent' => $parent,
            'lang' => $lang,
        ]);
    }
    public function updateMemberNode(BoardMember $parent, $lang, Request $request)
    {

        $item = BoardMemberNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item->title = $request->title;
        $item->job = $request->job;
        $item->short_desc = $request->short_desc;
        $item->content = str_replace(url('/'),'',$request->text);
        $item->save();
        if($parent->page->type_id !== 32)
            return redirect()->route('edit_board_member_journal',['item' => $parent->id])->with('status','Данные о переводе успешно сохранены!');
            else
        return redirect()->route('edit_board_member_rating',['item' => $parent->id])->with('status','Данные о переводе успешно сохранены!');
    }
    public function deleteMember(BoardMemberNode $item)
    {
        $item->delete();
        return redirect()->back()->with('status','Запись удалена!');
    }


}

