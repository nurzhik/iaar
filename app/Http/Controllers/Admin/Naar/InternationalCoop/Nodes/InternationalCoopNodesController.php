<?php

namespace App\Http\Controllers\Admin\Naar\InternationalCoop\Nodes;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use App\Models\TeamMember;
use App\Models\Nodes\StaticPageNode;
use App\Models\Nodes\TeamMemberNode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class InternationalCoopNodesController extends Controller
{

    public function editNode($slug,$lang)
    {
        $type = StaticPage::getTypeIdArray();
        $type_id  = $type[$slug];
        if(!in_array($type_id,[19,20,21,22,23]))
            return redirect()->back()->with('error','Неверный тип страницы!');
        $parent = StaticPage::where('type_id',$type_id)->first();
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
            'list_tab' => $add_document_array
        ]);

        return view('admin.naar.intern_coop.nodes.'.$slug,[
            'item' => $item,
            'lang' => $lang
        ]);

    }

    public function updateNode($slug,$lang, Request $request)
    {
        $type = StaticPage::getTypeIdArray();
        $type_id  = $type[$slug];
        if(!in_array($type_id,[19,20,21,22,23]))
            return redirect()->back()->with('error','Неверный тип страницы!');
        switch($type_id)
        {
            case(19):
                return $this->updateHiddenPageNode($lang, $request);
                break;
            case(20):
                return $this->updateIntNetworkPageNode($lang,$request);
                break;
            case(21):
                return $this->updateIntPartnersPageNode($lang, $request);
                break;
            case(22):
                return $this->updateIntProjectsPageNode($lang, $request);
                break;
            case(23):
                return $this->updateIntEventsPageNode($lang, $request);
                break;
            default:
                return redirect()->back()->with('error','Произошло нечто странное');
                break;
        }

    }
    private function updateHiddenPageNode($lang, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $parent = StaticPage::where('type_id',19)->first();
        $item  = StaticPageNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
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

        if(isset($request->contact_face_name))
        {
            $team_member = TeamMember::where('page_id',$parent->id)->first();
            if(empty($team_member))
            {
                $team_member = new TeamMember();
                $team_member->page_id = $parent->id;
                $team_member->save();
            }
            $member_node = $team_member->nodes()->where('parent_id',$team_member->id)->where('lang',$lang)->firstOrCreate([]);
            $member_node->name = $request->contact_face_name;
            $member_node->lang = $lang;
            $member_node->save();
        }

        $item->og_title = $request->og_title;
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        return redirect()->route('edit_int_page',['slug' => 'intern_cooperation_hidden'])->with('status','Данные о переводе успешно сохранены!');
    }

    private function updateIntNetworkPageNode($lang, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $parent = StaticPage::where('type_id',20)->first();
        $item  = StaticPageNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
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
            $encoded_data = StaticPage::encodeTabs($request->add_documents);
            if($encoded_data)
                $item->additional_documents = $encoded_data;
            else
                return redirect()->back()->with(['error' => 'Неверный формат прикрепленных документов']);
        }
        else $item->additional_documents = null;

        if(isset($request->contact_face_name))
        {
            $team_member = TeamMember::where('page_id',$parent->id)->first();
            if(empty($team_member))
            {
                $team_member = new TeamMember();
                $team_member->page_id = $parent->id;
                $team_member->save();
            }
            $member_node = $team_member->nodes()->where('parent_id',$team_member->id)->where('lang',$lang)->firstOrCreate([]);
            $member_node->name = $request->contact_face_name;
            $member_node->lang = $lang;
            $member_node->save();
        }

        $item->og_title = $request->og_title;
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        return redirect()->route('edit_int_page',['slug' => 'intern_networks'])->with('status','Данные о переводе успешно сохранены!');

    }
    private function updateIntPartnersPageNode($lang, Request $request)
    {

        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $parent = StaticPage::where('type_id',21)->first();
        $item  = StaticPageNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
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
            $encoded_data = StaticPage::encodePartners($request->add_documents);
            if($encoded_data)
                $item->additional_documents = $encoded_data;
            else
                return redirect()->back()->with(['error' => 'Неверный формат прикрепленных документов']);
        }
        else $item->additional_documents = null;

        if(isset($request->contact_face_name))
        {
            $team_member = TeamMember::where('page_id',$parent->id)->first();
            if(empty($team_member))
            {
                $team_member = new TeamMember();
                $team_member->page_id = $parent->id;
                $team_member->save();
            }
            $member_node = $team_member->nodes()->where('parent_id',$team_member->id)->where('lang',$lang)->firstOrCreate([]);
            $member_node->name = $request->contact_face_name;
            $member_node->lang = $lang;
            $member_node->save();
        }

        $item->og_title = $request->og_title;

        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        return redirect()->route('edit_int_page',['slug' => 'intern_partners'])->with('status','Данные о переводе успешно сохранены!');
    }
    private function updateIntProjectsPageNode($lang, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $parent = StaticPage::where('type_id',22)->first();
        $item  = StaticPageNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
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
            $encoded_data = StaticPage::encodeTabs($request->add_documents);
            if($encoded_data)
                $item->additional_documents = $encoded_data;
            else
                return redirect()->back()->with(['error' => 'Неверный формат прикрепленных документов']);
        }
        else $item->additional_documents = null;

        if(isset($request->contact_face_name))
        {
            $team_member = TeamMember::where('page_id',$parent->id)->first();
            if(empty($team_member))
            {
                $team_member = new TeamMember();
                $team_member->page_id = $parent->id;
                $team_member->save();
            }
            $member_node = $team_member->nodes()->where('parent_id',$team_member->id)->where('lang',$lang)->firstOrCreate([]);
            $member_node->name = $request->contact_face_name;
            $member_node->lang = $lang;
            $member_node->save();
        }


        $item->og_title = $request->og_title;
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        return redirect()->route('edit_int_page',['slug' => 'intern_projects'])->with('status','Данные о переводе успешно сохранены!');

    }
    private  function updateIntEventsPageNode($lang, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $parent = StaticPage::where('type_id',23)->first();
        $item  = StaticPageNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
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

        if(isset($request->contact_face_name))
        {
            $team_member = TeamMember::where('page_id',$parent->id)->first();
            if(empty($team_member))
            {
                $team_member = new TeamMember();
                $team_member->page_id = $parent->id;
                $team_member->save();
            }
            $member_node = $team_member->nodes()->where('parent_id',$team_member->id)->where('lang',$lang)->firstOrCreate([]);
            $member_node->name = $request->contact_face_name;
            $member_node->lang = $lang;
            $member_node->save();
        }
        $item->og_title = $request->og_title;
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        return redirect()->route('edit_int_page',['slug' => 'intern_events'])->with('status','Данные о переводе успешно сохранены!');

    }

}
