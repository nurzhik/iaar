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
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class RenameFilesController extends Controller
{

    protected const BASE_PATH                    = 'https://iaar.agency';
    protected const BASE_PATH_WITH_NEW_ACCR_ROOT = '/var/www/vhosts/v-4333.webspace/iaar.agency/storage/app/public/photos/shares/prog_accreditation_files/';
    protected const NEW_PATH_FOR_LINK            = '/storage/photos/shares/prog_accreditation_files/';

    public function testRename()
    {
        $items = MainAccr::all();
        foreach ($items as $item) {
            $reportDoc = data_get($item, 'report_doc');
            if (strlen($reportDoc)) {
                try {
                    $basename    = basename($reportDoc);
                    $newBasename = $this->getStandardCredentials($basename);
                    $newBasename = $this->transliterateCredential($newBasename);
                    $newBasename = 'Report-' . $newBasename;
                    $this->mycopy(
                        self::BASE_PATH . $reportDoc,
                        self::BASE_PATH_WITH_NEW_ACCR_ROOT . $item->id . '/' . $newBasename
                    );
                    $item->report_doc = self::NEW_PATH_FOR_LINK . $item->id . '/' . $newBasename;
                } catch (\Exception $e) {
                    Log::error($e->getMessage() . ' MAINACCR' . $item->id);
                }
            }
            $decisionDoc = data_get($item, 'report_doc');
            if (strlen($decisionDoc)) {
                try {
                    $basename    = basename($decisionDoc);
                    $newBasename = $this->getStandardCredentials($basename);
                    $newBasename = $this->transliterateCredential($newBasename);
                    $newBasename = 'Decision-' . $newBasename;
                    $this->mycopy(
                        self::BASE_PATH . $reportDoc,
                        self::BASE_PATH_WITH_NEW_ACCR_ROOT . $item->id . '/' . $newBasename
                    );
                    $item->decision_doc = self::NEW_PATH_FOR_LINK . $item->id . '/' . $newBasename;
                } catch (\Exception $e) {
                    Log::error($e->getMessage() . ' MAINACCR' . $item->id);
                }

            }
            $item->save();
            foreach (
                $item->nodes()
                     ->get() as $node
            ) {
                $lang      = $node->lang;
                $reportDoc = data_get($node, 'report_doc');
                if (strlen($reportDoc)) {
                    try {
                        $basename    = basename($reportDoc);
                        $newBasename = $this->getStandardCredentials($basename);
                        $newBasename = $this->transliterateCredential($newBasename);
                        $newBasename = 'Report-' . $lang . '-' . $newBasename;
                        $this->mycopy(
                            self::BASE_PATH . $reportDoc,
                            self::BASE_PATH_WITH_NEW_ACCR_ROOT . $item->id . '/' . $newBasename
                        );
                        $item->report_doc = self::NEW_PATH_FOR_LINK . $item->id . '/' . $newBasename;
                    } catch (\Exception $e) {
                        Log::error($e->getMessage() . ' MAINACCR' . $item->id);
                    }

                }
                $decisionDoc = data_get($node, 'report_doc');
                if (strlen($decisionDoc)) {
                    try {
                        $basename    = basename($decisionDoc);
                        $newBasename = $this->getStandardCredentials($basename);
                        $newBasename = $this->transliterateCredential($newBasename);
                        $newBasename = 'Decision-' . $lang . '-' . $newBasename;
                        $this->mycopy(
                            self::BASE_PATH . $reportDoc,
                            self::BASE_PATH_WITH_NEW_ACCR_ROOT . $item->id . '/' . $newBasename
                        );
                        $item->decision_doc = self::NEW_PATH_FOR_LINK . $item->id . '/' . $newBasename;
                    } catch (\Exception $e) {
                        Log::error($e->getMessage() . ' MAINACCR' . $item->id);
                    }

                }
                $node->save();
            }

        }
        return 1;

    }

    public function testRenameProgram()
    {
        return 1;
        $items = ProgramAccr::query()->skip(200*17)->take(200)->get();
        //$items = MainAccr::all();
        foreach ($items as $item) {
            $reportDoc = data_get($item, 'report_doc');
            if (strlen($reportDoc)) {
                try {
                    $basename    = basename($reportDoc);
                    $newBasename = $this->getStandardCredentials($basename);
                    $newBasename = $this->transliterateCredential($newBasename);
                    $newBasename = 'Report-' . $newBasename;
                    $this->mycopy(
                        self::BASE_PATH . $reportDoc,
                        self::BASE_PATH_WITH_NEW_ACCR_ROOT . $item->id . '/' . $newBasename
                    );
                    $item->report_doc = self::NEW_PATH_FOR_LINK . $item->id . '/' . $newBasename;
                } catch (\Exception $e) {
                    Log::error($e->getMessage() . ' PROGACCR' . $item->id);
                }
            }
            $decisionDoc = data_get($item, 'decision_doc');
            if (strlen($decisionDoc)) {
                try {
                    $basename    = basename($decisionDoc);
                    $newBasename = $this->getStandardCredentials($basename);
                    $newBasename = $this->transliterateCredential($newBasename);
                    $newBasename = 'Decision-' . $newBasename;
                    $this->mycopy(
                        self::BASE_PATH . $decisionDoc,
                        self::BASE_PATH_WITH_NEW_ACCR_ROOT . $item->id . '/' . $newBasename
                    );
                    $item->decision_doc = self::NEW_PATH_FOR_LINK . $item->id . '/' . $newBasename;
                } catch (\Exception $e) {
                    Log::error($e->getMessage() . ' PROGACCR' . $item->id);
                }

            }
            $item->save();;
            foreach (
                $item->nodes()
                     ->get() as $node
            ) {
                $lang      = $node->lang;
                $reportDoc = data_get($node, 'report_doc');
                if (strlen($reportDoc)) {
                    try {
                        $basename    = basename($reportDoc);
                        $newBasename = $this->getStandardCredentials($basename);
                        $newBasename = $this->transliterateCredential($newBasename);
                        $newBasename = 'Report-' . $lang . '-' . $newBasename;
                        $this->mycopy(
                            self::BASE_PATH . $reportDoc,
                            self::BASE_PATH_WITH_NEW_ACCR_ROOT . $item->id . '/' . $newBasename
                        );
                        $node->report_doc = self::NEW_PATH_FOR_LINK . $item->id . '/' . $newBasename;
                    } catch (\Exception $e) {
                        Log::error($e->getMessage() . ' PROGACCR' . $item->id);
                    }

                }
                $decisionDoc = data_get($node, 'decision_doc');
                if (strlen($decisionDoc)) {
                    try {
                        $basename    = basename($decisionDoc);
                        $newBasename = $this->getStandardCredentials($basename);
                        $newBasename = $this->transliterateCredential($newBasename);
                        $newBasename = 'Decision-' . $lang . '-' . $newBasename;
                        $this->mycopy(
                            self::BASE_PATH . $decisionDoc,
                            self::BASE_PATH_WITH_NEW_ACCR_ROOT . $item->id . '/' . $newBasename
                        );
                        $node->decision_doc = self::NEW_PATH_FOR_LINK . $item->id . '/' . $newBasename;
                    } catch (\Exception $e) {
                        Log::error($e->getMessage() . ' PROGACCR' . $item->id);
                    }

                }
                $node->save();
            }

        }
        return 1;

    }

    protected function mycopy($s1, $s2)
    {
        $path = pathinfo($s2);
        if (!file_exists($path[ 'dirname' ])) {
            mkdir($path[ 'dirname' ], 0777, true);
        }
        if (!copy($s1, $s2)) {
            //echo "copy failed \n";
        }
    }

    public  static function transliterateCredential($var)
    {
        $var = str_replace(' ', '_', $var);
        //$var         = preg_replace('/([аеёийоуыьэюяАЕЁИЙОУЫЬЭЮЯ])у/u', '$1w', $var);
        $symbol_list = [
            // small letters
            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'e', #fixed
            'ж' => 'zh',
            'з' => 'z',
            'и' => 'i',
            'й' => 'y', #fixed
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ф' => 'f',
            'х' => 'kh', #fixed
            'ц' => 'ts', #fixed
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'sh',
            'ъ' => '',
            'ы' => 'y',
            'ь' => '',
            'э' => 'e',
            'ю' => 'yu',
            'я' => 'ya',
            'ә' => 'a', #fixed
            'і' => 'i',
            'ң' => 'n', #fixed
            'ғ' => 'g', #fixed
            'ү' => 'u',
            'ұ' => 'u',
            'қ' => 'q',
            'ө' => 'o',
            'һ' => 'h',
            'Һ' => 'h',
            // capital letters
            'А' => 'a',
            'Б' => 'b',
            'В' => 'v',
            'Г' => 'g',
            'Д' => 'd',
            'Е' => 'e',
            'Ё' => 'e', #fixed
            'Ж' => 'zh',
            'З' => 'z',
            'И' => 'i',
            'Й' => 'y', #fixed
            'К' => 'k',
            'Л' => 'l',
            'М' => 'm',
            'Н' => 'n',
            'О' => 'o',
            'П' => 'p',
            'Р' => 'r',
            'С' => 's',
            'Т' => 't',
            'У' => 'u',
            'Ф' => 'f',
            'Х' => 'kh', #fixed
            'Ц' => 'ts', #fixed
            'Ч' => 'ch',
            'Ш' => 'sh',
            'Щ' => 'sh',
            'Ъ' => '',
            'Ы' => 'y',
            'Ь' => '',
            'Э' => 'e',
            'Ю' => 'yu',
            'Я' => 'ya',
            'Ә' => 'a', #fixed
            'Ə' => 'a', #fixed
            'І' => 'i',
            'Ң' => 'n', #fixed
            'Ғ' => 'g', #fixed
            'Ү' => 'u',
            'Ұ' => 'u',
            'Қ' => 'q',
            'Ө' => 'o',
        ];

        $var = html_entity_decode($var, ENT_QUOTES, 'UTF-8');
        $var = strtr($var, $symbol_list);
        return $var;
    }

    public  static function getStandardCredentials($item)
    {
        return $item = trim($item);
    }

}
