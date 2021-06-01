@extends('layouts.front')
@section('content')
    <section class="reestr">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/{{$lang}}">{{__('main.Main')}}</a></li>
                <li><a>{{__('main.Register')}}</a></li>
            </ul>

          
            <form id="registry_search_form" method="get" action="/registry/{{$lang}}">
                {{csrf_field()}}
                <input type="hidden" value="{{$request->title}}" name="title" id="title">
                <input type="hidden" value="{{$request->country_id}}" name="country_id" id="country_id">
                <input type="hidden" value="{{!isset($request->accr_type) ? '1' : $request->accr_type}}"  name="accr_type" id="accr_type">
                <input type="hidden" value="{{  isset($request->univer_type_id) ? $request->univer_type_id :'20'}}" name="univer_type_id" id="univer_type_id">
                <input type="hidden" value="{{$request->year_start}}" name="year_start" id="year_start">
                <input type="hidden" value="{{$request->years}}" name="years" id="years">
                <input type="hidden" value="{{$request->is_reaccr}}" name="is_reaccr" id="is_reaccr">
                <input type="hidden" value="{{$request->is_ex_ante}}" name="is_ex_ante" id="is_ex_ante">
            </form>
            <script>
                $(document).ready(function(){
                    $('#re_search_submit').on('click',function(event){
                        $('#registry_search_form').submit();
                    });
                    function send_registry_search_form()
                    {
                        $('#registry_search_form').submit();
                    }
                   $('.country_id_option').on('click',function(){
                       $('#country_id').val($(this).data('id'));
                   });
                    $('.accr_type_option').on('click',function(){
                        $('#accr_type').val($(this).data('id'));
                    });
                    $('.univer_type_id_option').on('click',function(){
                        $('#univer_type_id').val($(this).data('id'));
                    });
                    $('.years_option').on('click',function(){
                        $('#years').val($(this).data('value'));
                    });
                    $('.date_start_option').on('click',function(){
                        $('#year_start').val($(this).data('value'));
                    });
                    $('#check_1_reaccr').on('click',function(){
                        if($('#check_1_reaccr_checkbox').is(':checked'))
                        {
                            $('#is_reaccr').val(1);
                        }
                        else
                        {
                            $('#is_reaccr').val(0);
                        }
                    });
                    $('#check_2_ex_ante').on('click',function(){
                        if($('#check_1_ex_ante_checkbox').is(':checked'))
                        {
                            $('#is_ex_ante').val(1);
                            console.log('test');
                        }
                        else
                        {
                            $('#is_ex_ante').val(0);
                            console.log('test2');
                        }
                    });
                    $('#title_search_input').on('keyup',function () {
                        $('#title').val($(this).val());
                    });
                });
            </script>
            <p class="title">{{__('main.Register')}}</p>
            <div class="registy-ftext">
                <div class="small-title">
                     {!!\App\Models\Comp::where('id',3)->first()->getLocaleNode($lang)->text!!}
                </div>
                <div class="registry-ftext__date">
                    {{__('main.Registry_update')}}: <b>{{\Carbon\Carbon::parse(\App\Models\Logs\RegistryUpdatedLog::first()->date)->format('d.m.Y')}}</b>
                </div>    
            </div>
            <div class="reestr_block">
                <div class="reestr_block__top">
                    <div class="reestr_search">
                        <div class="re_search_block">
                            <a href="javascript:;" class="re_search_btn"></a>
                            <input class="re_search" id="title_search_input" value="{{$request->title}}" type="search" placeholder="{{__('main.Name_Organization')}}">
                        </div>
                        <a href="javascript:;"  id="re_search_submit" class="re_search_submit">{{__('main.Confirm')}}</a>
                    </div>
                    <div class="choice_top">
                        <div class="sel_block">
                            <div class="sel_block__top">
                                <label class="label" for="">{{__('main.Country')}}</label>
                                <div class="help">
                                    <div class="help__part">
                                        <div class="help_text">
                                            Выберите страну, в которой находится ваше учебное заведение
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="reestr_select reestr_country">
                                <p data-attr="0" class="sel_title sel_1">{{__('main.Country_Select')}}</p>
                                <ul class="options country-sel">
                                     <li><a data-id="0"   class="sel_opt flag country_id_option @if($request->country_id ==  '0') active @endif " href="javascript:;">{{__('main.all_country')}}</a></li>
                                    @foreach($countries->sortBy('sort_order') as $country)
                                        <li><a data-id="{{$country->id}}" style="background-image: url('{{asset($country->icon)}}');"  class="sel_opt flag country_id_option @if($request->country_id == $country->id ) active @endif " href="javascript:;">{{$country->getLocalenode($lang)->title}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="sel_block">
                            <div class="sel_block__top">
                                <label class="label" for="">{{__('main.Accred_Type')}}</label>
                                <div class="help">
                                    <div class="help__part">
                                        <div class="help_text">
                                            Выберите вид аккредитации
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="reestr_select">
                                <p data-attr="0" class="sel_title sel_2">{{__('main.Institutional')}}</p>
                                <ul class="options">
                                    <li><a data-id="1" class="sel_opt accr_type_option @if($request->accr_type == 1 ) active @endif " href="javascript:;">{{__('main.Institutional')}}</a></li>
                                    <li><a data-id="2" class="sel_opt accr_type_option @if($request->accr_type == 2 ) active @endif " href="javascript:;">{{__('main.Specialized')}}</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="sel_block">
                            <div class="sel_block__top">
                                <label class="label">{{__('main.Type_Organization')}}</label>
                                <div class="help">
                                    <div class="help__part">
                                        <div class="help_text">
                                            Выберите вид организации, к которому относится ваше учебное заведение
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="reestr_select">
                                <p data-attr="0" class="sel_title sel_3">Вид образования</p>

                                <ul class="options">
                                    <li><a data-id="20"  class="sel_opt univer_type_id_option @if($request->univer_type_id == 20 or !isset($request->univer_type_id) ) active @endif" href="javascript:;">{{__('main.All_type_organization')}}</a></li>
                                    <li><a data-id="0"  class="sel_opt univer_type_id_option @if( !is_null($request->univer_type_id)  and $request->univer_type_id == 0 ) active  @endif" href="javascript:;">{{__('main.Org_High_Post_Educ')}}</a></li>
                                    <li><a data-id="1" class="sel_opt univer_type_id_option  @if($request->univer_type_id == 1 ) active @endif" href="javascript:;">{{__('main.Med_Org_High_Post_Educ')}}</a></li>
                                    <li><a data-id="2" class="sel_opt univer_type_id_option  @if($request->univer_type_id == 2 ) active @endif " href="javascript:;">{{__('main.Org_Tech_Voc_Educ')}}</a></li>
                                    <li><a data-id="3" class="sel_opt univer_type_id_option  @if($request->univer_type_id == 3 ) active @endif " href="javascript:;">{{__('main.Med_Org_Tech_Voc_Educ')}}</a></li>
                                    <li><a data-id="4" class="sel_opt univer_type_id_option  @if($request->univer_type_id == 4 ) active @endif " href="javascript:;">{{__('main.Org_Second_Educ_Internat')}}</a></li>
                                    <li><a data-id="5" class="sel_opt  univer_type_id_option @if($request->univer_type_id == 5 ) active @endif " href="javascript:;">{{__('main.Org_Contin_Educ')}}</a></li>
                                    <li><a data-id="6" class="sel_opt  univer_type_id_option @if($request->univer_type_id == 6 ) active @endif " href="javascript:;">{{__('main.Research_Institute')}}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dop_filter">
                    <span>{{__('main.Add_Filters')}}</span>
                    <div class="black_line"></div>
                    <div class="arrow"></div>
                </div>
                <div class="choice_bottom dop_filter_block">
                    <div class="sel_block">
                        <div class="sel_block__top">
                            <label class="label" for="">{{__('main.Terms_Accreditation')}}</label>
                            <div class="help">
                                <div class="help__part">
                                    <div class="help_text">
                                        Выберите срок аккредитации
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="reestr_select">
                            <p data-attr="0" class="sel_title sel_4">{{__('main.Terms_Choose')}}</p>
                            <ul class="options">
                                <li><a data-value="" class="sel_opt years_option @if($request->years == 0 ) active @endif " href="javascript:;">{{__('main.All_Terms')}}</a></li>
                                <li><a data-value="1" class="sel_opt years_option @if($request->years == 1 ) active @endif " href="javascript:;">{{__('main.1_year')}}</a></li>
                                <li><a data-value="3" class="sel_opt years_option @if($request->years == 3 ) active @endif " href="javascript:;">{{__('main.3_year')}}</a></li>
                                <li><a data-value="5" class="sel_opt years_option @if($request->years == 5 ) active @endif " href="javascript:;">{{__('main.5_year')}}</a></li>
                                <li><a data-value="7" class="sel_opt years_option @if($request->years == 7 ) active @endif " href="javascript:;">{{__('main.7_year')}}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="sel_block">
                        <div class="sel_block__top">
                            <label class="label" for="">{{__('main.Year')}}</label>
                            <div class="help">
                                <div class="help__part">
                                    <div class="help_text">
                                        Выберите год аккредитации
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="reestr_select">
                            <p data-attr="0" class="sel_title sel_5">{{__('main.Year')}}</p>
                            <ul class="options">
                                <li><a data-value=""  class="sel_opt date_start_option @if($request->year_start== 0) active @endif"  href="javascript:;">{{__('main.All_Years')}}</a></li>
                                @foreach(\App\Models\StaticPage::getYearsArray() as $year)
                                    <li><a data-value="{{$year}}"  class="sel_opt date_start_option @if($request->year_start== $year) active @endif"  href="javascript:;">{{$year}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="check_block reestr-check">
                        <label id="check_1_reaccr" class="label check_box check_box--active" for="">
                            <span  class="check_img @if($request->is_reaccr == 1) active @endif"></span>
                            <input id="check_1_reaccr_checkbox" @if( $request->is_reaccr == 1) checked @endif  type="checkbox"> {{__('main.Reaccreditation')}}
                        </label>
                        <label id="check_2_ex_ante" class="label check_box check_box--active" for="">
                            <span class="check_img @if($request->is_ex_ante == 1) active @endif "></span>
                            <input id="check_1_ex_ante_checkbox" @if( $request->is_ex_ante == 1) checked @endif   type="checkbox"> {{__('main.Initial')}}
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if(count($main_accrs)> 0 or count($programs) >0)
    <div class="search_result ">
        <div class="container">
            <p class="title">{{__('main.Search_Results')}}</p>
            <p class="result_title">{{__('main.Total_Obj_Found')}}:&nbsp;<span>{{$count}}</span></p>
            @if(count($main_accrs)> 0 )
            <div class="result_block inst" id="res_id">
                @foreach($main_accrs as $main_accr)
                <div class="vyz_name @if($loop->first)active @endif">{{$main_accr->univer->getLocaleNode($lang)->title}}</div>
                <div class="vyz_info @if($loop->first) active @endif">
                    <div class="vyz_info__part">
                        <div class="col">
                            <p>{{__('main.Country')}}: <span>{{$main_accr->univer->country->getLocaleNode($lang)->title}}</span></p>
                            <p>{{__('main.Type_Organization')}}: <span>{{array_flip(\App\Models\Univer::availableTypeIdArray($lang))[$main_accr->univer_type_id]}}</span></p>
                            <p>{{__('main.Accred_Type')}}:
                                <span>
                                    @if($main_accr->reakkr)
                                      {{__('main.Institutional_Accred')}} ({{__('main.Reaccreditation')}})
                                        @else
                                        {{__('main.Institutional_Accred')}} 
                                            @if($main_accr->ex_ante) 
                                            (Ex-Ante)
                                        @endif
                                    @endif
                                    </span>
                            </p>
                            <p>{{__('main.Terms_Accreditation')}}: <span>{{$main_accr->years}} @if($lang == 'ru' or $lang == null)
                                        @if(in_array($main_accr->years,[2,3,4]) ) года @endif
                                        @if($main_accr->years == 1) год @endif
                                        @if($main_accr->years >= 5) лет  @endif
                                    @endif
                                    @if($lang == 'kz') жыл @endif
                                    @if($lang == 'en') years  @endif</span></p>
                        </div>
                        <div class="col">
                            <p>{{__('main.Date_Accred')}}: <span>{{date('d.m.Y',strtotime($main_accr->date_start))}}</span></p>
                            <p>{{__('main.Expiry_Date')}}: <span>{{date('d.m.Y',strtotime($main_accr->date_end))}}</span></p>
                            <p>{{__('main.Certif_Reg_Number')}}: <span>{{$main_accr->registration_number}}</span></p>
                            <p>{{__('main.VEK_Visit_Date')}}:  <span>{{date('d.m.Y',strtotime($main_accr->visit_date_start))}} - {{date('d.m.Y',strtotime($main_accr->visit_date_end))}} </span></p>
                        </div>
                    </div>
                    <a href="{{route('view_univer_page',['item'=>$main_accr->university_id,'lang' => $lang])}}" class="vyz_info_btn">{{__('main.More')}}</a>
                </div>
                @endforeach
            </div>
            @endif
            @if(count($programs) > 0)
            <div class="otchet_block spec">
                @foreach($programs as $program)
                <div class="res_item">
                    <div class="res_row res_top res_top--spec">
                        <p class="res_title">{{$program->program_index}} {{$program->getLocaleNode($lang)->program_title}}</p>
                        <p class="res_name">{{$program->univer->getLocaleNode($lang)->title}}</p>
                    </div>
                    <div class="spec-mini">
                        <div class="vyz_info__part">
                            <div class="col">
                                <p>{{__('main.Country')}}: <span>{{$program->univer->country->getLocaleNode($lang)->title}}</span></p>
                                <p>{{__('main.Type_Organization')}}: <span>{{array_flip(\App\Models\Univer::availableTypeIdArray($lang))[$program->univer_type_id]}}</span></p>
                                <p>{{__('main.Accred_Type')}}: 
                                    <span>
                                        @if($program->ex_ante)
                                            {{__('main.Spec_Initial_Accred')}}  
                                        @elseif($program->reaccr)
                                            {{__('main.Reaccreditation')}}
                                        @else
                                            {{__('main.Prog_Accred')}}
                                        @endif
                                    </span>
                                </p>
                                <p>{{__('main.Terms_Accreditation')}}: <span>{{$program->years}} @if($lang == 'ru' or $lang == null)
                                            @if(in_array($program->years,[2,3,4]) ) года @endif
                                            @if($program->years == 1) год @endif
                                           @if($program->years >= 5) лет  @endif
                                        @endif
                                    @if($lang == 'kz') жыл @endif
                                    @if($lang == 'en') years  @endif </span></p>
                            </div>
                            <div class="col">
                                <p>{{__('main.Date_Accred')}}: <span>{{date('d.m.Y',strtotime($program->date_start))}}</span></p>
                                <p>{{__('main.Expiry_Date')}}: <span>{{date('d.m.Y',strtotime($program->date_end))}}</span></p>
                                <p>{{__('main.Certif_Reg_Number')}}: <span>{{$program->registration_number}}</span></p>
                                <p>{{__('main.VEK_Visit_Date')}}: <span>{{date('d.m.Y',strtotime($program->visit_date_start))}} - {{date('d.m.Y',strtotime($program->visit_date_end))}}</span></p>
                            </div>
                        </div>                        
                        <a href="{{route('view_program_page',['item' => $program->id,'lang'=> $lang])}}" class="vyz_info_btn">{{__('main.More')}}</a>         
                    </div>                    
                </div>
                @endforeach
            </div>
            @endif

            @if(count($main_accrs))
            {{ $main_accrs->appends([
                'title' => $request->title,
                'country_id' => $request->country_id,
                'accr_type' => $request->accr_type,
                'univer_type_id' => $request->univer_type_id,
                'year_start' => $request->year_start,
                'years' => $request->years,
                'is_reaccr' => $request->is_reaccr,
                'is_ex_ante' => $request->is_ex_ante,
                    ])->links('vendor.pagination.front')
            }}
            @endif
            @if(count($programs))
            {{ $programs->appends([
                'title' => $request->title,
                'country_id' => $request->country_id,
                'accr_type' => $request->accr_type,
                 'univer_type_id' => $request->univer_type_id,
                'year_start' => $request->year_start,
                'years' => $request->years,
                'is_reaccr' => $request->is_reaccr,
                'is_ex_ante' => $request->is_ex_ante,
            ])->links('vendor.pagination.front')
            }}
            @endif

        </div>
    </div>
    @endif

    @if((count($main_accrs)<= 0 and count($programs) <=0) and isset($request->country_id) )
        <div class="search_result ">
            <div class="container">
        <p class="title">{{__('main.Not_Found')}}</p>
            </div>
        </div>
    @endif
@endsection