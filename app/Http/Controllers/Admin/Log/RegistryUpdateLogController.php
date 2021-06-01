<?php

namespace App\Http\Controllers\Admin\Log;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;
use App\Models\Logs\RegistryUpdatedLog;


class RegistryUpdateLogController extends Controller
{

    public function index()
    {
        $item = RegistryUpdatedLog::first();
        return view('admin.log.registry_updated',[
            'item' => $item,
        ]);

    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "date"    => "required|date",

        ]);
        $item = RegistryUpdatedLog::first();
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item->date  = $request->date;
        isset($request->is_blocked) ? $item->is_blocked = true : $item->is_blocked = false;
        $item->save();
        return redirect()->back()->with('status','Данные о записи успешно изменены!');

    }

}
