<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Facades\DB;


class ReportsPagesController extends Controller
{

    public function edit(int $type)
    {
        $ar = array_flip(StaticPage::getTypeIdArray());
        $item = StaticPage::where('type_id',$type)->firstOrCreate(['type_id'=>$type]);
        $add_documents_array = $item->getDecodedAddDocuments();
        $documents_array = $item->getDecodedDocuments();
        JavaScript::put([
            'list'=> $documents_array,
        ]);
        JavaScript::put([
            'list_add'=> $add_documents_array,
        ]);
        return view('admin.reports.'.$ar[$type],[
            'item' => $item
        ]);

    }
    public function update(int $type, Request $request)
    {
        switch($type)
        {
            case 11:
                return $this->updateNaarYearPage($type,$request);
                break;
            case 12:
                return $this->updateNaarAnaliticPage($type,$request);
                break;
            case 13:
                return $this->updateJournalArchivePage($type,$request);
                break;
            case 14:
                return $this->updateNaarPublicationsPage($type, $request);
                break;
            case 15:
                return $this->updateVideoArchivePage($type,$request);
                break;
            case 16:
                return $this->updateSmiPage($type,$request);
                break;
            case 17:
                return $this->updateStudentsPage($type,$request);
                break;
            case 29:
                return $this->updateJournalsAboutPage($type,$request);
                break;
            default:
                return redirect()->back();
        }
    }
    private function updateNaarYearPage(int $type,Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = StaticPage::where('type_id', $type)->first();
        $item->title = $request->title;
        $item->slug = $request->slug;
        $item->main_image = $request->main_image;
        $item->content = str_replace(url('/'),'',$request->text);
        if(isset($request->documents))
        {
            $encoded_data = StaticPage::encodeDocuments($request->documents);
            if($encoded_data)
                $item->documents = $encoded_data;
            else
                return redirect()->back()->with(['error' => 'Неверный формат прикрепленных документов']);
        }
        else
            $item->documents = null;
        $item->og_title = $request->og_title;
        if(isset($request->og_img))
            $item->og_img  = str_replace(url('/'),'',$request->og_img);
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        return redirect()->back()->with('status','Данные о записи успещно изменены');


    }
    private function updateNaarAnaliticPage(int $type,Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = StaticPage::where('type_id', $type)->first();
        $item->title = $request->title;
        $item->slug = $request->slug;
        $item->main_image = $request->main_image;
        $item->content = str_replace(url('/'),'',$request->text);
        $item->og_title = $request->og_title;
        if(isset($request->documents))
        {
            $encoded_data = StaticPage::encodeDocuments($request->documents);
            if($encoded_data)
                $item->documents = $encoded_data;
            else
                return redirect()->back()->with(['error' => 'Неверный формат прикрепленных документов']);
        }
        else
            $item->documents = null;
        if(isset($request->og_img))
            $item->og_img  = str_replace(url('/'),'',$request->og_img);
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        return redirect()->back()->with('status','Данные о записи успещно изменены');

    }
    private function updateJournalArchivePage(int $type, Request $request)
    {

        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = StaticPage::where('type_id', $type)->first();
        $item->title = $request->title;
        $item->slug = $request->slug;
        $item->main_image = $request->main_image;
        $item->content = str_replace(url('/'),'',$request->text);
        $item->og_title = $request->og_title;
        if(isset($request->og_img))
            $item->og_img  = str_replace(url('/'),'',$request->og_img);
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        return redirect()->back()->with('status','Данные о записи успещно изменены');
    }


    private function updateJournalsAboutPage(int $type, Request $request)
    {

        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = StaticPage::where('type_id', $type)->first();
        $item->title = $request->title;
        $item->slug = $request->slug;
        $item->main_image = $request->main_image;
        $item->content = str_replace(url('/'),'',$request->text);
        $item->og_title = $request->og_title;
        if(isset($request->og_img))
            $item->og_img  = str_replace(url('/'),'',$request->og_img);
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        return redirect()->back()->with('status','Данные о записи успещно изменены');
    }


    private function updateNaarPublicationsPage(int $type, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = StaticPage::where('type_id', $type)->first();
        $item->title = $request->title;
        $item->slug = $request->slug;
        $item->main_image = $request->main_image;
        $item->content = str_replace(url('/'),'',$request->text);
        $item->og_title = $request->og_title;
        if(isset($request->og_img))
            $item->og_img  = str_replace(url('/'),'',$request->og_img);
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        return redirect()->back()->with('status','Данные о записи успещно изменены');

    }
    private function updateVideoArchivePage(int $type, Request $request)
    {

        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = StaticPage::where('type_id', $type)->first();
        $item->title = $request->title;
        $item->slug = $request->slug;
        $item->main_image = $request->main_image;
        $item->content = str_replace(url('/'),'',$request->text);
        $item->og_title = $request->og_title;
        if(isset($request->og_img))
            $item->og_img  = str_replace(url('/'),'',$request->og_img);
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->save();
        return redirect()->back()->with('status','Данные о записи успещно изменены');
    }
    private function updateSmiPage(int $type, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = StaticPage::where('type_id', $type)->first();
        $item->title = $request->title;
        $item->slug = $request->slug;
        $item->main_image = $request->main_image;
        $item->content = str_replace(url('/'),'',$request->text);
        $item->og_title = $request->og_title;
        if(isset($request->og_img))
            $item->og_img  = str_replace(url('/'),'',$request->og_img);
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        if(isset($request->documents))
        {
            $encoded_data = StaticPage::encodeDocuments($request->documents);
            if($encoded_data)
                $item->documents = $encoded_data;
            else
                return redirect()->back()->with(['error' => 'Неверный формат прикрепленных документов']);
        }
        if(isset($request->add_documents))
        {
            $encoded_data = StaticPage::encodeAddDocuments($request->add_documents);
            if($encoded_data)
                $item->additional_documents = $encoded_data;
            else
                return redirect()->back()->with(['error' => 'Неверный формат прикрепленных документов']);
        }
        else $item->additional_documents = null;
        $item->save();
        return redirect()->back()->with('status','Данные о записи успещно изменены');
    }
    private function updateStudentsPage(int $type, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"    => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = StaticPage::where('type_id', $type)->first();
        $item->title = $request->title;
        //$item->slug = $request->slug;
        $item->main_image = $request->main_image;
        $item->content = str_replace(url('/'),'',$request->text);
        $item->og_title = $request->og_title;
        if(isset($request->og_img))
            $item->og_img  = str_replace(url('/'),'',$request->og_img);
        $item->og_description = $request->og_description;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        if(isset($request->documents))
        {
            $encoded_data = StaticPage::encodeDocuments($request->documents);
            if($encoded_data)
                $item->documents = $encoded_data;
            else
                return redirect()->back()->with(['error' => 'Неверный формат прикрепленных документов']);
        }
        else $item->documents = null;
        $item->save();
        return redirect()->back()->with('status','Данные о записи успещно изменены');
    }



}

