<?php

namespace App\Http\Controllers\Admin\Registry;

use App\Http\Controllers\Controller;
use App\Models\Univer;
use App\Models\ProgramAccr;
use App\Models\Deqar\DeqarAccrType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Admin\Registry\Deqar\RenameFilesController;

class ProgramAccrController extends Controller
{
    public function create(Univer $parent)
    {
        $item = new ProgramAccr();
        $deqar_accr_types = DeqarAccrType::all();
        return view('admin.univer.program_accr',[
            'item' => $item,
            'deqar_accr_types' => $deqar_accr_types,
            'parent' => $parent
        ]);
    }
    public function store(Univer $parent, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "program_title"    => "required",
            "program_index"    => "required",
            "hidden_relation_id"    => "required",

        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new ProgramAccr();
        $item->program_title = $request->program_title;
        $item->program_index = $request->program_index;
        $item->date_start = $request->date_start;
        $item->date_end = $request->date_end;
        $item->years = $request->years;
        $item->hidden_relation_id = $request->hidden_relation_id;
        $item->univer_type_id = $request->univer_type_id;
        $item->visit_date_start = $request->visit_date_start;
        $item->visit_date_end = $request->visit_date_end;
        $item->bin = $request->bin;
        $item->license = $request->license;
        $item->registration_number = $request->registration_number;
        $item->org_form = $request->org_form;
        $item->notation = $request->notation;
        $item->educational_id = $request->educational_id;
        $item->educational_title = $request->educational_title;
        $item->qf = $request->qf;
        $item->nqf = $request->nqf;

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
        isset($request->ex_ante) ?  $item->ex_ante = true : $item->ex_ante = false;
        isset($request->reaccr) ?  $item->reaccr = true : $item->reaccr = false;
        isset($request->partner) ?  $item->partner = true : $item->partner = false;
        $item->university_id = $parent->id;
        if(isset($request->deqar_type_id))
        {
            $item->deqar_type_id = $request->deqar_type_id;
        }
        if(isset($request->deqar_status_id))
        {
            $item->deqar_status_id = 1;
        }
        else
        {
            $item->deqar_status_id = 0;
        }
         if(isset($request->deqar_negative_decision))
        {
            $item->deqar_negative_decision = 1;
        }
        else
        {
            $item->deqar_negative_decision = 0;
        }

        if(isset($request->allow_deqar_sending))
        {
            $item->allow_deqar_sending = (bool)$request->allow_deqar_sending;
        }
        else{
            $item->allow_deqar_sending = false;
        }
        if($request->unique_index) {
            $item->unique_index = $request->unique_index;
            $item->save();
        }else {
            $item->save();
            $lastInsertedId = $item->id;
            $item->unique_index = $lastInsertedId;
            $item->save();
        }
        return redirect()->route('edit_univer',['item' => $parent->id])->with('status','Новая программная аккредитация добавлена!');

    }
    public function edit(Univer $parent, ProgramAccr $item)
    {
        $deqar_accr_types = DeqarAccrType::all();
        if($parent->id == $item->university_id)
        return view('admin.univer.program_accr',[
            'item' => $item,
            'parent' => $parent,
            'deqar_accr_types' => $deqar_accr_types,
        ]);
        else
            return redirect()->back()->with('error','Это не родитель!');
    }
    public function update(Univer $parent, ProgramAccr $item, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "program_title"    => "required",
            "program_index"    => "required",
            "hidden_relation_id"    => "required",


        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        };
        $item->program_title = $request->program_title;
        $item->program_index = $request->program_index;
        $item->date_start = $request->date_start;
        $item->date_end = $request->date_end;
        $item->years = $request->years;
        $item->univer_type_id = $request->univer_type_id;
        $item->visit_date_start = $request->visit_date_start;
        $item->hidden_relation_id = $request->hidden_relation_id;
        $item->visit_date_end = $request->visit_date_end;
        $item->bin = $request->bin;
        $item->license = $request->license;
        $item->registration_number = $request->registration_number;
        $item->org_form = $request->org_form;
        $item->notation = $request->notation;
         $item->educational_id = $request->educational_id;
        $item->educational_title = $request->educational_title;
        $item->qf = $request->qf;
        $item->nqf = $request->nqf;
        if(isset($request->deqar_type_id))
        {
            $item->deqar_type_id = $request->deqar_type_id;
        }
        if(isset($request->deqar_status_id))
        {
            $item->deqar_status_id = 1;
        }
        else
        {
            $item->deqar_status_id = 0;
        }
         if(isset($request->deqar_negative_decision))
        {
            $item->deqar_negative_decision = 1;
        }
        else
        {
            $item->deqar_negative_decision = 0;
        }
        if(isset($request->allow_deqar_sending))
        {
            $item->allow_deqar_sending = (bool)$request->allow_deqar_sending;
        }
        else{
            $item->allow_deqar_sending = false;
        }
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
        isset($request->ex_ante) ?  $item->ex_ante = true : $item->ex_ante = false;
        isset($request->reaccr) ?  $item->reaccr = true : $item->reaccr = false;
         isset($request->partner) ?  $item->partner = true : $item->partner = false;
        $item->university_id = $parent->id;
        $item->unique_index = $request->unique_index;
        $item->save();
        return redirect()->back()->with('status','Программная аккредитация изменена!');
       //Старый редирект ) return redirect()->route('edit_univer',['item' => $parent->id])->with('status','Программная аккредитация изменена!');

    }

    public function replicate(ProgramAccr $item)
    {
        $new_model = $item->replicate();
        $new_model->push();
        $new_model->save();
        foreach($item->nodes()->get() as $node)
        {
            $new_node = $node->replicate();
            $new_node->parent_id = $new_model->id;
            $new_node->push();
            $new_node->save();
        }
        return redirect()->route('edit_program_accr',['parent' => $new_model->university_id,'item' => $new_model->id])->with('status','Программная аккредитация  склонирована!');

    }
    public function delete(ProgramAccr $item)
    {
        $item->delete();
        return redirect()->back()->with('status','Данные об аккредитации успешно удалены!');
    }


}
