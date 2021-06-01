@extends('layouts.front')
@section('content')
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
            $('.univer_type_id_option').on('click',function(){
                $('#univer_type_id').val($(this).data('id'));
            });

            $('.date_start_option').on('click',function(){
                $('#year_start').val($(this).data('value'));
            });

        });
    </script>
    <form id="registry_search_form" method="get" action="/reports/vek-reports/{{$lang}}">
        {{csrf_field()}}
        <input type="hidden" value="{{$request->country_id}}" name="country_id" id="country_id">
        <input type="hidden" value="{{$request->univer_type_id}}" name="univer_type_id" id="univer_type_id">
        <input type="hidden" value="{{$request->year_start}}" name="year_start" id="year_start">
    </form>
    <section>
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/{{$lang}}">{{__('main.Main')}}</a></li>
                <li><a>{{__('main.Otchety_VEK')}}</a></li>
            </ul>
            <p class="title">{{__('main.Otchety_VEK')}}</p>
            <div class="reestr_block">
                <div class="otchet_select">
                    <div class="rating_select">
                        <div class="sel_block">
                            <div class="sel_block__top">
                                <label class="label" for="">{{__('main.Country')}}</label>
                            </div>
                            <div class="reestr_select reestr_country">
                                <p data-attr="0" class="sel_title first_sel">{{__('main.Country_Select')}}</p>
                                <ul class="options country-sel">
                                     <li><a data-id="all" style="" class="sel_opt flag country_id_option @if($request->country_id == 'all') active @endif " href="javascript:;">{{__('main.all_country')}}</a></li>
                                    @foreach($countries as $country)
                                        <li><a data-id="{{$country->id}}" style="background-image: url('{{asset($country->icon)}}');" class="sel_opt flag country_id_option @if($request->country_id == $country->id ) active @endif " href="javascript:;">{{$country->getLocalenode($lang)->title}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="sel_block">
                            <div class="sel_block__top">
                                <label class="label" for="">{{__('main.Type_Organization')}}</label>
                            </div>
                            <div class="reestr_select">
                                <p data-attr="0" class="sel_title second_sel">{{__('main.Type_Organization')}}</p>
                                <ul class="options">
                                    <li><a data-id="9"  class="sel_opt  univer_type_id_option @if($request->univer_type_id == 9) active @endif " href="javascript:;">{{__('main.all_accred')}}</a></li>
                                    <li><a data-id="0"  class="sel_opt univer_type_id_option @if($request->univer_type_id == 0 ) active @endif" href="javascript:;">{{__('main.Org_High_Post_Educ')}}</a></li>
                                    <li><a data-id="1" class="sel_opt univer_type_id_option  @if($request->univer_type_id == 1 ) active @endif" href="javascript:;">{{__('main.Med_Org_High_Post_Educ')}}</a></li>
                                    <li><a data-id="2" class="sel_opt univer_type_id_option  @if($request->univer_type_id == 2 ) active @endif " href="javascript:;">{{__('main.Org_Tech_Voc_Educ')}}</a></li>
                                    <li><a data-id="3" class="sel_opt univer_type_id_option  @if($request->univer_type_id == 3 ) active @endif " href="javascript:;">{{__('main.Med_Org_Tech_Voc_Educ')}}</a></li>
                                    <li><a data-id="4" class="sel_opt univer_type_id_option  @if($request->univer_type_id == 4 ) active @endif " href="javascript:;">{{__('main.Org_Second_Educ_Internat')}}</a></li>
                                    <li><a data-id="5" class="sel_opt  univer_type_id_option @if($request->univer_type_id == 5 ) active @endif " href="javascript:;">{{__('main.Org_Contin_Educ')}}</a></li>
                                    <li><a data-id="6" class="sel_opt  univer_type_id_option @if($request->univer_type_id == 6 ) active @endif " href="javascript:;">{{__('main.Research_Institute')}}</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="sel_block">
                            <div class="sel_block__top">
                                <label class="label" for="">{{__('main.Year')}}</label>
                            </div>
                            <div class="reestr_select">
                                <p data-attr="0" class="sel_title last_sel">{{__('main.Year')}}</p>
                                <ul class="options">
                                    @foreach(\App\Models\StaticPage::getYearsArray() as $year)
                                        <li><a data-value="{{$year}}"  class="sel_opt date_start_option @if($request->year_start== $year) active @endif"  href="javascript:;">{{$year}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="sel_bottom">
                        <div class="blue_line"></div>
                        <a href="javascript:;" id="re_search_submit" class="re_search_submit">{{__('main.Confirm')}}</a>
                    </div>
                </div>
            </div>
            @if(count($results))
            <div class="otchet_block">
                @foreach($results as $result)

                <div class="vek-item @if($loop->first) active @endif">
                    <div class="vek-top">
                        <div class="vek-top__heading">
                            <p>{{$result->univer->getLocaleNode($lang)->title}}</p>
                            <span>{{date('d.m.Y', strtotime($result->date_start))}} - {{date('d.m.Y', strtotime($result->date_end))}}</span> 
                        </div>                        
                        <div class="vek-top__arrow"></div>
                    </div>
                    <div class="otchet_vek" style="display: block;">
                        <div class="otchet_vek__pad">
                            <table class="vek-table" cellspacing="0">
                                <thead>
                                <tr>
                                    <th class="name_org">{{__('main.Educat_Program_Clusters')}}</th>
                                    <th>{{__('main.Data_VEK')}}: {{date('d.m.Y', strtotime($result->date_start))}} - {{date('d.m.Y', strtotime($result->date_end))}} </th>
                                    <th>{{__('main.Otchety_VEK')}}</th>
                                </tr></thead>   

                                @foreach($result->getlocaleNode($lang)->getEncodedText() as $block)
                              
                                    <tbody>
                                    <tr>
                                        <td>{!! $block['content'] !!}</td>
                                        <td></td>
                                        <td>
                                        @if(strlen($block['file']))
                                           <div> 
                                                <a class="otchet_link" target="_blank" href="{{$block['file']}}">{{__('main.View_Report')}}
                                                     @if(!(empty($block['filename'])))
                                                        {{$block['filename']}}
                                                     @endif
                                                </a>
                                           </div> 
                                        @endif
                                        @if(strlen($block['decision']))
                                            <div> 
                                                <a class="otchet_link" target="_blank" href="{{$block['decision']}}">
                                                    {{__('main.View_Decision')}}
                                                    @if(!(empty($block['decisionname'])))
                                                        {{$block['decisionname']}}
                                                     @endif
                                                </a>
                                            </div>                 
                                        @endif
                         
                                        @if(!(empty($block['newfilename'])))
                                            <div> 
                                                <a class="otchet_link" target="_blank" href="{{$block['newfile']}}">
                                                 @if(!(empty($block['newfilename'])))
                                                        {{$block['newfilename']}}
                                                     @endif
                                             </a>
                                            </div> 
                                        @endif
                                        </td>
                                    </tr>
                                    </tbody>
                                 @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
            @if(isset($request->country_id) and count($results)<1)
                <p class="title">{{__('main.Not_Found')}}</p>
                @endif
            <!--
            <div class="pagination">
                <a href="javascript:;" class="pag first"></a>
                <a href="javascript:;" class="pag">1</a>
                <a href="javascript:;" class="pag">2</a>
                <a href="javascript:;" class="pag active">3</a>
                <a href="javascript:;" class="pag">4</a>
                <a href="javascript:;" class="pag">5</a>
                <a href="javascript:;" class="pag last"></a>
            </div>
            -->
        </div>
    </section>

@endsection