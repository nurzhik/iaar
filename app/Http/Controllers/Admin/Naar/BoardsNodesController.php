<?php

namespace App\Http\Controllers\Admin\Naar;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use App\Models\BoardMember;


use App\Models\Nodes\StaticPageNode;
use App\Models\Nodes\BoardMemberNode;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;

class BoardsNodesController extends Controller
{
    public function create(StaticPage $parent, $lang)
    {
        $item = StaticPageNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
        if(!empty($item))
            return redirect()->back()->with('error','Выбранный язык уже существует!');
        $item = new StaticPageNode();
        $documents_array = $item->getDecodedDocuments();
        JavaScript::put([
            'list'=> $documents_array,
        ]);
        return view('admin.naar.board.nodes.item',[
            'item' => $item,
            'lang' => $lang,
            'parent' => $parent
        ]);
    }

    public function store(StaticPage $parent, $lang,Request $request)
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
        $item->content = str_replace(url('/'),'',$request->text);
        if(isset($request->documents))
        {
            $encoded_data = StaticPage::encodeDocuments($request->documents);
            if($encoded_data)
                $item->documents = $encoded_data;
            else
                return redirect()->back()->with(['error' => 'Неверный формат прикрепленных документов']);
        }
        $item->og_title = $request->og_title;
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->parent_id = $parent->id;
        $item->lang = $lang;
        $item->save();
        return redirect()->route('edit_board',['item' => $parent->id])->with('status','Новый перевод успешно создан!');

    }

    public function edit(StaticPageNode $item)
    {
        $documents_array = $item->getDecodedDocuments();
        JavaScript::put([
            'list'=> $documents_array,
        ]);
        $parent = StaticPage::where('id',$item->parent_id)->first();
        $lang = $item->lang;
        return view('admin.naar.board.nodes.item',[
            'item' => $item,
            'lang' => $lang,
            'parent' => $parent
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
        $item->og_title = $request->og_title;
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        $parent = StaticPage::where('id',$item->parent_id)->first();
        return redirect()->route('edit_board',['item' => $parent->id])->with('status','Данные о переводе успешно изменены!');

    }
    public function delete(StaticPageNode $item)
    {

        $item->delete();
        return redirect()->back()->with('status','Запись удалена!');
    }


    public function createMember(BoardMember $parent, $lang)
    {
        $item = BoardMemberNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
        if(!empty($item))
            return redirect()->back()->with('error','Выбранный язык уже существует!');
        $item = new BoardMemberNode();
        return view('admin.naar.board.nodes.board_member',[
            'item' => $item,
            'lang' => $lang,
            'parent' => $parent
        ]);

    }

    public function storeMember(BoardMember $parent, $lang,Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new BoardMemberNode();
        $item->title = $request->title;
        $item->job = $request->job;
        $item->short_desc = $request->short_desc;
        $item->content = str_replace(url('/'),'',$request->text);
        $item->parent_id = $parent->id;
        $item->lang = $lang;
        $item->save();
        return redirect()->route('edit_board_member',['parent'=>$parent->page_id,'item' => $parent->id])->with('status','Новый перевод успешно создан!');

    }

    public function editMember(BoardMemberNode $item)
    {
        $lang = $item->lang;
        $parent = BoardMember::where('id',$item->parent_id)->first();
        return view('admin.naar.board.nodes.board_member',[
            'item' => $item,
            'lang' => $lang,
            'parent' => $parent
        ]);
    }
    public function updateMember(BoardMemberNode $item, Request $request)
    {
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
        $parent = BoardMember::where('id',$item->parent_id)->first();
        return redirect()->route('edit_board_member',['parent'=>$parent->page_id,'item' => $parent->id])->with('status','Новый перевод успешно создан!');
    }
    public function deleteMember(BoardMemberNode $item)
    {
        $item->delete();
        return redirect()->back()->with('status','Запись удалена!');
    }


}
