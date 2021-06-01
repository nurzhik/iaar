@extends('layouts.front')
@section('content')
    <section class="vyz_page">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/{{$lang}}">{{__('main.Main')}}</a></li>
                <li><a>{{__('main.Register')}}</a></li>
                <li><a>{{$item->getLocaleNode($lang)->title}}</a></li>
            </ul>
            <div class="vyz_item">
                <div class="vyz_top">
                    <p class="title">{{$item->getLocaleNode($lang)->title}}</p>
                    <span class="id">ID: {{$accr->unique_index}}</span>
                </div>
                <div class="tab-part">
                    <ul class="tab-ul tab-ul--acred tab-ul--un">
                        <li class="active">
                          
                            @if(\Carbon\Carbon::parse($accr->date_end)->toDate() >= \Carbon\Carbon::now()->toDate())
                                    {{__('main.valid_ac')}} 
                                @else
                                    {{__('main.previous')}} {{date('Y',strtotime($accr->date_start))}} -  {{date('Y',strtotime($accr->date_end))}}
                                @endif
                        </li>
                        @foreach($main_accrs as $main_accr)
                            <li>
                                @if(\Carbon\Carbon::parse($main_accr->date_end)->toDate() >= \Carbon\Carbon::now()->toDate())
                                    {{__('main.valid_ac')}} 
                                @else
                                    {{__('main.previous')}}    {{date('Y',strtotime($main_accr->date_start))}} -  {{date('Y',strtotime($main_accr->date_end))}}
                                @endif
                            </li>
                        @endforeach                
                    </ul>
                    <div class="tab-areas tab-content--programm">
                        <div class="tab-content__item active">
                            
                            <span class="country" style="background: url('{{asset($item->country->icon)}}') left center / 30px no-repeat;">{{$item->country->getLocaleNode($lang)->title}}</span>
                            <div class="accred-infoblock accred-infoblock--first active">
                                <div class="vyz_bottom">
                                    <ul class="akkr_info">
                                        <li><p class="sidebar_title">{{__('main.Type_Organization')}}:</p><p>{{array_flip(\App\Models\Univer::availableTypeIdArray($lang))[$accr->univer_type_id]}}</p></li>
                                        <li><p class="sidebar_title">{{__('main.Organization')}}:</p><p>{{$item->getLocaleNode($lang)->title}}</p></li>
                                        <li><p class="sidebar_title">{{__('main.Form_Inc')}}:</p><p>{{$accr->getLocaleNode($lang)->org_form}}</p></li>
                                        <li><p class="sidebar_title">{{__('main.BIN')}}:</p><p>{{$accr->bin}}</p></li>
                                        <li><p class="sidebar_title">{{__('main.Educat_License')}}:</p><p>{{$accr->getLocaleNode($lang)->license}}</p></li>
                                        <li><p class="sidebar_title">{{__('main.Accred_Type')}}:</p><p>@if($accr->reakkr)
                                                    {{__('main.Institutional_Accred')}} ({{__('main.Reaccreditation')}}) 
                                                @else
                                                    {{__('main.Institutional_Accred')}}
                                                @endif</p></li>
                                        <li><p class="sidebar_title">{{__('main.Terms_Accreditation')}}:</p><p> {{$accr->years}} @if($lang == 'ru' or $lang == null)
                                                    @if(in_array($accr->years,[2,3,4]) ) года @endif
                                                    @if($accr->years == 1) год @endif
                                                    @if($accr->years >= 5) лет  @endif
                                                @endif
                                                @if($lang == 'kz') жыл @endif
                                                @if($lang == 'en') years  @endif</p>
                                        </li>
                                        @if(!empty($accr->getLocaleNode($lang)->notation))
                                        <li><p class="sidebar_title">{{__('main.Note')}}:</p><p>{{$accr->getLocaleNode($lang)->notation}}</p></li>
                                        @endif
                                    </ul>
                                    <ul class="akkr_info">
                                        <li><p class="sidebar_title">{{__('main.Date_Accred')}}:</p><p>{{date('d.m.Y',strtotime($accr->date_start))}} </p></li>
                                        <li><p class="sidebar_title">{{__('main.Expiry_Date')}}: </p><p>{{date('d.m.Y',strtotime($accr->date_end))}} </p></li>
                                        <li><p class="sidebar_title">{{__('main.Certif_Reg_Number')}}: </p><p>{{$accr->registration_number}}</p></li>
                                        <li><p class="sidebar_title">{{__('main.VEK_Visit_Date_Full')}}:</p><p>{{date('d.m.Y',strtotime($accr->visit_date_start))}} - {{date('d.m.Y',strtotime($accr->visit_date_end))}}</p></li>
                                        <li><a class="doc_icon sidebar_title" target="_blank" href="{{asset($accr->getLocaleNode($lang)->report_doc)}}">{{__('main.VEK_Report')}} 
                                            @if($accr->getLocaleNode($lang)->report_doc_lang)
                                                ({{$accr->getLocaleNode($lang)->report_doc_lang}})
                                            @endif
                                        </a>
                                        </li>
                                        <li><a class="doc_icon sidebar_title" target="_blank"  href="{{asset($accr->getLocaleNode($lang)->decision_doc)}}">{{__('main.Accred_Council_Dec')}} 
                                            @if($accr->getLocaleNode($lang)->decision_doc_lang)
                                                ({{$accr->getLocaleNode($lang)->decision_doc_lang}})
                                            @endif    
                                        </a>
                                        </li>
                                        <li><a class="doc_icon sidebar_title" target="_blank" href="{{asset($accr->getLocaleNode($lang)->committee_consist_doc)}}">{{__('main.Sostav_VEK')}} 
                                            @if($accr->getLocaleNode($lang)->committee_consist_doc_lang)
                                                ({{$accr->getLocaleNode($lang)->committee_consist_doc_lang}})
                                            @endif

                                            </a>
                                        </li>
                                        @if($accr->getLocaleNode($lang)->other_doc)
                                            <li><a class="doc_icon sidebar_title" target="_blank" href="{{asset($accr->getLocaleNode($lang)->other_doc)}}">{{$accr->getLocaleNode($lang)->other_doc_name}}</a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content__item">        
                         @foreach($main_accrs as $main_accr)
                            <div class="accred-infoblock accred-infoblock--first active">
                                <div class="vyz_bottom">
                                    <ul class="akkr_info">
                                        <li><p class="sidebar_title">{{__('main.Type_Organization')}}:</p><p>{{array_flip(\App\Models\Univer::availableTypeIdArray($lang))[$main_accr->univer_type_id]}}</p></li>
                                        <li><p class="sidebar_title">{{__('main.Organization')}}:</p><p>{{$item->getLocaleNode($lang)->title}}</p></li>
                                        <li><p class="sidebar_title">{{__('main.Form_Inc')}}:</p><p>{{$main_accr->getLocaleNode($lang)->org_form}}</p></li>
                                        <li><p class="sidebar_title">{{__('main.BIN')}}:</p><p>{{$main_accr->bin}}</p></li>
                                        <li><p class="sidebar_title">{{__('main.Educat_License')}}:</p><p>{{$main_accr->getLocaleNode($lang)->license}}</p></li>
                                        <li><p class="sidebar_title">{{__('main.Accred_Type')}}:</p><p>
                                                @if($main_accr->reakkr)
                                                    {{__('main.Institutional_Accred')}} ({{__('main.Reaccreditation')}}) 
                                                @else
                                                    {{__('main.Institutional_Accred')}}
                                                @endif</p></li>
                                        <li><p class="sidebar_title">{{__('main.Terms_Accreditation')}}:</p><p>{{$main_accr->years}} {{__('main.years')}}</p></li>

                                    </ul>
                                    <ul class="akkr_info">
                                        <li><p class="sidebar_title">{{__('main.Date_Accred')}}:</p><p>{{date('d.m.Y',strtotime($main_accr->date_start))}} </p></li>
                                        <li><p class="sidebar_title">{{__('main.Expiry_Date')}}: </p><p>{{date('d.m.Y',strtotime($main_accr->date_end))}} </p></li>
                                        <li><p class="sidebar_title">{{__('main.Certif_Reg_Number')}}: </p><p>{{$main_accr->registration_number}}</p></li>
                                        <li><p class="sidebar_title">{{__('main.VEK_Visit_Date_Full')}}:</p><p>{{date('d.m.Y',strtotime($main_accr->visit_date_start))}} - {{date('d.m.Y',strtotime($main_accr->visit_date_end))}}</p></li>
                                        <li><a class="doc_icon sidebar_title" target="_blank" href="{{asset($main_accr->getLocaleNode($lang)->report_doc)}}">{{__('main.VEK_Report')}}
                                            @if($main_accr->getLocaleNode($lang)->report_doc_lang)
                                                ({{$main_accr->getLocaleNode($lang)->report_doc_lang}})
                                            @endif
                                        </a></li>
                                        <li><a class="doc_icon sidebar_title" target="_blank"  href="{{asset($main_accr->getLocaleNode($lang)->decision_doc)}}">{{__('main.Accred_Council_Dec')}}
                                            @if($main_accr->getLocaleNode($lang)->decision_doc_lang)
                                                ({{$main_accr->getLocaleNode($lang)->decision_doc_lang}})
                                            @endif
                                        </a></li>
                                        <li><a class="doc_icon sidebar_title" target="_blank" href="{{asset($main_accr->getLocaleNode($lang)->committee_consist_doc)}}">{{__('main.Sostav_VEK')}}
                                            @if($main_accr->getLocaleNode($lang)->committee_consist_doc_lang)
                                                ({{$main_accr->getLocaleNode($lang)->committee_consist_doc_lang}})
                                            @endif
                                     </a></li>
                                       @if($main_accr->getLocaleNode($lang)->other_doc)
                                        <li><a class="doc_icon sidebar_title" target="_blank" href="{{asset($main_accr->getLocaleNode($lang)->other_doc)}}">{{$main_accr->getLocaleNode($lang)->other_doc_name}}</a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>                            
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>                   
            </div>
            <div class="program__title"><span>{{__('main.Accred_Educat_Program_University')}} </span></div>
            <div class="program__info">
                <div class="program_top">
                    <p class="sidebar_title">{{__('main.Programmes')}} ({{$programs->count()}})</p>
                   <!--  <input class="program_search" placeholder="Поиск" type="search"> -->
                </div>
                <div class="program_bottom">
                    @foreach($programs as $program)
                    <div class="res_item">
                        <div class="res_row res_top res_top--spec">
                            <p class="res_title">{{$program->program_index}} {{$program->getLocaleNode($lang)->program_title}}</p>
                            <p class="res_name">{{$item->getLocaleNode($lang)->title}}</p>
                        </div>
                        <div class="prog_akkr">
                            <ul class="akkr_info">
                                <li><span>{{__('main.Accred_Type')}}: </span>
                                    @if($program->ex_ante)
                                        {{__('main.Spec_Initial_Accred')}}
                                    @elseif($program->reaccr)
                                        {{__('main.Reaccreditation')}}
                                    @else
                                        {{__('main.Prog_Accred')}}
                                    @endif</li>
                                <li><span>{{__('main.Terms_Accreditation')}}: </span><!-- {{$program->years}} {{__('main.years')}} -->{{$program->years}} 
@if($lang == 'ru' or $lang == null)
                                        @if(in_array($program->years,[2,3,4]) ) года @endif
                                        @if($program->years == 1) год @endif
                                        @if($program->years >= 5) лет  @endif
                                    @endif
                                    @if($lang == 'kz') жыл @endif
                                    @if($lang == 'en') years  @endif
                                </li>
                                <li><span>{{__('main.Date_Accred')}}: </span>{{date('d.m.Y',strtotime($program->date_start))}}</li>
                            </ul>
                            <ul class="akkr_info">
                                <li><span>{{__('main.Expiry_Date')}}: </span>{{date('d.m.Y',strtotime($program->date_end))}}</li>
                                <li><span>{{__('main.Certif_Reg_Number')}}: </span>{{$program->registration_number}}</li>
                                <li><span>Дата визита ВЭК: </span>{{date('d.m.Y',strtotime($program->visit_date_start))}} - {{date('d.m.Y',strtotime($program->visit_date_end))}}</li>
                            </ul>
                        </div>
                        <div class="res_row">
                            <a href="{{route('view_program_page',['item' => $program->id,'lang'=> $lang])}}" class="vyz_info_btn"> {{__('main.More')}}</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        </div>
    </section>

@endsection