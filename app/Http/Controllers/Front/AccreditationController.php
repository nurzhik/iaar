<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Univer;
use App\Models\Nodes\UniverNode;
use App\Models\Nodes\ProgramAccrNode;
use App\Models\MainAccr;
use App\Models\StaticPage;
use Carbon\Carbon;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App;



class AccreditationController extends Controller
{

    public function getIndex(Request $request, $lang = null)
    {
        $countries = Country::where('is_accr',TRUE)->get();
        $item = StaticPage::where('type_id',37)->firstOrNew([]);
        return view('front.accreditation.index',[
            'lang' =>$lang,
            'countries' => $countries,
            'item' => $item,

        ]);
    }
    public function postIndex(Request $request, $lang = null)
    {
        $item = StaticPage::where('type_id',9)->where('sort_order',$request->accr_type_id)
            ->where('country_id',$request->country_id)
            ->where('univer_type_id',$request->univer_type_id)->first();
        if(empty($item))
        {
            $countries = Country::where('is_accr',TRUE)->get();
            $empty = 1;
            return view('front.accreditation.index',[
                'lang' =>$lang,
                'countries' => $countries,
                'empty' => $empty,
                'item' => $item
            ]);
        }
        return $this->getAccrPage($request,$item->slug,$lang);
    }

    public function getAccrPage(Request $request,$slug, $lang = null)
    {
        $item = StaticPage::where('type_id',9)->where('slug',$slug)->first();
        if(empty($item))
            return redirect()->to('/404');

        $countries = Country::where('is_accr',TRUE)->get();
        return view('front.accreditation.page',[
            'item' => $item,
            'lang' => $lang,
            'countries' => $countries,
            'request' => $request
        ]);
    }
    public function redirectAccrPage($country_id,$univer_type_id,$accr_type,$lang = null)
    {
        $item = StaticPage::where('type_id',9)->where('sort_order',$accr_type)
            ->where('country_id',$country_id)
            ->where('univer_type_id',$univer_type_id)->first();
        if(empty($item))
            return redirect()->to('/404');
        return redirect()->route('get_accr_page',['slug' => $item->slug,'lang' => $lang]);
    }

}
