<?php

namespace App\Http\Controllers\Admin\Rating;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class RatingPagesController extends Controller
{

    public function index(int $type)
    {
        if($type < 0 or $type >7 )
            return redirect()->back();
        $items = StaticPage::where('univer_type_id',$type)->
        where('type_id',10)->
        orderBy('sort_order')->get();
        return view('admin.rating.index',[
            'items' => $items,
            'type' => $type
        ]);

    }
    public function create(int $type)
    {
        if($type < 0 or $type >7 )
            return redirect()->back();
        $item = new StaticPage();
        $documents_array = $item->getDecodedDocuments();
        $add_document_array = $item->getDecodedAddDocuments();
        JavaScript::put([
            'list'=> $documents_array,
            'list_add' => $add_document_array
        ]);
        return view('admin.rating.item',[
            'item' => $item,
            'type' => $type
        ]);
    }
    public function store(int $type, Request $request)
    {
        if($type < 0 or $type >7 )
            return redirect()->back();
        $validator = Validator::make($request->all(), [
            "title"    => "required",
            "country_id" => "required|exists:countries,id",
            'year' =>'required'

        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = StaticPage::where('type_id',10)->where('univer_type_id',$type)
            ->where('country_id',$request->country_id)
            ->where('year',$request->year)
            ->first();
        if(!empty($item))
            return redirect()->back()->with(['error' => 'Страница с выбранной страной и(или) годом уже существует!']);
        $item = new StaticPage();
        $item->title = $request->title;
        $item->country_id = $request->country_id;
        $item->univer_type_id = $type;

        $item->type_id = 10;

        $item->year = $request->year;
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
        return redirect()->route('rating_page_index',['type' => $item->univer_type_id])->with('status','Данные успешно сохранены!');

    }
    public function edit(int $type,StaticPage $item)
    {
        if($type < 0 or $type >7 )
            return redirect()->back();
        if($item->type_id !== 10 or $item->univer_type_id !== $type)
            return redirect()->back()->with(['error' => 'Неверный тип страницы']);
        $documents_array = $item->getDecodedDocuments();
        $add_document_array = $item->getDecodedAddDocuments();
        JavaScript::put([
            'list'=> $documents_array,
            'list_add' => $add_document_array
        ]);
        return view('admin.rating.item',[
            'item' => $item,
            'type' => $type
        ]);
    }
    public function update(int $type,StaticPage $item, Request $request)
    {
        if($type < 0 or $type >7 )
            return redirect()->back();
        if($item->type_id !== 10 or $item->univer_type_id !== $type)
            return redirect()->back()->with(['error' => 'Неверный тип страницы']);
        $validator = Validator::make($request->all(), [
            "title"    => "required",
            "country_id" => "required|exists:countries,id",
            'year' =>'required'

        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item->title = $request->title;
        $item->country_id = $request->country_id;
        $item->univer_type_id = $type;
      //  $item->type_id = 10;
        $item->year = $request->year;
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
        return redirect()->back()->with('status','Данные успешно сохранены!');


    }
    public function delete(int $type, StaticPage $item)
    {
        if($type < 0 or $type >7 )
            return redirect()->back();
        if($item->type_id !== 10 or $item->univer_type_id !== $type)
            return redirect()->back()->with(['error' => 'Неверный тип страницы']);
        $item->delete();
        return redirect()->back()->with('status','Страница акккредитации успешно удалена!');
    }


}