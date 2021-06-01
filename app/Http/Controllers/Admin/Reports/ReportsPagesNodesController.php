<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use App\Models\TeamMember;
use App\Models\Nodes\StaticPageNode;
use App\Models\Nodes\TeamMemberNode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class ReportsPagesNodesController extends Controller
{

    public function editNode(int $type, $lang)
    {
        if(!in_array($type,[11,12,13,14,15,16,17,29]))
            return redirect()->back()->with('error','Неверный тип страницы!');
        $ar = array_flip(StaticPage::getTypeIdArray());
        $parent = StaticPage::where('type_id',$type)->first();
        $item = StaticPageNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
        if(empty($item))
        {
            $item = new StaticPageNode();
            $item->lang = $lang;
            $item->parent_id = $parent->id;
            $item->save();
        }
        $documents_array = $item->getDecodedDocuments();
        $add_documents_array = $item->getDecodedAddDocuments();
        JavaScript::put([
            'list'=> $documents_array,
            'list_add'=> $add_documents_array,
        ]);
        return view('admin.reports.nodes.'.$ar[$type],[
            'item' => $item,
            'lang' => $lang
        ]);

    }

    public function updateNode($type,$lang, Request $request)
    {
        if(!in_array($type,[11,12,13,14,15,16,17,29]))
            return redirect()->back()->with('error','Неверный тип страницы!');
        switch($type)
        {
            case 11:
                return $this->updateNaarYearPageNode($type,$lang,$request);
                break;
            case 12:
                return $this->updateNaarAnaliticPageNode($type,$lang,$request);
                break;
            case 13:
                return $this->updateJournalArchivePageNode($type,$lang,$request);
                break;
            case 14:
                return $this->updateNaarPublicationsPageNode($type,$lang, $request);
                break;
            case 15:
                return $this->updateVideoArchivePageNode($type,$lang,$request);
                break;
            case 16:
                return $this->updateSmiPageNode($type,$lang,$request);
                break;
            case 17:
                return $this->updateStudentsPageNode($type,$lang,$request);
                break;
            case 29:
                return $this->updateJournalsAboutPageNode($type,$lang,$request);
                break;
            default:
                return redirect()->back();
        }

    }

    private function updateNaarYearPageNode(int $type, $lang, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $parent = StaticPage::where('type_id', $type)->first();
        $item = StaticPageNode::where('parent_id',$parent->id)
            ->where('lang',$lang)->first();

        if(empty($item))
        {
            $item = new StaticPageNode();
            $item->parent_id = $parent->id;
            $item->lang = $lang;
            $item->save();
        }

        $item->title = $request->title;

        $item->content = str_replace(url('/'),'',$request->text);
        $item->og_title = $request->og_title;

        if(isset($request->documents))
        {
            $encoded_data = StaticPage::encodeDocuments($request->documents);
            if($encoded_data)
                $item->documents = $encoded_data;
            else
                return redirect()->back()->with(['error' => 'Неверный формат прикрепленных документов']);
        }
        else $item->documents = null;
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        return redirect()->route('edit_reports_page',['type' => $type])->with('status','Данные о переводе успешно изменены');


    }
    private function updateNaarAnaliticPageNode(int $type, $lang, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $parent = StaticPage::where('type_id', $type)->first();
        $item = StaticPageNode::where('parent_id',$parent->id)
            ->where('lang',$lang)->first();

        if(empty($item))
        {
            $item = new StaticPageNode();
            $item->parent_id = $parent->id;
            $item->lang = $lang;
            $item->save();
        }
        if(isset($request->documents))
        {
            $encoded_data = StaticPage::encodeDocuments($request->documents);
            if($encoded_data)
                $item->documents = $encoded_data;
            else
                return redirect()->back()->with(['error' => 'Неверный формат прикрепленных документов']);
        }
        else $item->documents = null;
        $item->title = $request->title;

        $item->content = str_replace(url('/'),'',$request->text);
        $item->og_title = $request->og_title;

        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        return redirect()->route('edit_reports_page',['type' => $type])->with('status','Данные о переводе успешно изменены');

    }
    private function updateJournalArchivePageNode(int $type, $lang, Request $request)
    {

        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $parent = StaticPage::where('type_id', $type)->first();
        $item = StaticPageNode::where('parent_id',$parent->id)
            ->where('lang',$lang)->first();

        if(empty($item))
        {
            $item = new StaticPageNode();
            $item->parent_id = $parent->id;
            $item->lang = $lang;
            $item->save();
        }
        $item->title = $request->title;

        $item->content = str_replace(url('/'),'',$request->text);
        $item->og_title = $request->og_title;

        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        return redirect()->route('edit_reports_page',['type' => $type])->with('status','Данные о переводе успешно изменены');
    }


    private function updateJournalsAboutPageNode(int $type, $lang, Request $request)
    {

        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $parent = StaticPage::where('type_id', $type)->first();
        $item = StaticPageNode::where('parent_id',$parent->id)
            ->where('lang',$lang)->first();

        if(empty($item))
        {
            $item = new StaticPageNode();
            $item->parent_id = $parent->id;
            $item->lang = $lang;
            $item->save();
        }
        $item->title = $request->title;

        $item->content = str_replace(url('/'),'',$request->text);
        $item->og_title = $request->og_title;

        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        return redirect()->route('edit_reports_page',['type' => $type])->with('status','Данные о переводе успешно изменены');
    }


    private function updateNaarPublicationsPageNode(int $type, $lang, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $parent = StaticPage::where('type_id', $type)->first();
        $item = StaticPageNode::where('parent_id',$parent->id)
            ->where('lang',$lang)->first();

        if(empty($item))
        {
            $item = new StaticPageNode();
            $item->parent_id = $parent->id;
            $item->lang = $lang;
            $item->save();
        }
       
        $item->title = $request->title;
        // $item->slug = $request->slug;
        // $item->main_image = $request->main_image;
        $item->content = str_replace(url('/'),'',$request->text);
        $item->og_title = $request->og_title;
        if(isset($request->og_img))
            $item->og_img  = str_replace(url('/'),'',$request->og_img);
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        return redirect()->route('edit_reports_page',['type' => $type])->with('status','Данные о переводе успешно изменены');

    }
    private function updateVideoArchivePageNode(int $type,$lang,  Request $request)
    {

        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $parent = StaticPage::where('type_id', $type)->first();
        $item = StaticPageNode::where('parent_id',$parent->id)
            ->where('lang',$lang)->first();

        if(empty($item))
        {
            $item = new StaticPageNode();
            $item->parent_id = $parent->id;
            $item->lang = $lang;
            $item->save();
        }
        $item->title = $request->title;

        $item->content = str_replace(url('/'),'',$request->text);
        $item->og_title = $request->og_title;

        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        return redirect()->route('edit_reports_page',['type' => $type])->with('status','Данные о переводе успешно изменены');
    }
    private function updateSmiPageNode(int $type, $lang, Request $request)
    {

        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $parent = StaticPage::where('type_id', $type)->first();
        $item = StaticPageNode::where('parent_id',$parent->id)
            ->where('lang',$lang)->first();

        if(empty($item))
        {
            $item = new StaticPageNode();
            $item->parent_id = $parent->id;
            $item->lang = $lang;
            $item->save();
        }
        $item->title = $request->title;

        $item->content = str_replace(url('/'),'',$request->text);
        $item->og_title = $request->og_title;

        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
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
        $item->save();
        return redirect()->route('edit_reports_page',['type' => $type])->with('status','Данные о переводе успешно изменены');
    }
    private function updateStudentsPageNode(int $type, $lang, Request $request)
    {

        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $parent = StaticPage::where('type_id', $type)->first();
        $item = StaticPageNode::where('parent_id',$parent->id)
            ->where('lang',$lang)->first();

        if(empty($item))
        {
            $item = new StaticPageNode();
            $item->parent_id = $parent->id;
            $item->lang = $lang;
            $item->save();
        }
        $item->title = $request->title;
        //$item->slug = $request->slug;

        $item->content = str_replace(url('/'),'',$request->text);
        $item->og_title = $request->og_title;

        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        if(isset($request->documents))
        {
            $encoded_data = StaticPage::encodeDocuments($request->documents);
            if($encoded_data)
                $item->documents = $encoded_data;
            else
                return redirect()->back()->with(['error' => 'Неверный формат прикрепленных документов']);
        }
        else $item->documents = null;
        $item->save();
        return redirect()->route('edit_reports_page',['type' => $type])->with('status','Данные о переводе успешно изменены');
    }


}
