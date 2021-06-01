@extends('layouts.front')
@section('content')
    <div class="akkr_section akkr_2">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/{{$lang}}">{{__('main.Main')}}</a></li>
                <li><a href="{{route('get_accr_seacrh',['lang'=>$lang])}}">{{__('main.Internat_Accred')}}</a></li>
                <li>{{$item->getLocaleNode($lang)->title}}</li>
            </ul>
            <script>
                $(document).ready(function(){
                $('#check_3').change(function(){
                $('#check_4').attr('checked',false);
                $('#check_img_4').removeClass('active');
                $('#check_5').attr('checked',false);
                $('#check_img_5').removeClass('active');
                $('#check_6').attr('checked',false);
                $('#check_img_6').removeClass('active');
                $('#check_7').attr('checked',false);
                $('#check_img_7').removeClass('active');
                if($(this).is(':checked'))
                {
                    $('#accr_type_id_input').val(1);
                }
                else
                {
                    $('#accr_type_id_input').val(0);
                }
            });
            $('#check_4').on('change',function(){
                $('#check_5').attr('checked',false);
                $('#check_img_5').removeClass('active');
                $('#check_3').attr('checked',false);
                $('#check_img_3').removeClass('active');
                 $('#check_6').attr('checked',false);
                $('#check_img_6').removeClass('active');
                $('#check_7').attr('checked',false);
                $('#check_img_7').removeClass('active');
                if($(this).is(':checked'))
                {
                    $('#accr_type_id_input').val(3);
                }
                else
                {
                    $('#accr_type_id_input').val(0);
                }
            });
            $('#check_5').on('change',function(){
                $('#check_3').attr('checked',false);
                $('#check_img_3').removeClass('active');
                $('#check_4').attr('checked',false);
                $('#check_img_4').removeClass('active');
                $('#check_6').attr('checked',false);
                $('#check_img_6').removeClass('active');
                $('#check_7').attr('checked',false);
                $('#check_img_7').removeClass('active');
                if($(this).is(':checked'))
                {
                    $('#accr_type_id_input').val(2);
                }
                else
                {
                    $('#accr_type_id_input').val(0);
                }
            });
            $('#check_6').on('change',function(){
                $('#check_3').attr('checked',false);
                $('#check_img_3').removeClass('active');
                $('#check_4').attr('checked',false);
                $('#check_img_4').removeClass('active');
                $('#check_5').attr('checked',false);
                $('#check_img_5').removeClass('active');
                $('#check_7').attr('checked',false);
                $('#check_img_7').removeClass('active');
                if($(this).is(':checked'))
                {
                    $('#accr_type_id_input').val(4);
                }
                else
                {
                    $('#accr_type_id_input').val(0);
                }
            });
            $('#check_7').on('change',function(){
                $('#check_3').attr('checked',false);
                $('#check_img_3').removeClass('active');
                $('#check_4').attr('checked',false);
                $('#check_img_4').removeClass('active');
                $('#check_5').attr('checked',false);
                $('#check_img_5').removeClass('active');
                $('#check_6').attr('checked',false);
                $('#check_img_6').removeClass('active');
                if($(this).is(':checked'))
                {
                    $('#accr_type_id_input').val(5);
                }
                else
                {
                    $('#accr_type_id_input').val(0);
                }
            });

                    $('.univer_type_id_change').on('click',function(){
                        var value = $(this).data('attr');
                        $('#univer_type_id_input').val(value);

                    });
                    $('.country_id_change').on('click',function(){
                        var value = $(this).data('attr');
                        $('#country_id_input').val(value);

                    });
                    $('#submit_search_form_accr').on('click',function(event){
                        event.preventDefault();

                        if( validate()){
                            $('#search_accr_form').submit();
                        }
                    });
                    function validate()
                    {
                        return 1;
                    }

                });
            </script>
            <form method="POST" action="{{route('post_accr_search',['lang' => $lang])}}" id="search_accr_form">
                {{csrf_field()}}
                <input type="hidden"  value="{{$item->country_id}}" name="country_id" id="country_id_input">
                <input type="hidden"  value="{{$item->univer_type_id}}" name="univer_type_id" id="univer_type_id_input">
                <input type="hidden" value="{{$item->sort_order}}"   name="accr_type_id" id="accr_type_id_input">
            </form>
            <div class="reestr_block" style="display:block;">
                <div class="ccc">
                    <div class="sel_block">
                        <div class="sel_block__top">
                            <label class="label" for="">{{__('main.Country_Select')}}</label>
                            <div class="help">
                                <div class="help__part">
                                    <div class="help_text">
                                        Выберите страну, в которой находится ваше учебное заведение
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="reestr_select">
                            <p data-attr="0" class="sel_title first_sel">{{__('main.Country_Select')}}</p>
                            <ul class="options">
                                @foreach($countries->sortBy('sort_order') as $country)
                                    <li><a data-attr="{{$country->id}}" class="sel_opt flag country_id_change  @if($item->country_id == $country->id) active @endif " style="background-image: url('{{asset($country->icon)}}');" href="javascript:;">{{$country->getLocaleNode($lang)->title}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="sel_block">
                        <div class="sel_block__top">
                            <label class="label" for="">{{__('main.Type_Organization')}}</label>
                            <div class="help">
                                <div class="help__part">
                                    <div class="help_text">
                                        Выберите вид организации, к которому относится ваше учебное заведение
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="reestr_select">
                            <p data-attr="0" class="sel_title second_sel">Выберите вид образования</p>
                            <ul class="options">
                                <li><a data-attr="0" class="sel_opt univer_type_id_change  @if($item->univer_type_id == 0)  active @endif " href="javascript:;">{{__('main.Org_High_Post_Educ')}}</a></li>
                                <li><a data-attr="1" class="sel_opt univer_type_id_change  @if($item->univer_type_id == 1)  active @endif  " href="javascript:;">{{__('main.Med_Org_High_Post_Educ')}}</a></li>
                                <li><a data-attr="2" class="sel_opt univer_type_id_change  @if($item->univer_type_id == 2)  active @endif  " href="javascript:;">{{__('main.Org_Tech_Voc_Educ')}}</a></li>
                                <li><a data-attr="3" class="sel_opt univer_type_id_change  @if($item->univer_type_id == 3)  active @endif  " href="javascript:;">{{__('main.Med_Org_Tech_Voc_Educ')}}</a></li>
                                <li><a data-attr="4" class="sel_opt univer_type_id_change  @if($item->univer_type_id == 4)  active @endif  " href="javascript:;">{{__('main.Org_Second_Educ_Internat')}}</a></li>
                                <li><a data-attr="5" class="sel_opt univer_type_id_change  @if($item->univer_type_id == 5)  active @endif  " href="javascript:;">{{__('main.Org_Contin_Educ')}}</a></li>
                                <li><a data-attr="6" class="sel_opt univer_type_id_change  @if($item->univer_type_id == 6)  active @endif  " href="javascript:;">{{__('main.Research_Institute')}}</a></li>
                            </ul>
                        </div>                    
                    </div>
                </div>    
                <div class="akkr_check second_block">
                    <label class="label check_box" for=""><span id="check_img_3" class="check_img @if($item->sort_order == 1) active @endif "></span>
                        <input id="check_3" type="checkbox" @if($item->sort_order == 1) checked="checked" @endif > {{__('main.Institutional_Accred')}}</label>
                     <label class="label check_box" for=""><span  id="check_img_6" class="check_img @if($item->sort_order == 4) active @endif"></span><input id="check_6" @if($item->sort_order == 4) checked="checked" @endif  type="checkbox"> {{__('main.Institutional_Initial_Accred')}}</label>
                    <label class="label check_box" for=""><span  id="check_img_4" class="check_img @if($item->sort_order == 3) active @endif"></span><input id="check_4" @if($item->sort_order == 3) checked="checked" @endif  type="checkbox"> {{__('main.Spec_Prog_Accred')}}</label>
                    <label class="label check_box" for=""><span  id="check_img_5" class="check_img @if($item->sort_order == 2) active @endif"></span><input id="check_5" @if($item->sort_order == 2) checked="checked" @endif  type="checkbox"> {{__('main.Spec_Initial_Accred')}}</label>

                   

                    <label class="label check_box" for=""><span  id="check_img_7" class="check_img @if($item->sort_order == 5) active @endif"></span><input id="check_7" @if($item->sort_order == 5) checked @endif  type="checkbox"> {{__('main.International_co_accreditation')}}</label>
                </div>
                <div style="display:block;" class="last_block akkr_btn">
                    <div style="display:inline-block;" id="submit_search_form_accr" class="re_search_submit">{{__('main.Confirm')}}</div>
                </div>
            </div>
            <div class="accred-block">
                <ul class="left_sidebar left_sidebar--2" id="akkr_tab">
                    <div style="margin-top:0;" class="akkr_docs">
                        <p class="sidebar_title">{{__('main.Documents')}}</p> 
                        <ul class="docs" style="margin-bottom:25px;">
                                @foreach($item->getLocaleNode($lang)->getDecodedDocuments() as $document)                             
                                    <li><a target="_blank" class="doc_link" href="{{asset($document['file'])}}">{{$document['name']}}</a></li>
                             @endforeach
                        </ul>
                    </div>
                    <div class="akkr_docs">
                        <p class="sidebar_title">{{__('main.Standards')}}</p>
                        <ul class="docs">
                                @foreach($item->getLocaleNode($lang)->getDecodedAddDocuments() as $document)    
                                    <li><a target="_blank" class="doc_link" href="{{asset($document['file'])}}">{{$document['name']}}</a></li>
                             @endforeach
                        </ul>
                    </div>
                </ul>
                <div class="accred-block__info">
                    <div class="static-info">
                        <div class="req_name">
                            <span>{{$item->getLocaleNode($lang)->title}}</span>
                        </div>    
                        <!-- @if(!empty($item->main_image))
                            <div class="accred-item akkr_img" style="background-image: url('{{asset($item->main_image)}}');"></div>
                        @endif -->
                        {!! $item->getLocaleNode($lang)->content !!}
                        
                    </div>                    
                    <div class="bottom_akkr">
                        <a href="/postmonitorings/postakkreditacionnyj-monitoring/{{$lang}}" class="akkr_item" style="background-image: url('{{asset('front/img/post.svg')}}');">{{__('main.Postmonitoring')}}</a>
                        <a href="/registry?country_id={{$request->country_id}}&accr_type={{$request->accr_type_id == 1 ? '1' : '2'}}&univer_type_id={{$request->univer_type_id}}/{{$lang}}" class="akkr_item" style="background-image: url('{{asset('front/img/reestr.svg')}}');">{{__('main.Register')}}</a>
                        <a href="/reports/vek-reports/{{$lang}}" class="akkr_item" style="background-image: url('{{asset('front/img/otchet.svg')}}');">{{__('main.Otchety_VEK')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection