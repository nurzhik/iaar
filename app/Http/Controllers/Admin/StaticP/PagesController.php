<?php

namespace App\Http\Controllers\Admin\StaticP;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class PagesController extends Controller
{
    public function getReorder($category)
    {
        $type = StaticPage::getTypeIdArray();
        $pages = StaticPage::whereIn('type_id',[
            $type[$category]
        ])->
        where('appearance_type',1)->
        select('id','title','sort_order')->orderBy('sort_order')->get();
        $pages_array = $pages->toArray();
        JavaScript::put([
            'list'=> $pages_array,
        ]);
        return view('admin.static_pages.reorder',[
            'items' => $pages,
            'category' => $category
        ]);

    }

    public function postReorder($category, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "page"    => "required|array",
            "page.*"  => "required|exists:static_pages,id",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $type = StaticPage::getTypeIdArray();
        DB::beginTransaction();
        foreach($request->page as $key=>$id)
        {

            $item = StaticPage::find($id);
            if($item->type_id !== $type[$category])
            {
                DB::rollBack();
                return redirect()->back()->with('error','Неверная категория');
            }
            $item->sort_order = $key;
            $item->save();
        }
        DB::commit();
        return redirect()->back()->with('status','Успешно!');
    }

    public function getHiddenPage($category)
    {
        $type = StaticPage::getTypeIdArray();
        $item = StaticPage::where('type_id',$type[$category])
            -> where('appearance_type',0)
            ->firstOrCreate(['type_id' => $type[$category],'appearance_type' => 0]);
        $add_document_array = $item->getDecodedAddDocuments();
        JavaScript::put([
            'list_add' => $add_document_array
        ]);
        return view('admin.static_pages.hidden_page',[
            'item' => $item,
            'category' => $category
        ]);

    }
    public function postHiddenPage($category,Request $request)
    {
       // return dump($request);
        $type = StaticPage::getTypeIdArray();
        $item = StaticPage::where('type_id',$type[$category])
            -> where('appearance_type',0)
            ->first();
        if(empty($item))
            return redirect()->back()->with(['error' => 'Ошибка существования']);
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
        if(isset($request->main_image))
            $item->main_image  = str_replace(url('/'),'',$request->main_image);
        $item->og_title = $request->og_title;
        if(isset($request->og_img))
            $item->og_img  = str_replace(url('/'),'',$request->og_img);
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
    public function indexPages($category)
    {
        $type = StaticPage::getTypeIdArray();
        $items = StaticPage::where('type_id',$type[$category])->
        where('appearance_type',1)->orderBy('sort_order')->get();
        return view('admin.static_pages.pages',[
            'items' => $items,
            'category' => $category
        ]);

    }

    public function createPage($category)
    {
        $item = new StaticPage();
        $documents_array = $item->getDecodedDocuments();
        $add_document_array = $item->getDecodedAddDocuments();
        JavaScript::put([
            'list'=> $documents_array,
            'list_add' => $add_document_array
        ]);
        return view('admin.static_pages.item',[
            'item' => $item,
            'category' => $category
        ]);
    }

    public function storePage($category,Request $request)
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

        $item->type_id = $type[$category];
        $item->appearance_type = 1;

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

    public function editPage($category,StaticPage $item, Request $request)
    {
        $type = StaticPage::getTypeIdArray();
        if($item->type_id !== $type[$category])
            return redirect()->back()->with(['error' => 'Неверный тип страницы']);
        $documents_array = $item->getDecodedDocuments();
        $add_document_array = $item->getDecodedAddDocuments();
        JavaScript::put([
            'list'=> $documents_array,
            'list_add' => $add_document_array
        ]);
        return view('admin.static_pages.item',[
            'item' => $item,
            'category' => $category
        ]);


    }
    public function updatePage($category,StaticPage $item, Request $request)
    {
        $type = StaticPage::getTypeIdArray();
        if($item->type_id !== $type[$category])
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
        return redirect()->back()->with('status','Данные изменены!');

    }
    public function deletePage($category,StaticPage $item)
    {
        $type = StaticPage::getTypeIdArray();
        if($item->type_id !== $type[$category])
            return redirect()->back()->with(['error' => 'Неверный тип страницы']);
        $item->delete();
        return redirect()->back()->with('status','Запись удалена!');
    }
}
