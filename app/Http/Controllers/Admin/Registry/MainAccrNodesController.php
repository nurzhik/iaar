<?php

namespace App\Http\Controllers\Admin\Registry;

use App\Http\Controllers\Controller;

use App\Models\MainAccr;
use App\Http\Controllers\Admin\Registry\Deqar\RenameFilesController;
use App\Models\Nodes\MainAccrNode;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MainAccrNodesController extends Controller
{
    public function create(MainAccr $parent,$lang)
    {
        $item = MainAccrNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
        if(!empty($item))
            return redirect()->back()->with('error','Выбранный язык уже существует!');
        $item = new MainAccrNode();
        return view('admin.univer.nodes.main_accr',[
            'item' => $item,
            'parent' => $parent,
            'lang' => $lang
        ]);
    }
    public function store(MainAccr $parent, $lang, Request $request)
    {
        $validator = Validator::make($request->all(), [

        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new MainAccrNode();
        $item->license = $request->license;
        $item->org_form = $request->org_form;
        $item->notation = $request->notation;
        if(isset($request->report_doc))
        {
            $reportDoc = str_replace(url('/'),'',$request->report_doc);
            if(RenameFilesController::transliterateCredential(RenameFilesController::getStandardCredentials($reportDoc))!== $reportDoc)
            {
                return redirect()->back()->with(['error' => 'в адресе документа должна содержаться латиница без пробелов!']);
            }
            $item->report_doc  = $reportDoc;
        }

        if(isset($request->decision_doc))
        {
            $decisionDoc = str_replace(url('/'),'',$request->decision_doc);
            if(RenameFilesController::transliterateCredential(RenameFilesController::getStandardCredentials($reportDoc))!== $reportDoc)
            {
                return redirect()->back()->with(['error' => 'в адресе документа должна содержаться латиница без пробелов!']);
            }

            $item->decision_doc  = $decisionDoc;
        }
        if(isset($request->committee_consist_doc))
            $item->committee_consist_doc  = str_replace(url('/'),'',$request->committee_consist_doc);
        if(isset($request->other_doc))
            $item->other_doc  = str_replace(url('/'),'',$request->other_doc);
        if($request->report_doc_lang_select === '0' ) {
            $item->report_doc_lang = $request->report_doc_lang_input;
        }else {
            $item->report_doc_lang = $request->report_doc_lang_select;
        }

        if($request->decision_doc_lang_select === '0' ) {
            $item->decision_doc_lang = $request->decision_doc_lang_input;
        }else {
            $item->decision_doc_lang = $request->decision_doc_lang_select;
        }

        if($request->committee_consist_doc_lang_select === '0' ) {
            $item->committee_consist_doc_lang = $request->committee_consist_doc_lang_input;
        }else {
            $item->committee_consist_doc_lang = $request->committee_consist_doc_lang_select;
        }
        $item->other_doc_name = $request->other_doc_name;
        $item->parent_id = $parent->id;
        $item->lang = $lang;

        $item->save();
        return redirect()->route('edit_main_accr',['item' => $parent->id,'parent' => $parent->university_id])->with('status','Данные о переводе успешно добавлены!');

    }
    public function edit (MainAccrNode $item)
    {
        $parent = MainAccr::where('id',$item->parent_id)->first();
        return view('admin.univer.nodes.main_accr',[
            'item' => $item,
            'parent' => $parent,
            'lang' => $item->lang,
        ]);
    }
    public function update(MainAccrNode $item, Request $request)
    {

        $validator = Validator::make($request->all(), [

        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item->license = $request->license;
        $item->org_form = $request->org_form;
        $item->notation = $request->notation;
        if(isset($request->report_doc))
        {
            $reportDoc = str_replace(url('/'),'',$request->report_doc);
            if(RenameFilesController::transliterateCredential(RenameFilesController::getStandardCredentials($reportDoc))!== $reportDoc)
            {
                return redirect()->back()->with(['error' => 'в адресе документа должна содержаться латиница без пробелов!']);
            }
            $item->report_doc  = $reportDoc;
        }

        if(isset($request->decision_doc))
        {
            $decisionDoc = str_replace(url('/'),'',$request->decision_doc);
            if(RenameFilesController::transliterateCredential(RenameFilesController::getStandardCredentials($reportDoc))!== $reportDoc)
            {
                return redirect()->back()->with(['error' => 'в адресе документа должна содержаться латиница без пробелов!']);
            }

            $item->decision_doc  = $decisionDoc;
        }
        if(isset($request->committee_consist_doc))
            $item->committee_consist_doc  = str_replace(url('/'),'',$request->committee_consist_doc);
        if($request->report_doc_lang_select === '0' ) {
            $item->report_doc_lang = $request->report_doc_lang_input;
        }else {
            $item->report_doc_lang = $request->report_doc_lang_select;
        }

        if($request->decision_doc_lang_select === '0' ) {
            $item->decision_doc_lang = $request->decision_doc_lang_input;
        }else {
            $item->decision_doc_lang = $request->decision_doc_lang_select;
        }

        if($request->committee_consist_doc_lang_select === '0' ) {
            $item->committee_consist_doc_lang = $request->committee_consist_doc_lang_input;
        }else {
            $item->committee_consist_doc_lang = $request->committee_consist_doc_lang_select;
        }
        $item->other_doc_name = $request->other_doc_name;
        $item->save();
        $parent = MainAccr::where('id',$item->parent_id)->first();
        return redirect()->route('edit_main_accr',['item' => $parent->id,'parent' => $parent->university_id])->with('status','Данные о переводе успешно добавлены!');


    }
    public function delete(MainAccrNode $item)
    {
        $item->delete();
        return redirect()->back()->with('status','Данные об аккредитации успешно удалены!');
    }


}
