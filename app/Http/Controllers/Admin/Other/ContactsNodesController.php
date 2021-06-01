<?php

namespace App\Http\Controllers\Admin\Other;

use App\Http\Controllers\Controller;
use App\Models\Contacts;
use App\Models\Nodes\ContactsNode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class ContactsNodesController extends Controller
{
    public function edit($lang)
    {
        $parent = Contacts::where('id','>',0)->first();
        $item = ContactsNode::where('parent_id',$parent->id)->where('lang',$lang)->firstOrCreate([]);
        $item->parent_id = $parent->id;
        $item->lang = $lang;
        $item->save();
        return view('admin.other.nodes.contacts',[
            'item' => $item,
            'lang' => $lang,
            'parent' => $parent
        ]);
    }
    public function update($lang,Request $request)
    {
        $validator = Validator::make($request->all(), [
            "address"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $parent = Contacts::where('id','>',0)->first();
        $item =  ContactsNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
        $item->address = $request->address;
        $item->map_code = $request->map_code;
        $item->content =  str_replace(url('/'),'',$request->text);
        $item->save();
        return redirect()->route('edit_contacts')->with('status','Данные о переводе успешно изменены!');

    }

}
