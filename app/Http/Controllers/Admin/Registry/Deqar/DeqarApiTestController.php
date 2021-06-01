<?php

namespace App\Http\Controllers\Admin\Registry\Deqar;

use App\Http\Controllers\Controller;
use App\Models\ProgramAccr;
use App\Models\Univer;
use App\Models\MainAccr;
use App\Models\ExtReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Service\DeqarApiService;
use GuzzleHttp\Client;
use JavaScript;

class DeqarApiTestController extends Controller
{
    protected $service;

    public function __construct(DeqarApiService $service)
    {
        $this->service = $service;
    }

    public function auth()
    {
        $accr = MainAccr::first();
        return $this->service->sendInstitutionalReport($accr);
    }

    public function sendMainAccrReport($accr)
    {
        $result = $this->service->sendInstitutionalReport($accr);
        return redirect()->back()->with('status',$result);
    }

    public function sendProgramAccrReport($accr)
    {   

        $result = $this->service->sendProgramReport($accr);
        return redirect()->back()->with('status',$result);
    }

    public function sendAllNonSentReports()
    {
        $result = $this->service->sendAllNonSentReports();
        //dd($result);
         $items = Univer::where('id','>',0)->get();
        // dd($result);
        return view('admin.univer.index',[
            'result' => $result,
            'items' =>$items
        ]);
       // return redirect()->back()->with('status',$result);
    }
    public function sendAllNonSentInstituitionReports()
    {
        $result = $this->service->sendAllNonSentInstituitionReports();
         $items = Univer::where('id','>',0)->get();
          $countUniver = MainAccr::where('allow_deqar_sending', true)
            ->where('deqar_sent_status', '<=', 0)
            ->count();
        $countProgram = ProgramAccr::where('allow_deqar_sending', true)
            ->where('deqar_sent_status', '<=',0)
            ->count()
        ;
        // dd($result);
        return view('admin.univer.index',[
            'result' => $result,
            'items' =>$items,
            'countUniver'=>$countUniver,
            'countProgram'=>$countProgram
        ]);
       //return redirect()->back()->with('status',$result);
    }
    public function sendAllNonSentProgrammReports()
    {
        $result = $this->service->sendAllNonSentProgrammReports();
         $items = Univer::where('id','>',0)->get();
        // dd($result);
         $countUniver = MainAccr::where('allow_deqar_sending', true)
            ->where('deqar_sent_status', '<=', 0)
            ->count();
        $countProgram = ProgramAccr::where('allow_deqar_sending', true)
            ->where('deqar_sent_status', '<=',0)
            ->count()
        ;
        return view('admin.univer.index',[
            'result' => $result,
            'items' =>$items,
            'countUniver'=>$countUniver,
            'countProgram'=>$countProgram
        ]);
       //return redirect()->back()->with('status',$result);
    }
}
