<?php

namespace App\Http\Controllers\Admin\Registry;

use App\Http\Controllers\Controller;

use App\Models\ProgramAccr;
use App\Models\Nodes\ProgramAccrNode;

use App\Http\Controllers\Admin\Registry\Deqar\RenameFilesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProgramAccrNodesController extends Controller
{
    public function create(ProgramAccr $parent,$lang)
    {
        $item = ProgramAccrNode::where('parent_id',$parent->id)->where('lang',$lang)->first();
        if(!empty($item))
            return redirect()->back()->with('error','Выбранный язык уже существует!');
        $item = new ProgramAccrNode();
        return view('admin.univer.nodes.program_accr',[
            'item' => $item,
            'parent' => $parent,
            'lang' => $lang
        ]);
    }
    public function store(ProgramAccr $parent,$lang, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "program_title"    => "required"
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new ProgramAccrNode();
        $item->program_title = $request->program_title;
        $item->license = $request->license;
        $item->org_form = $request->org_form;
        $item->notation = $request->notation;
        $item->educational_title = $request->educational_title;
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
            if(RenameFilesController::transliterateCredential(RenameFilesController::getStandardCredentials($decisionDoc))!== $decisionDoc)
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
        return redirect()->route('edit_program_accr',['item' => $parent->id,'parent' => $parent->university_id])->with('status','Данные о переводе успешно добавлены!');

    }
    public function edit( ProgramAccrNode $item)
    {
        $parent = ProgramAccr::where('id',$item->parent_id)->first();
        return view('admin.univer.nodes.program_accr',[
            'item' => $item,
            'parent' => $parent,
            'lang' => $item->lang,
        ]);
    }
    public function update( ProgramAccrNode $item, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "program_title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        };
        $item->program_title = $request->program_title;
        $item->license = $request->license;
        $item->org_form = $request->org_form;
        $item->notation = $request->notation;
        $item->educational_title = $request->educational_title;
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
            if(RenameFilesController::transliterateCredential(RenameFilesController::getStandardCredentials($decisionDoc))!== $decisionDoc)
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

        $item->save();
        $parent = ProgramAccr::where('id',$item->parent_id)->first();
        return redirect()->route('edit_program_accr',['item' => $parent->id,'parent' => $parent->university_id])->with('status','Данные о переводе успешно изменены!');


    }
    public function delete(ProgramAccrNode $item)
    {
        $item->delete();
        return redirect()->back()->with('status','Данные об аккредитации успешно удалены!');
    }


}
