<?php

namespace App\Http\Controllers\Admin\Naar\InternationalCoop;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class InternationalCoopController extends Controller
{

    public function indexPage($slug)
    {
        $type = StaticPage::getTypeIdArray();
        $type_id  = $type[$slug];
        if(!in_array($type_id,[19,20,21,22,23]))
            return redirect()->back()->with('error','Неверный тип страницы!');
        $item = StaticPage::where('type_id',$type_id)->firstOrCreate(['type_id' => $type_id]);
        $documents_array = $item->getDecodedDocuments();
        $add_document_array = $item->getDecodedAddDocuments();
        JavaScript::put([
            'list'=> $documents_array,
            'list_tab' => $add_document_array
        ]);

        return view('admin.naar.intern_coop.'.$slug,[
            'item' => $item
        ]);
    }

    public function updatePage($slug, Request $request)
    {
        $type = StaticPage::getTypeIdArray();
        $type_id  = $type[$slug];
        if(!in_array($type_id,[19,20,21,22,23]))
            return redirect()->back()->with('error','Неверный тип страницы!');
        switch($type_id)
        {
            case(19):
                return $this->updateHiddenPage($request);
                break;
            case(20):
                return $this->updateIntNetworkPage($request);
                break;
            case(21):
                return $this->updateIntPartnersPage($request);
                break;
            case(22):
                return $this->updateIntProjectsPage($request);
                break;
            case(23):
                return $this->updateIntEventsPage($request);
                break;
            default:
                return redirect()->back()->with('error','Произошло нечто странное');
                break;
        }
    }

    private function updateHiddenPage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = StaticPage::where('type_id',19)->first();
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

        if(isset($request->contact_face_name))
        {
            $team_member = TeamMember::where('page_id',$item->id)->first();
            if(empty($team_member))
            {
                $team_member = new TeamMember();
                $team_member->page_id = $item->id;
                $team_member->save();
            }
            $team_member->name = $request->contact_face_name;
            $team_member->photo = str_replace(url('/'),'',$request->contact_face_photo);
            $team_member->email = $request->contact_face_email;
            $team_member->save();
        }

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

    private function updateIntNetworkPage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = StaticPage::where('type_id',20)->first();
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
            $encoded_data = StaticPage::encodeTabs($request->add_documents);
            if($encoded_data)
                $item->additional_documents = $encoded_data;
            else
                return redirect()->back()->with(['error' => 'Неверный формат прикрепленных документов']);
        }
        else $item->additional_documents = null;

        if(isset($request->contact_face_name))
        {
            $team_member = TeamMember::where('page_id',$item->id)->first();
            if(empty($team_member))
            {
                $team_member = new TeamMember();
                $team_member->page_id = $item->id;
                $team_member->save();
            }
            $team_member->name = $request->contact_face_name;
            $team_member->photo = str_replace(url('/'),'',$request->contact_face_photo);
            $team_member->email = $request->contact_face_email;
            $team_member->save();
        }

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
    private function updateIntPartnersPage(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = StaticPage::where('type_id',21)->first();
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
            $encoded_data = StaticPage::encodePartners($request->add_documents);
            if($encoded_data)
                $item->additional_documents = $encoded_data;
            else
                return redirect()->back()->with(['error' => 'Неверный формат прикрепленных документов']);
        }
        else $item->additional_documents = null;

        if(isset($request->contact_face_name))
        {
            $team_member = TeamMember::where('page_id',$item->id)->first();
            if(empty($team_member))
            {
                $team_member = new TeamMember();
                $team_member->page_id = $item->id;
                $team_member->save();
            }
            $team_member->name = $request->contact_face_name;
            $team_member->photo = str_replace(url('/'),'',$request->contact_face_photo);
            $team_member->email = $request->contact_face_email;
            $team_member->save();
        }

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
    private function updateIntProjectsPage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = StaticPage::where('type_id',22)->first();
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
            $encoded_data = StaticPage::encodeTabs($request->add_documents);
            if($encoded_data)
                $item->additional_documents = $encoded_data;
            else
                return redirect()->back()->with(['error' => 'Неверный формат прикрепленных документов']);
        }
        else $item->additional_documents = null;

        if(isset($request->contact_face_name))
        {
            $team_member = TeamMember::where('page_id',$item->id)->first();
            if(empty($team_member))
            {
                $team_member = new TeamMember();
                $team_member->page_id = $item->id;
                $team_member->save();
            }
            $team_member->name = $request->contact_face_name;
            $team_member->photo = str_replace(url('/'),'',$request->contact_face_photo);
            $team_member->email = $request->contact_face_email;
            $team_member->save();
        }

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
    private  function updateIntEventsPage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = StaticPage::where('type_id',23)->first();
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

        if(isset($request->contact_face_name))
        {
            $team_member = TeamMember::where('page_id',$item->id)->first();
            if(empty($team_member))
            {
                $team_member = new TeamMember();
                $team_member->page_id = $item->id;
                $team_member->save();
            }
            $team_member->name = $request->contact_face_name;
            $team_member->photo = str_replace(url('/'),'',$request->contact_face_photo);
            $team_member->email = $request->contact_face_email;
            $team_member->save();
        }
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
}
