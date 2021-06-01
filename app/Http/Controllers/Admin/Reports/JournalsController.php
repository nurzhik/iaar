<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use App\Models\BoardMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class JournalsController extends Controller
{

    public function editPage($slug)
    {
        $type = StaticPage::getTypeIdArray();
        $type_id  = $type[$slug];
        if(!in_array($type_id,[25,26,27,28,29]))
            return redirect()->back()->with('error','Неверный тип страницы!');
        $item = StaticPage::where('type_id',$type_id)->firstOrCreate(['type_id' => $type_id]);
        $documents_array = $item->getDecodedDocuments();
        $add_document_array = $item->getDecodedAddDocuments();
        JavaScript::put([
            'list'=> $documents_array,
            'list_add' => $add_document_array
        ]);

        return view('admin.reports.journals.'.$slug,[
            'item' => $item
        ]);
    }

    public function updatePage($slug, Request $request)
    {
        $type = StaticPage::getTypeIdArray();
        $type_id  = $type[$slug];
        if(!in_array($type_id,[25,26,27,28,29]))
            return redirect()->back()->with('error','Неверный тип страницы!');
        $item = StaticPage::where('type_id',$type_id)->first();
        if(empty($item))
            return redirect()->back();
        $item->title = $request->title;
        $item->slug = $request->slug;
        if(isset($request->main_image))
            $item->main_image  = str_replace(url('/'),'',$request->main_image);
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
        return redirect()->back()->with('status','Данные о странице успешно сохранены!');
    }

    public function createMember()
    {
        $parent = StaticPage::where('type_id',25)->first();
        if(empty($parent))
            return redirect()->back();

        $item = new BoardMember();
        return view('admin.reports.journals.board_member',[
            'item' => $item,
            'parent' => $parent
        ]);

    }

    public function storeMember(Request $request)
    {
        $parent = StaticPage::where('type_id',25)->first();
        if(empty($parent))
            return redirect()->back();
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
        if(isset($request->photo))
            $item->photo  = str_replace(url('/'),'',$request->photo);
        $item->content = str_replace(url('/'),'',$request->text);
        $item->page_id = $parent->id;
        $item->save();
        return redirect()->back()->with('status','Элемент создан!');

    }

    public function editMember(BoardMember $item)
    {
        $parent = StaticPage::where('type_id',25)->first();
        if(empty($parent))
            return redirect()->back();
        return view('admin.reports.journals.board_member',[
            'item' => $item,
            'parent' => $parent
        ]);
    }
    public function updateMember(BoardMember $item, Request $request)
    {

        $parent = StaticPage::where('type_id',25)->first();
        if(empty($parent))
            return redirect()->back();
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

