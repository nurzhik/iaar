<?php

namespace App\Http\Controllers\Admin\Naar;

use App\Http\Controllers\Controller;


use App\Models\StaticPage;
use App\Models\TeamMember;

use App\Models\Nodes\StaticPageNode;
use App\Models\Nodes\TeamMemberNode;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
class TeamNodesController extends Controller
{

    public function index($lang)
    {
        $type = StaticPage::getTypeIdArray();
        $parent = StaticPage::where('type_id',$type['team_members'])
            ->first();
        $item = StaticPageNode::where('parent_id',$parent->id)->where('lang',$lang)->firstOrCreate([]);
        $item->lang = $lang;
        $item->parent_id = $parent->id;
        $item->save();
        $documents_array = $item->getDecodedDocuments();
        JavaScript::put([
            'list'=> $documents_array,
        ]);
        return view('admin.naar.team.nodes.index',[
            'item' => $item,
            'parent' => $parent,
            'lang' => $lang
        ]);
    }

    public function update($lang,Request $request)
    {
        $type = StaticPage::getTypeIdArray();
        $parent = StaticPage::where('type_id',$type['team_members'])->first();
        $item = StaticPageNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item->title = $request->title;
       // $item->content = str_replace(url('/'),'',$request->text);
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
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        return redirect()->route('edit_team_page')->with('status','Перевод успешно сохранен!');

    }

    public function createMember(TeamMember $parent, $lang)
    {
        $item = TeamMemberNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
        if(!empty($item))
            return redirect()->back()->with('error','Выбранный язык уже существует!');
        $item = new TeamMemberNode();
        return view('admin.naar.team.nodes.team_member',[
            'item' => $item,
            'lang' => $lang,
            'parent' => $parent

        ]);
    }

    public function storeMember(TeamMember $parent, $lang,Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new TeamMemberNode();
        $item->name = $request->name;
        $item->job = $request->job;
        $item->sort_order= $request->sort_order;
        $item->education = $request->education;
        $item->languages = $request->language;
        $item->qualities = $request->qualities;
        $item->experience = $request->experience;
        $item->lang = $lang;
        $item->parent_id = $parent->id;
        $item->save();
        return redirect()->route('edit_team_member',['item' => $parent->id])->with('status','Новый перевод успешно создан!');

    }

    public function editMember(TeamMemberNode $item)
    {
        $lang = $item->lang;
        $parent = TeamMember::where('id',$item->parent_id)->first();
        return view('admin.naar.team.nodes.team_member',[
            'item' => $item,
            'lang' => $lang,
            'parent' => $parent
        ]);

    }
    public function updateMember(TeamMemberNode $item, Request $request)
    {
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
        $item->save();
        $parent = TeamMember::where('id',$item->parent_id)->first();
        return redirect()->route('edit_team_member',['item' => $parent->id])->with('status','Новый перевод успешно создан!');
    }
    public function deleteMember(TeamMemberNode $item)
    {
        $item->delete();
        return redirect()->back()->with('status','Запись удалена!');
    }
}
