<?php

namespace App\Http\Controllers\Admin\Other;

use App\Http\Controllers\Controller;
use App\Models\Contacts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class ContactsController extends Controller
{

    public function edit()
    {
        $item = Contacts::where('id','>',0)->firstOrCreate([]);
        return view('admin.other.contacts',[
            'item' => $item,
        ]);
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "address"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = Contacts::where('id','>',0)->first();
        $item->address = $request->address;
        $item->phone_1 = $request->phone_1;
        $item->phone_2 = $request->phone_2;
        $item->fax = $request->fax;
        $item->email = $request->email;
        $item->map_code = $request->map_code;
        $item->site = $request->site;
        $item->fb_link = $request->fb_link;
        $item->youtube_link = $request->youtube_link;
        $item->content =  str_replace(url('/'),'',$request->text);
        $item->save();
        return redirect()->back()->with('status','Данные о контактах успешно изменены!');

    }

}
