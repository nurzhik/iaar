<?php

namespace App\Http\Controllers\Admin\Naar;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use App\Models\CommisionTab;

use App\Models\BoardMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;

class BoardsController extends Controller
{

    public function index()
    {
        $type = StaticPage::getTypeIdArray();
        $items = StaticPage::where('type_id',$type['board_members'])->orderBy('sort_order')->get();
        return view('admin.naar.board.index',[
            'items' => $items
        ]);

    }

    public function create()
    {
        $item = new StaticPage();
        $documents_array = $item->getDecodedDocuments();
        JavaScript::put([
            'list'=> $documents_array,
        ]);
        return view('admin.naar.board.item',[
            'item' => $item
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $type = StaticPage::getTypeIdArray();
        $item = new StaticPage();
        $item->type_id = $type['board_members'];
        $item->title = $request->title;
        $item->slug = $request->slug;
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
        if(isset($request->og_img))
            $item->og_img  = str_replace(url('/'),'',$request->og_img);
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        return redirect()->back()->with('status','Элемент создан!');

    }

    public function edit(StaticPage $item, Request $request)
    {
        $type = StaticPage::getTypeIdArray();
        if($item->type_id !== $type['board_members'])
            return redirect()->back()->with(['error' => 'Неверный тип страницы']);
        $documents_array = $item->getDecodedDocuments();
        JavaScript::put([
            'list'=> $documents_array,
        ]);
        return view('admin.naar.board.item',[
            'item' => $item,
        ]);


    }
    public function update(StaticPage $item, Request $request)
    {
        $type = StaticPage::getTypeIdArray();
        if($item->type_id !== $type['board_members'])
            return redirect()->back()->with(['error' => 'Неверный тип страницы']);
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item->title = $request->title;
        $item->slug = $request->slug;
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
        if(isset($request->og_img))
            $item->og_img  = str_replace(url('/'),'',$request->og_img);
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        return redirect()->back()->with('status','Данные изменены!');

    }
    public function delete(StaticPage $item)
    {
        $type = StaticPage::getTypeIdArray();
        if($item->type_id !== $type['board_members'])
            return redirect()->back()->with(['error' => 'Неверный тип страницы']);
        $item->delete();
        return redirect()->back()->with('status','Запись удалена!');
    }

    public function createMember(StaticPage $parent)
    {
        $type = StaticPage::getTypeIdArray();
        if($parent->type_id !== $type['board_members'])
            return redirect()->back()->with(['error' => 'Неверный тип страницы']);
        $item = new BoardMember();
        return view('admin.naar.board.board_member',[
            'item' => $item,
            'parent' => $parent
        ]);

    }

    public function storeMember(StaticPage $parent,Request $request)
    {
        $type = StaticPage::getTypeIdArray();
        if($parent->type_id !== $type['board_members'])
            return redirect()->back()->with(['error' => 'Неверный тип страницы']);
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new BoardMember();
        $item->title = $request->title;
        $item->job = $request->job;
        $item->short_desc = $request->short_desc;
        $item->sort_order = $request->sort_order;
        $item->tab_id = $request->tab_id;
        if(isset($request->photo))
            $item->photo  = str_replace(url('/'),'',$request->photo);
        $item->content = str_replace(url('/'),'',$request->text);
        $item->page_id = $parent->id;
        $item->save();
        return redirect()->back()->with('status','Элемент создан!');

    }

    public function editMember(StaticPage $parent, BoardMember $item)
    {
        $type = StaticPage::getTypeIdArray();
        if($parent->type_id !== $type['board_members'])
            return redirect()->back()->with(['error' => 'Неверный тип страницы']);
        return view('admin.naar.board.board_member',[
            'item' => $item,
            'parent' => $parent
        ]);
    }
    public function updateMember(StaticPage $parent, BoardMember $item, Request $request)
    {

        $type = StaticPage::getTypeIdArray();
        if($parent->type_id !== $type['board_members'])
            return redirect()->back()->with(['error' => 'Неверный тип страницы']);
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
        $item->sort_order = $request->sort_order;
        $item->tab_id = $request->tab_id;
        if(isset($request->photo))
            $item->photo  = str_replace(url('/'),'',$request->photo);
        $item->content = str_replace(url('/'),'',$request->text);
        $item->save();
        return redirect()->back()->with('status','Элемент создан!');
    }
    public function deleteMember(BoardMember $item)
    {
        $item->delete();
        return redirect()->back()->with('status','Запись удалена!');
    }


}
