@extends('layouts.front')
@section('content')
    <section class="vyz_page">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/{{$lang}}">{{__('main.Main')}}</a></li>
                <li><a>{{__('main.Register')}}</a></li>
                <li><a>{{$univer->getLocaleNode($lang)->title}}</a></li>
            </ul>
            <div class="vyz_item vyz_prog">
                <div class="vyz_top">
                    <p class="title">{{$univer->getLocaleNode($lang)->title}}</p>
                    <span class="id">ID: {{$program->unique_index}}</span>
                </div>
                <div class="tab-part">
                    <ul class="tab-ul tab-ul--acred">
                     
                        <li class="active">
                            @if(\Carbon\Carbon::parse($program->date_end)->toDate() >= \Carbon\Carbon::now()->toDate())
                                    {{__('main.valid_ac')}} 
                                @else
                                    {{__('main.previous')}} {{date('Y',strtotime($program->date_start))}} -  {{date('Y',strtotime($program->date_end))}} гг
                                @endif
                        </li>
                       
                        @foreach($same_programs as $same_program)
                        <li>
                            @if(\Carbon\Carbon::parse($same_program->date_end)->toDate() >= \Carbon\Carbon::now()->toDate())
                                {{__('main.valid_ac')}} 
                            @else
                                {{__('main.previous')}}    {{date('Y',strtotime($same_program->date_start))}} -  {{date('Y',strtotime($same_program->date_end))}} гг
                            @endif
                        </li>
                         @endforeach
                    </ul>
                    <div class="tab-areas tab-content--programm">
                        <div class="tab-content__item active" id="acred1">
                            <span class="country"  style="background: url('{{asset($univer->country->icon)}}') left center / 30px no-repeat;">{{$univer->country->getLocaleNode($lang)->title}}</span>
                            <p class="vyz_prog_title">{{$program->program_index}} {{$program->getLocaleNode($lang)->program_title}}</p>
                            <div class="accred-infoblock accred-infoblock--first active">
                                <div class="vyz_bottom">
                                    <ul class="akkr_info">
                                        <li>
                                            <p class="sidebar_title">{{__('main.level_of_programm')}}</p>
                                            @if($program->educational_id != 0)
                                                <p>{{array_flip(\App\Models\Univer::educationTypeIdArray($lang))[$program->educational_id]}}</p>
                                            @else
                                                <p>{{$program->getLocaleNode($lang)->educational_title}}</p>
                                            @endif
                                        </li>
                                        <li><p class="sidebar_title">{{__('main.Country')}}:</p><p>{{$univer->country->getLocaleNode($lang)->title}}</p></li>
                                        <li><p class="sidebar_title">{{__('main.Type_Organization')}}:</p><p>{{array_flip(\App\Models\Univer::availableTypeIdArray($lang))[$program->univer_type_id]}}</p></li>
                                        <li><p class="sidebar_title">{{__('main.Organization')}}:</p><p> {{$univer->getLocaleNode($lang)->title}}</p></li>
                                        <li><p class="sidebar_title">{{__('main.Form_Inc')}}:</p><p>{{$program->getLocaleNode($lang)->org_form}}</p></li>
                                        <li><p class="sidebar_title">{{__('main.Educat_License')}}:</p><p>{{$program->getLocaleNode($lang)->license}}</p></li>
                                        <li><p class="sidebar_title">{{__('main.BIN')}}:</p><p class="upper">{{$program->bin}}</p></li>
                                        <li><p class="sidebar_title">{{__('main.Accred_Type')}}:</p><p>  @if($program->ex_ante)
                                                    {{__('main.Spec_Initial_Accred')}}
                                                @elseif($program->reaccr)
                                                    {{__('main.Spec_Prog_Re_Accred')}}
                                                @else
                                                    {{__('main.Prog_Accred')}}
                                                @endif</p>
                                        </li>
                                    
                                            <li>
                                                <p class="sidebar_title">{{__('main.qf_level')}}:</p>
                                                <p>{{array_flip(\App\Models\Univer::QfIdArray($lang))[$program->qf]}}</p>
                                            </li>
                                       
                                        <li>
                                            <p class="sidebar_title">{{__('main.nqf_level')}}:</p>
                                            <p>{{array_flip(\App\Models\Univer::NqfIdArray($lang))[$program->nqf]}}</p>
                                        </li>
                                       
                                        @if(!empty($program->partner))
                                      <!--    <li><p class="sidebar_title sidebar_title--accred">{{__('main.Sovmest')}}</p></li> -->
                                        @endif
                                         @if(!empty($program->getLocaleNode($lang)->notation))
                                        <li><p class="sidebar_title">{{__('main.Note')}}:</p><p>{{$program->getLocaleNode($lang)->notation}}</p></li>
                                            @endif
                                    </ul>
                                    <ul class="akkr_info">
                                        <li><p class="sidebar_title">{{__('main.Terms_Accreditation')}}:</p><p>{{$program->years}}
                                        @if($lang == 'ru' or $lang == null)
                                                    @if(in_array($program->years,[2,3,4]) ) года @endif
                                                    @if($program->years == 1) год @endif
                                                    @if($program->years >= 5) лет  @endif
                                                @endif
                                                @if($lang == 'kz') жыл @endif
                                                @if($lang == 'en') years  @endif

                                        <!-- {{__('main.years')}} --></p></li>
                                        <li><p class="sidebar_title">{{__('main.Date_Accred')}}:</p><p>{{date('d.m.Y',strtotime($program->date_start))}}</p></li>
                                        <li><p class="sidebar_title">{{__('main.Expiry_Date')}}: </p><p>{{date('d.m.Y',strtotime($program->date_end))}}</p></li>
                                        <li><p class="sidebar_title">{{__('main.Certif_Reg_Number')}}: </p><p>{{$program->registration_number}}</p></li>
                                        <li><p class="sidebar_title">{{__('main.VEK_Visit_Date_Full')}}:</p><p>{{date('d.m.Y',strtotime($program->visit_date_start))}} - {{date('d.m.Y',strtotime($program->visit_date_end))}}</p></li>
                                        <li><a class="doc_icon sidebar_title" target="_blank" href="{{asset($program->getLocaleNode($lang)->report_doc)}}">{{__('main.VEK_Report')}}
                                            @if($program->getLocaleNode($lang)->report_doc_lang)
                                                ({{$program->getLocaleNode($lang)->report_doc_lang}})
                                            @endif
                                        </a></li>
                                        <li><a class="doc_icon sidebar_title" target="_blank"  href="{{asset($program->getLocaleNode($lang)->decision_doc)}}">{{__('main.Accred_Council_Dec')}}
                                            @if($program->getLocaleNode($lang)->decision_doc_lang)
                                                ({{$program->getLocaleNode($lang)->decision_doc_lang}})
                                            @endif
                                            </a></li>
                                        <li><a class="doc_icon sidebar_title" target="_blank" href="{{asset($program->getLocaleNode($lang)->committee_consist_doc)}}">{{__('main.Sostav_VEK')}}
                                            @if($program->getLocaleNode($lang)->committee_consist_doc_lang)
                                                ({{$program->getLocaleNode($lang)->committee_consist_doc_lang}})
                                            @endif
                                            </a></li>
                                         @if($program->getLocaleNode($lang)->other_doc)
                                        <li><a class="doc_icon sidebar_title" target="_blank" href="{{asset($program->getLocaleNode($lang)->other_doc)}}">{{$program->getLocaleNode($lang)->other_doc_name}}</a>
                                        </li>
                                        @endif
                                    </ul>                                    
                                </div>
                                @if($program->partner)
                              <!--    <li><p class="sidebar_title sidebar_title--accred">{{__('main.Sovmest')}}</p></li> -->
                              <div class="sovmest-bot">
                                    <p class="sovmest-bot__text">{{__('main.Sovmest')}}</p>
                                </div>
                                @endif
                                
                            </div>
                        </div>
                        @foreach($same_programs as $same_program)
                        <div class="tab-content__item" id="acred{{$same_program->id}}">
                            <span class="country"  style="background: url('{{asset($univer->country->icon)}}') left center / 30px no-repeat;">{{$univer->country->getLocaleNode($lang)->title}}</span>
                            <p class="vyz_prog_title">{{$same_program->program_index}} {{$same_program->getLocaleNode($lang)->program_title}}</p>
                            <div class="accred-infoblock accred-infoblock--first active">
                                <div class="vyz_bottom">
                                    <ul class="akkr_info">
                                        <li>
                                            <p class="sidebar_title">Уровень образовательной программы:</p>
                                            @if($same_program->educational_id != 0)
                                                <p>{{array_flip(\App\Models\Univer::educationTypeIdArray($lang))[$same_program->educational_id]}}</p>
                                            @else
                                                <p>{{$same_program->getLocaleNode($lang)->educational_title}}</p>
                                            @endif
                                        </li>
                                        <li><p class="sidebar_title">{{__('main.Country')}}:</p><p>{{$univer->country->getLocaleNode($lang)->title}}</p></li>
                                        <li><p class="sidebar_title">{{__('main.Type_Organization')}}:</p><p>{{array_flip(\App\Models\Univer::availableTypeIdArray($lang))[$same_program->univer_type_id]}}</p></li>
                                        <li><p class="sidebar_title">{{__('main.Organization')}}:</p><p> {{$univer->getLocaleNode($lang)->title}}</p></li>
                                        <li><p class="sidebar_title">{{__('main.Form_Inc')}}:</p><p>{{$same_program->getLocaleNode($lang)->org_form}}</p></li>
                                        <li><p class="sidebar_title">{{__('main.Educat_License')}}:</p><p>{{$same_program->getLocaleNode($lang)->license}}</p></li>
                                        <li><p class="sidebar_title">{{__('main.BIN')}}:</p><p class="upper">{{$same_program->bin}}</p></li>
                                        <li><p class="sidebar_title">{{__('main.Accred_Type')}}:</p><p>  @if($same_program->ex_ante)
                                                    {{__('main.Spec_Initial_Accred')}}
                                                @elseif($same_program->reaccr)
                                                    {{__('main.Spec_Prog_Re_Accred')}}
                                                @else
                                                    {{__('main.Prog_Accred')}}
                                                @endif</p>
                                        </li>
                                        @if(!empty($same_program->qf))
                                            <li>
                                                <p class="sidebar_title">{{__('main.qf_level')}}:</p>
                                                <p>{{array_flip(\App\Models\Univer::QfIdArray($lang))[$program->qf]}}</p>
                                            </li>
                                        @endif
                                        @if(!empty($same_program->nqf))
                                            <li>
                                                <p class="sidebar_title">{{__('main.nqf_level')}}:</p>
                                                <p>{{array_flip(\App\Models\Univer::NqfIdArray($lang))[$program->nqf]}}</p>
                                            </li>
                                        @endif
                                        @if(!empty($same_program->partner))
                                            <li><p class="sidebar_title">Совместный партнер</p></li>
                                        @endif
                                        @if(!empty($same_program->getLocaleNode($lang)->notation))
                                            <li><p class="sidebar_title">Примечание:</p><p>{{$same_program->getLocaleNode($lang)->notation}}</p></li>
                                        @endif
                                    </ul>
                                    <ul class="akkr_info">
                                        <li><p class="sidebar_title">{{__('main.Terms_Accreditation')}}:</p><p>{{$same_program->years}}
                                                @if($lang == 'ru' or $lang == null)
                                                    @if(in_array($same_program->years,[2,3,4]) ) года @endif
                                                    @if($same_program->years == 1) год @endif
                                                    @if($same_program->years >= 5) лет  @endif
                                                @endif
                                                @if($lang == 'kz') жыл @endif
                                                @if($lang == 'en') years  @endif

                                            <!-- {{__('main.years')}} --></p></li>
                                        <li><p class="sidebar_title">{{__('main.Date_Accred')}}:</p><p>{{date('d.m.Y',strtotime($same_program->date_start))}}</p></li>
                                        <li><p class="sidebar_title">{{__('main.Expiry_Date')}}: </p><p>{{date('d.m.Y',strtotime($same_program->date_end))}}</p></li>
                                        <li><p class="sidebar_title">{{__('main.Certif_Reg_Number')}}: </p><p>{{$same_program->registration_number}}</p></li>
                                        <li><p class="sidebar_title">{{__('main.VEK_Visit_Date_Full')}}:</p><p>{{date('d.m.Y',strtotime($same_program->visit_date_start))}} - {{date('d.m.Y',strtotime($same_program->visit_date_end))}}</p></li>
                                        <li><a class="doc_icon sidebar_title" target="_blank" href="{{asset($same_program->getLocaleNode($lang)->report_doc)}}">{{__('main.VEK_Report')}}
                                                @if($same_program->getLocaleNode($lang)->report_doc_lang)
                                                    ({{$same_program->getLocaleNode($lang)->report_doc_lang}})
                                                @endif
                                            </a></li>
                                        <li><a class="doc_icon sidebar_title" target="_blank"  href="{{asset($same_program->getLocaleNode($lang)->decision_doc)}}">{{__('main.Accred_Council_Dec')}}
                                                @if($same_program->getLocaleNode($lang)->decision_doc_lang)
                                                    ({{$same_program->getLocaleNode($lang)->decision_doc_lang}})
                                                @endif
                                            </a></li>
                                        <li><a class="doc_icon sidebar_title" target="_blank" href="{{asset($same_program->getLocaleNode($lang)->committee_consist_doc)}}">{{__('main.Sostav_VEK')}}
                                                @if($same_program->getLocaleNode($lang)->committee_consist_doc_lang)
                                                    ({{$same_program->getLocaleNode($lang)->committee_consist_doc_lang}})
                                                @endif
                                            </a></li>
                                        @if($same_program->getLocaleNode($lang)->other_doc)
                                            <li><a class="doc_icon sidebar_title" target="_blank" href="{{asset($same_program->getLocaleNode($lang)->other_doc)}}">{{$same_program->getLocaleNode($lang)->other_doc_name}}</a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                            @endforeach
                    </div>
                </div>
            </div>
            <div class="program__title"><span>{{__('main.Accred_Educat_Program_University')}}</span></div>
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
                                <p class="res_name">{{$univer->getLocaleNode($lang)->title}}</p>
                            </div>
                            <div class="spec-mini">
	                            <div class="vyz_info__part">
	                                <div class="col">
	                                    <p><span>{{__('main.Accred_Type')}}: </span>
	                                        @if($program->ex_ante)
	                                            {{__('main.Spec_Initial_Accred')}}
	                                        @elseif($program->reaccr)
	                                            {{__('main.Spec_Prog_Re_Accred')}}
	                                        @else
	                                            {{__('main.Prog_Accred')}}
	                                        @endif</p>
	                                    <p><span>{{__('main.Terms_Accreditation')}}: </span>{{$program->years}}
	                            @if($lang == 'ru' or $lang == null)
	                                        @if(in_array($program->years,[2,3,4]) ) года @endif
	                                        @if($program->years == 1) год @endif
	                                        @if($program->years >= 5) лет  @endif
	                                    @endif
	                                    @if($lang == 'kz') жыл @endif
	                                    @if($lang == 'en') years  @endif</p>
	                                    <p><span>{{__('main.Date_Accred')}}: </span>{{date('d.m.Y',strtotime($program->date_start))}}</p>
	                                </div>
	                                <div class="col">
	                                    <p><span>{{__('main.Expiry_Date')}}: </span>{{date('d.m.Y',strtotime($program->date_end))}}</p>
	                                    <p><span>{{__('main.Certif_Reg_Number')}}: </span>{{$program->registration_number}}</p>
	                                    <p><span>{{__('main.VEK_Visit_Date_Full')}}: </span>{{date('d.m.Y',strtotime($program->visit_date_start))}} - {{date('d.m.Y',strtotime($program->visit_date_end))}}</p>
	                                </div>
	                            </div>
	                            <a href="{{route('view_program_page',['item' => $program->id,'lang'=> $lang])}}" class="vyz_info_btn vyz_info_btn--bot"> {{__('main.More')}}</a>
	                        </div>                               
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

@endsection
