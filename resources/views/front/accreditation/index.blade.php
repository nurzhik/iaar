@extends('layouts.front')
@section('content')
    <section class="akkr">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/{{$lang}}">{{__('main.Main')}}</a></li>
                <li><a>{{__('main.Internat_Accred')}}</a></li>
            </ul>
            <p class="title">{{__('main.Internat_Accred')}}</p>
            <div class="accred-title">
                {!!\App\Models\Comp::where('id',2)->first()->getLocaleNode($lang)->text!!}
            </div>
            <div class="accred-info">
                @if(!empty($item))    <img src="{{$item->main_image}}" class="rating_img3">  @endif
                <div class="accred-info__text">
              @if(!empty($item))  {!! $item->getLocaleNode($lang)->content !!} @endif

                </div>
            </div>
        </div>
    </section>
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
    <div class="akkr_section">
        <div class="container">
            <div class="reestr_block">
                <div class="request_block request_block--first">
                    <div class="req_number">1</div>
                    <div class="req_name">
                        <span>{{__('main.Country')}}</span>
                        <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore.</p> -->
                    </div> 
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
                        <div class="reestr_select reestr_country">
                            <p data-attr="0" class="sel_title first_sel">{{__('main.Country_Select')}}</p>
                            <ul class="options country-sel">
                                @foreach($countries->sortBy('sort_order') as $country)
                                    <li><a data-attr="{{$country->id}}" class="sel_opt flag country_id_change" style="background-image: url('{{asset($country->icon)}}');" href="javascript:;">{{$country->getLocaleNode($lang)->title}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="request_block second_block">
                    <div class="req_number">2</div>
                    <div class="req_name">
                        <span>{{__('main.Type_Organization')}}</span>
                       <!--  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p> -->
                    </div>
                    <div class="sel_block">
                        <div class="sel_block__top">
                            <label class="label" for="">{{__('main.Сhoose_Type_Organization')}}</label> 
                            <!-- <div class="help">
                                <div class="help__part">
                                    <div class="help_text">
                                        Выберите вид организации, к которому относится ваше учебное заведение
                                    </div>
                                </div>
                            </div> -->
                        </div>                               
                        <div class="reestr_select">
                            <p data-attr="0" class="sel_title second_sel">{{__('main.Сhoose_Type_Organization')}}</p>
                            <ul class="options">
                                <li><a data-attr="0" class="sel_opt univer_type_id_change" href="javascript:;">{{__('main.Org_High_Post_Educ')}}</a></li>
                                <li><a data-attr="1" class="sel_opt univer_type_id_change" href="javascript:;">{{__('main.Med_Org_High_Post_Educ')}}</a></li>
                                <li><a data-attr="2" class="sel_opt univer_type_id_change" href="javascript:;">{{__('main.Org_Tech_Voc_Educ')}}</a></li>
                                <li><a data-attr="3" class="sel_opt univer_type_id_change" href="javascript:;">{{__('main.Med_Org_Tech_Voc_Educ')}}</a></li>
                                <li><a data-attr="4" class="sel_opt univer_type_id_change" href="javascript:;">{{__('main.Org_Second_Educ_Internat')}}</a></li>
                                <li><a data-attr="5" class="sel_opt univer_type_id_change" href="javascript:;">{{__('main.Org_Contin_Educ')}}</a></li>
                                <li><a data-attr="6" class="sel_opt univer_type_id_change" href="javascript:;">{{__('main.Research_Institute')}}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="request_block second_block">
                    <div class="req_number">3</div>
                    <div class="req_name">
                        <span>{{__('main.Accred_Type')}}</span>
                        <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p> -->
                    </div>
                    <div class="akkr_check second_block">
                        <label class="label check_box" for=""><span id="check_img_3" class="check_img"></span><input  id="check_3" type="checkbox">{{__('main.Institutional_Accred')}}</label>      
                        <label class="label check_box" for=""><span  id="check_img_6" class="check_img"></span><input id="check_6" type="checkbox">{{__('main.Institutional_Initial_Accred')}}</label>                  
                        <label class="label check_box" for=""><span  id="check_img_4" class="check_img"></span><input id="check_4" type="checkbox">{{__('main.Spec_Prog_Accred')}}</label>
                        <label class="label check_box" for=""><span  id="check_img_5" class="check_img"></span><input id="check_5" type="checkbox">{{__('main.Spec_Initial_Accred')}}</label>

                        
                        <label class="label check_box" for=""><span  id="check_img_7" class="check_img"></span><input id="check_7" type="checkbox">{{__('main.International_co_accreditation')}}</label>
                    </div>
                </div>
                <div class="last_block akkr_btn">
                    <a href="#" id="submit_search_form_accr" class="re_search_submit">{{__('main.Confirm')}}</a>
                </div>
            </div>
            @if(isset($empty))
            <div class="akkr_info_block">
                <div class="request_block">
                    {{__('main.Not_Found')}}
                    </div>
                </div>
                @endif
            </div>
        </div>
        <form method="post" action="{{route('post_accr_search',['lang' => $lang])}}" id="search_accr_form">
            {{csrf_field()}}
            <input type="hidden" name="country_id" id="country_id_input">
            <input type="hidden" name="univer_type_id" id="univer_type_id_input">
            <input type="hidden" name="accr_type_id" id="accr_type_id_input">
        </form>
    </div>


@endsection