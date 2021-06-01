<?php

namespace App\Http\Controllers\Admin\Naar;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use App\Models\Nodes\StaticPageNode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;


class NaarNodesController extends Controller
{

    public function getStructurePage($lang)
    {
        $type = StaticPage::getTypeIdArray();
        $parent = StaticPage::where('type_id',$type['organization_structure'])
            ->first();
        $item = StaticPageNode::where('parent_id',$parent->id)->where('lang',$lang)->firstOrCreate([]);
        $item->lang = $lang;
        $item->parent_id = $parent->id;
        $item->save();
        return view('admin.naar.nodes.structure',[
            'item' => $item,
            'parent' => $parent,
            'lang' => $lang
        ]);

    }
    public function postStructurePage($lang,Request $request)
    {
        $type = StaticPage::getTypeIdArray();
        $parent = StaticPage::where('type_id',$type['organization_structure'])->first();
        $item = StaticPageNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item->title = $request->title;
        $item->content = str_replace(url('/'),'',$request->text);
        $item->og_title = $request->og_title;
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        return redirect()->route('edit_structure_page')->with('status','Данные о переводе успешно изменены!');
    }
    public function getExpertsPage($lang)
    {
        $type = StaticPage::getTypeIdArray();
        $parent = StaticPage::where('type_id',$type['experts_page'])
            ->firstOrCreate(['type_id' => $type['experts_page']]);

        $item = StaticPageNode::where('parent_id',$parent->id)->where('lang',$lang)->firstOrCreate([]);

        $item->lang = $lang;
        $item->parent_id = $parent->id;
        $item->save();
        $documents_array = $item->getDecodedDocuments();
        JavaScript::put([
            'list'=> $documents_array,
        ]);
        return view('admin.naar.nodes.experts',[
            'item' => $item,
            'parent' => $parent,
            'lang' => $lang
        ]);

    }

    public function postExpertsPage($lang,Request $request)
    {
        //return dump($request);
        $type = StaticPage::getTypeIdArray();
        $parent = StaticPage::where('type_id',$type['experts_page'])->first();
        $item = StaticPageNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
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
            //return dump($encoded_data);
        }
        else $item->documents = null;
        $item->og_title = $request->og_title;
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        return redirect()->route('edit_experts_page')->with('status','Данные о переводе успешно изменены!');

    }
}
