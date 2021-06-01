<?php

namespace App\Service;

use GuzzleHttp\Client;
use App\Models\MainAccr;
use App\Models\Univer;
use App\Models\ProgramAccr;
use App\Models\Deqar\DeqarAccrType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Admin\Registry\Deqar\RenameFilesController;
use App\File;
class DeqarApiService
{

    protected $token;
    protected $client;
    protected const AGENCY_NAME = 'iaar';
    protected const DOC_LANG_EN = 'Анг';
    protected const DOC_LANG_RU = 'Рус';
    protected const APP_ADDRESS = 'https://www.iaar.agency';

    protected const EDUCATIONAL_VALUES = [
        1 =>'Bachelor',
        2 =>'Specialist',
        3 =>'Master',
        4 =>'PhD',
        5 =>'Post-graduate',
        6 =>'Residency',
        7 =>'MBA',
        8 =>'DBA',
        9 =>'Technical & Vocational Education',
        10 => 'Post-Secondary Education'

    ];

    protected const QF_LEVELS = [
        0 => 'short',
        1 => 'first',
        2 => 'second',
        3 => 'third'
    ];
    protected const NQF_LEVELS =   [
        0=> '5',
        1=> '6',
        2=> '7',
        3=> '8',
        4=> '9',
        5=> 'Other',
    ];
    public function __construct(Client $client)
    {
        $this->client = $client;
        $request      = $client->request(
            'POST',
            'https://backend.deqar.eu/accounts/get_token/',
            [
                'json' => [
                    'username' => 'iaar',
                    'password' => 'Matrixkz2030',
                ],
            ]
        );
        $this->token  = 'ed6ecc6dfd50407e3bdbd883323b9793a49611cd';
    }

    public function sendInstitutionalReport($accr)
    {
        $accr       = MainAccr::findOrFail($accr);

        $accrTypeId = data_get($accr, 'deqar_type_id');
        $accrType   = DeqarAccrType::find($accrTypeId);
        if(empty($accrType))
        {
            return 'провалено - не заполнен тип программы';
        }
        $univer = Univer::find($accr->university_id);

        if(empty($univer))
        {
            return 'провалено - нет универа';
        }
        $univerId = $univer->deqar_univer_id;
        if (!strlen($univerId)) {
            return 'не заполнен deqar id университета!';
        }
        $accrNode = $accr->nodes()->where('lang','en')->first();
        if(empty($accrNode))
        {
            return 'Не заполнены документы на английском языке!';
        }

        $reportDocs = [];
       // dd($accrNode);
        $reportDoc = data_get($accrNode, 'report_doc');
        if ($reportDoc) {
            //$lang = 'en';
             $lang = $accrNode->report_doc_lang;
              if(empty($lang)) {
                 return 'Не заполнены поле язык файл Отчета ВЭК на английском языке!';
            }

            $reportDocs[] = [
                'original_location' => self::APP_ADDRESS . $reportDoc,
                'display_name' => 'External Review Report',
                "report_language" => [
                    $lang,
                ],
            ];
        } else {
            return 'Не заполнены файл Отчета ВЭК на английском языке!';
        }

        $decisionDoc = data_get($accrNode, 'decision_doc');

        if ($decisionDoc) {
           // $lang = 'en';
           $lang = $accrNode->decision_doc_lang;
            if(empty($lang)) {
                 return 'Не заполнены поле файл решения аккредитационного совета на английском языке!';
            }
            $reportDocs[] = [
                'original_location' => self::APP_ADDRESS . $decisionDoc,
                'display_name' => 'Decision',
                "report_language" => [
                    $lang,
                ],
            ];
        } else {
            return 'Не заполнены файл решения аккредитационного совета на английском языке!';
        }

        $status   = data_get($accr, 'deqar_status_id')
            ? 'part of obligatory EQA system'
            : 'voluntary';
        $decision = data_get($accr, 'years', 0) < 5
            ? 'positive with conditions or restrictions'
            : 'positive';
        $sendData = [
            'agency'       => self::AGENCY_NAME,
            'activity'     => $accrType->value,//
            'status'       => $status,
            'decision'     => $decision,
            'local_identifier' => $accr->id.'MAIN',
            'valid_from'   => Carbon
                ::parse($accr->date_start)
                ->format('Y-m-d'),
            'valid_to'     => Carbon
                ::parse($accr->date_end)
                ->format('Y-m-d'),
            'date_format'  => "%Y-%m-%d",
            'report_files' => [],
           'report_links' => [ ['link'=>'https://iaar.agency/registry/univer/'.$accr->university_id.'/en']],
            'institutions' => [
                [
                    'deqar_id' => $univerId // ???
                ],
            ],
        ];
        if (count($reportDocs)) {
            $sendData['report_files'] = $reportDocs;
        }
       
        try {
            $response = $this->client->request(
                'POST',
                'https://backend.deqar.eu/submissionapi/v1/submit/report',
                [
                    'headers' =>
                        [
                            'Authorization' => "Bearer {$this->token}",
                        ],
                    'json'    => [ $sendData ],
                ]
            );
            //записать в базу флаг что отправлено, записать дату отправки   Отключили покамесь
            $accr->deqar_sent_status = 1;
            $accr->deqar_send_date = Carbon::now()->addHours(6)->toDateTimeString();
            $accr->save();

            return 'Успешно!';
        } catch (\Throwable $e) {
            //dd($e);
//            $body = $e->getResponse()
//                      ->getBody()
//            ;
//            while (!$body->eof()) {
//                echo $body->read(1024);
//            }
             Log::error(
                $e->getResponse()
                  ->getBody()
                  ->getContents() . 'main_accr -' . $accr->id
            );
             $exception = (string) $e->getResponse()->getBody();
            $exception = json_decode($exception);
          
         
           $error = json_encode($exception[0]->errors);

            
           // print(
           //     $e
           // );
            return $error;
        }
    }

    public function sendProgramReport($accr)
    {
        $accr       = ProgramAccr::findOrFail($accr);
        $accrTypeId = data_get($accr, 'deqar_type_id');
        $accrType   = DeqarAccrType::find($accrTypeId);
        if(empty($accrType))
        {
            return 'провалено - не заполнен тип программы';
        }
        $univer = Univer::find($accr->university_id);

        if(empty($univer))
        {
            return 'провалено - нет универа';
        }
        $univerId = $univer->deqar_univer_id;
      
        if (!strlen($univerId)) {
            return 'не заполнен deqar id университета!';
        }
        $accrNode = $accr->nodes()->where('lang','en')->first();
        
        if(empty($accrNode))
        {
            return 'Не заполнены документы на английском языке!';
        }
        $reportDoc = data_get($accrNode, 'report_doc');
        $reportDocFormat =pathinfo($reportDoc, PATHINFO_EXTENSION);
        
        if ($reportDoc) {
            //$lang = 'en';
            $lang = $accrNode->report_doc_lang;

            if(empty($lang)) {
                 return 'Не заполнены поле язык файл Отчета ВЭК на английском языке!';
            }

            if(RenameFilesController::transliterateCredential(RenameFilesController::getStandardCredentials($reportDoc))!== $reportDoc)
            {
                return 'в адресе документа должна содержаться латиница без пробелов!';
            }
            $reportDocs[] = [
                'original_location' => self::APP_ADDRESS . $reportDoc,
                'display_name' => 'External Review Report',
                "report_language" => [
                    $lang,
                ],
            ];
        } else {
            return 'Не заполнены файл Отчета ВЭК на английском языке!';
        }
         

        $decisionDoc = data_get($accrNode, 'decision_doc');
        $decisionDocFormat =pathinfo($decisionDoc, PATHINFO_EXTENSION);
      
        if ($decisionDoc) {
            //$lang = 'en';
            $lang = $accrNode->decision_doc_lang;
            if(empty( $lang)) {
                 return 'Не заполнены поле файл решения аккредитационного совета на английском языке!';
            }
            if(RenameFilesController::transliterateCredential(RenameFilesController::getStandardCredentials($decisionDoc))!== $decisionDoc)
            {
                return  'в адресе документа должна содержаться латиница без пробелов!';
            }
            $reportDocs[] = [
                'original_location' => self::APP_ADDRESS . $decisionDoc,
                'display_name' => 'Decision',
                "report_language" => [
                    $lang,
                ],
            ];
        } else {
            return 'Не заполнены файл решения аккредитационного совета на английском языке!';
        }
        

        $status       = data_get($accr, 'deqar_status_id')
            ? 'part of obligatory EQA system'
            : 'voluntary';
        $negative = data_get($accr, 'deqar_negative_decision');

        if($negative  == 1) {
            $decision = 'negative';
        }else {
             $decision     = data_get($accr, 'years', 0) < 5
            ? 'positive with conditions or restrictions'
            : 'positive';
        }

        $qf = data_get(self::QF_LEVELS,(int)data_get($accr,'qf',0),'other');

         $nqf = data_get(self::NQF_LEVELS,(int)data_get($accr,'nqf'),'other');
         
        if($qf!== 'other')
        {
            $qf.=' cycle';
        }

        $programmes   = [];

        if($accr->educational_id == 0) {
            $programmes[] = [
                'identifiers'           => [['identifier' =>  (string)$accr->id ]],
                "name_primary"          => $accrNode->program_title,
                "qualification_primary" => $accrNode->educational_title,
                "nqf_level"             => "level ".$nqf,
                "qf_ehea_level"         => $qf,
            ];
        }else {

            $programmes[] = [
                'identifiers'           => [['identifier' =>  (string)$accr->id ]],
                "name_primary"          => $accrNode->program_title,
                "qualification_primary" => data_get(self::EDUCATIONAL_VALUES, data_get($accr,'educational_id'),''),
                "nqf_level"             => "level ".$nqf,
                "qf_ehea_level"         => $qf,
            ];
        }


        $sendData     = [
            'agency'       => self::AGENCY_NAME,
            'activity'     => $accrType->value,//
            'status'       => $status,
            'decision'     => $decision,
            'local_identifier' => $accr->id.'PROG',
            'valid_from'   => Carbon
                ::parse($accr->date_start)
                ->format('Y-m-d'),
            'valid_to'     => Carbon
                ::parse($accr->date_end)
                ->format('Y-m-d'),
            'date_format'  => "%Y-%m-%d",
            'programmes' => $programmes,
            'report_files' => [],
            'report_links' => [ ['link'=>'https://iaar.agency/registry/program/'.$accr->id.'/en']],
            'institutions' => [
                [
                    'deqar_id' => $univerId // ???
                ],
            ],
        ];
     //  dd($sendData);
        if (count($reportDocs)) {
            $sendData[ 'report_files' ] = $reportDocs;
        }
        // dd($sendData);
        try {
            $this->client->request(
                'POST',
                'https://backend.deqar.eu/submissionapi/v1/submit/report',
                [
                    'headers' =>
                        [
                            'Authorization' => "Bearer {$this->token}",
                        ],
                    'json'    => [ $sendData ],
                ]
            );
            //записать в базу флаг что отправлено, записать дату отправки Отключили покамесь
            $accr->deqar_sent_status = 1;
            $accr->deqar_send_date = Carbon::now()->addHours(6)->toDateTimeString();
            $accr->save();
            $reportDocmessage = '';
            $decisionDocmessage= '';
            if($reportDocFormat != 'pdf' ) {
                $reportDocmessage = "Отчета ВЭК формат документа ".' ' .$reportDocmessage;
            }
            if($decisionDocFormat !='pdf') {
                $decisionDocmessage = "Отчета ВЭК формат документа".' ' .$decisionDocFormat;
            }
            return 'Успешно!' .$reportDocmessage.' '.$decisionDocmessage;
        } catch (\Throwable $e) {
            //записать в базу флаг что не отправлено


            $body = $e->getResponse()
                      ->getBody();

//            while (!$body->eof()) {
//                echo $body->read(1024);
//            }
    
            Log::error(
                $e->getResponse()
                  ->getBody()
                  ->getContents() . 'main_accr -' . $accr->id
            );
             $exception = (string) $e->getResponse()->getBody();
            $exception = json_decode($exception);
          
         
           $error = json_encode($exception[0]->errors);

            
           // print(
           //     $e
           // );
            return $error;
        }
    }

    public function sendAllNonSentReports()
    {
        $mainAccrs     = MainAccr
            ::query()
            ->where('allow_deqar_sending', true)
            ->where('deqar_sent_status', '<=', 0)
            ->get()
        ;
        $success_count = 0;
        foreach ($mainAccrs as $accr) {
            $result = $this->sendInstitutionalReport($accr->id);
            if ($result == 'Успешно!') {
                $success_count++;
            }else{ 
             	$univer = Univer::find($accr->university_id);
                $error_messages_institutional[$univer->title][]= $result;
            }
        }
        //dd($error_messages_institutional);
        $programAccrs = ProgramAccr
            ::query()
            ->where('allow_deqar_sending', true)
            ->where('deqar_sent_status', '<=',0)
            ->get()
        ;
        foreach ($programAccrs as $accr) {
           // dd( $accr);
            $result = $this->sendProgramReport($accr->id);
    
            if (str_contains($result, 'Успешно!')) {
                $success_count++;
            }else{ 
           		$univer = Univer::find($accr->university_id);
                $error_messages_programs[$univer->title][$accr->program_title][]= $result;
            }
        }
       // dd($error_messages_programs);
         $result = [];
        $result['message']='Успешно отправлено ' . $success_count . ' аккредитаций из ' . (count($mainAccrs) + count($programAccrs));
        $result['programs']=$error_messages_programs;
        $result['institute']=$error_messages_institutional;
        return $result;
    }
    public function sendAllNonSentProgrammReports()
    {
        
        //dd($error_messages_institutional);
        $programAccrs = ProgramAccr
            ::query()
            ->where('allow_deqar_sending', true)
            ->where('deqar_sent_status', '<=',0)
            ->take(100)->get()
        ;
       $success_count = 0;
        foreach ($programAccrs as $accr) {

            $result = $this->sendProgramReport($accr->id);
    	
            
            if (str_contains($result, 'Успешно')) {
                $success_count++;
            }else{ 
           		$univer = Univer::find($accr->university_id);
                $error_messages_programs[$univer->title][$accr->program_title][]= $result;
            }
        }
       // dd($error_messages_programs);
        $result = [];
        $result['message']='Успешно отправлено ' . $success_count . ' аккредитаций из ' . (count($programAccrs));
        if(!empty($error_messages_programs)) {
    		$result['programs']=$error_messages_programs;
        }
        return $result;
    }
    public function sendAllNonSentInstituitionReports()
    {

        $mainAccrs     = MainAccr
            ::query()
            ->where('allow_deqar_sending', true)
            ->where('deqar_sent_status', '<=', 0)
            ->get()
        ;
        $success_count = 0;
        foreach ($mainAccrs as $accr) {
            $result = $this->sendInstitutionalReport($accr->id);
            if (str_contains($result, 'Успешно')) {
                $success_count++;
            }else{ 
             	$univer = Univer::find($accr->university_id);
                $error_messages_institutional[$univer->title][]= $result;
            }
        }
        //dd($error_messages_institutional);

       // dd($error_messages_programs);
        $result = [];
        $result['message']='Успешно отправлено ' . $success_count . ' аккредитаций из ' . (count($mainAccrs));
        if(!empty($error_messages_institutional)) {
	        $result['institute']=$error_messages_institutional;
	    }
        return $result;
    }
}
