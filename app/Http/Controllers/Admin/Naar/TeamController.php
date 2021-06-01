<?php

namespace App\Http\Controllers\Admin\Naar;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
class TeamController extends Controller
{

    public function index()
    {
        $type = StaticPage::getTypeIdArray();
        $item = StaticPage::where('type_id',$type['team_members'])
            ->firstOrCreate(['type_id' => $type['team_members']]);
        $documents_array = $item->getDecodedDocuments();
        JavaScript::put([
            'list'=> $documents_array,
        ]);
        return view('admin.naar.team.index',[
            'item' => $item
        ]);
    }

    public function update(Request $request)
    {
        $type = StaticPage::getTypeIdArray();
        $item = StaticPage::where('type_id',$type['team_members'])->first();
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
     //   $item->content = str_replace(url('/'),'',$request->text);
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
        return redirect()->back()->with('status','Данные сохранены');

    }

    public function createMember()
    {
        $type = StaticPage::getTypeIdArray();
        $page = StaticPage::where('type_id',$type['team_members'])->first();
        if(empty($page))
            return redirect()->back()->with(['error' => 'Ошибка существования']);
        $item = new TeamMember();
        return view('admin.naar.team.team_member',[
            'item' => $item,
        ]);

    }

    public function storeMember(Request $request)
    {
        $type = StaticPage::getTypeIdArray();
        $page = StaticPage::where('type_id',$type['team_members'])->first();
        if(empty($page))
            return redirect()->back()->with(['error' => 'Ошибка существования']);
        $validator = Validator::make($request->all(), [
            "name"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new TeamMember();
        $item->name = $request->name;
        $item->job = $request->job;
        $item->sort_order= $request->sort_order;
        $item->education = $request->education;
        $item->languages = $request->language;
        $item->qualities = $request->qualities;
        $item->experience = $request->experience;
        $item->phone = $request->phone;
        $item->email = $request->email;
        $item->skype = $request->skype;
        if(isset($request->photo))
            $item->photo  = str_replace(url('/'),'',$request->photo);
        $item->page_id = $page->id;
        $item->save();
        return redirect()->back()->with('status','Элемент создан!');

    }

    public function editMember(TeamMember $item)
    {
        $type = StaticPage::getTypeIdArray();
        $page = StaticPage::where('type_id',$type['team_members'])->first();
        if(empty($page))
            return redirect()->back()->with(['error' => 'Ошибка существования']);
        return view('admin.naar.team.team_member',[
            'item' => $item,
        ]);

    }
    public function updateMember(TeamMember $item, Request $request)
    {
        $type = StaticPage::getTypeIdArray();
        $page = StaticPage::where('type_id',$type['team_members'])->first();
        if(empty($page))
            return redirect()->back()->with(['error' => 'Ошибка существования']);
        $validator = Validator::make($request->all(), [
            "name"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item->name = $request->name;
        $item->job = $request->job;
        $item->sort_order= $request->sort_order;
        $item->education = $request->education;
        $item->languages = $request->language;
        $item->qualities = $request->qualities;
        $item->experience = $request->experience;
        $item->phone = $request->phone;
        $item->email = $request->email;
        $item->skype = $request->skype;
        if(isset($request->photo))
            $item->photo  = str_replace(url('/'),'',$request->photo);
        $item->page_id = $page->id;
        $item->save();
        return redirect()->back()->with('status','Элемент изменен!');
    }
    public function deleteMember(TeamMember $item)
    {
        $item->delete();
        return redirect()->back()->with('status','Запись удалена!');
    }
}
