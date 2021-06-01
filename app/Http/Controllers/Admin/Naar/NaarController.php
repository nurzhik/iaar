<?php

namespace App\Http\Controllers\Admin\Naar;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;


class NaarController extends Controller
{

    public function getReorder()
    {
        $type = StaticPage::getTypeIdArray();
        $pages = StaticPage::whereIn('type_id',[
            $type['board_members'],
            $type['team_members'],
            $type['experts_page'],
            ])->select('id','title','sort_order')->orderBy('sort_order')->get();
        $pages_array = $pages->toArray();
        JavaScript::put([
            'list'=> $pages_array,
        ]);
        return view('admin.naar.reorder',[
            'items' => $pages
        ]);

    }
    public function postReorder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "page"    => "required|array",
            "page.*"  => "required|exists:static_pages,id",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        foreach($request->page as $key=>$id)
        {
            $item = StaticPage::find($id);
            $item->sort_order = $key;
            $item->save();
        }
        return redirect()->back()->with('status','Успешно!');
    }

    public function getStructurePage()
    {
        $type = StaticPage::getTypeIdArray();
        $item = StaticPage::where('type_id',$type['organization_structure'])
            ->firstOrCreate(['type_id' => $type['organization_structure']]);
        return view('admin.naar.structure',[
            'item' => $item
        ]);

    }
    public function postStructurePage(Request $request)
    {
        $type = StaticPage::getTypeIdArray();
        $item = StaticPage::where('type_id',$type['organization_structure'])->first();
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
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        return redirect()->back()->with('status','Данные сохранены!');
    }
    public function getExpertsPage()
    {
        $type = StaticPage::getTypeIdArray();
        $item = StaticPage::where('type_id',$type['experts_page'])
            ->firstOrCreate(['type_id' => $type['experts_page']]);
        $documents_array = $item->getDecodedDocuments();
        JavaScript::put([
            'list'=> $documents_array,
        ]);
        return view('admin.naar.experts',[
            'item' => $item
        ]);

    }

    public function postExpertsPage(Request $request)
    {
        //return dump($request);
        $type = StaticPage::getTypeIdArray();
        $item = StaticPage::where('type_id',$type['experts_page'])->first();
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
        if(isset($request->documents))
        {
            $encoded_data = StaticPage::encodeDocuments($request->documents);
            if($encoded_data)
                $item->documents = $encoded_data;
            else
                return redirect()->back()->with(['error' => 'Неверный формат прикрепленных документов']);
                //return dump($encoded_data);
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
        return redirect()->back()->with('status','Данные сохранены!');

    }
}
