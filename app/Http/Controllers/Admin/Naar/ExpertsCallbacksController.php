<?php

namespace App\Http\Controllers\Admin\Naar;

use App\Http\Controllers\Controller;
use App\Models\ExpertsCallback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ExpertsCallbacksController extends Controller
{

    public function index()
    {
        $items = ExpertsCallback::orderBy('created_at','DESC')->get();
        return view('admin.naar.experts_callbacks.index',[
            'items' => $items
        ]);

    }


    public function view(ExpertsCallback $item)
    {
        return view('admin.naar.experts_callbacks.view',[
            'item' => $item,
        ]);
    }

    public function delete(ExpertsCallback $item)
    {

        $item->delete();
        return redirect()->back()->with('status','Запись удалена!');
    }


}
