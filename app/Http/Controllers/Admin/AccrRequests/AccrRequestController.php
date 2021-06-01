<?php

namespace App\Http\Controllers\Admin\AccrRequests;

use App\Http\Controllers\Controller;
use App\Models\AccrRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class AccrRequestController extends Controller
{

    public function index()
    {
        $items = AccrRequest::orderBy('id','desc')->get();
        return view('admin.accr_requests.requests',[
            'items' => $items
        ]);
    }
    public function edit(AccrRequest $item)
    {
        return view('admin.accr_requests.request',[
            'item' => $item
        ]);
    }
    public function update(AccrRequest $item, Request $request)
    {
        isset($item->viewed) ? $item->viewed = true : $item->viewed = false;
        $item->save();
        return redirect()->back();
    }
    public function delete(AccrRequest $item)
    {   
        $item->delete();
        Return redirect()->back()->with('status','Данные о заявку успешно удалены!');
    }
}
