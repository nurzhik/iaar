@extends('layouts.front')
@section('content')

<section class="rating">
    <div class="container">
        <ul class="breadcrumbs">
            <li><a href="/{{$lang}}">{{__('main.Main')}}</a></li>
            <li><a>{{__('main.Rating')}}</a></li>
        </ul>
        <p class="title">{{__('main.Rating')}}</p>
        <div style="margin-top:25px;" class="reestr_block">
            <div class="rating_select">
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
                        <p data-attr="0" class="sel_title first_sel">{{__('main.Country_Select')}}</p>
                        <ul class="options country-sel">
                            @foreach($countries->sortBy('sort_order') as $country_d)
                                <li><a data-attr="{{$country_d->id}}" style="background-image: url('{{asset($country_d->icon)}}');" class="sel_opt flag country_id_change @if(isset($country_id)) @if($country_id == $country_d->id) active  @endif @endif " href="javascript:;">{{$country_d->getLocaleNode($lang)->title}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="sel_block">
                    <div class="sel_block__top">
                        <label class="label" for="">{{__('main.Rating_Type')}}</label>
                        <div class="help">
                            <div class="help__part">
                                <div class="help_text">
                                    Выберите вид рейтинга, к которому относится ваше учебное заведение
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="reestr_select">
                        <p data-attr="0" class="sel_title second_sel">{{__('main.Rating_Type')}}</p>
                        <ul class="options">
                            <li><a data-attr="0" class="sel_opt univer_type_id_change @if(isset($country_id)) @if($univer_type_id == 0) active   @endif @endif " href="javascript:;">{{__('main.Rating_High_Educ_Institut')}}</a></li>
                            <li><a data-attr="1" class="sel_opt univer_type_id_change  @if(isset($univer_type_id)) @if($univer_type_id == 1) active   @endif @endif" href="javascript:;">{{__('main.Rating_Faculty')}}</a></li>
                            <li><a data-attr="2" class="sel_opt univer_type_id_change  @if(isset($univer_type_id)) @if($univer_type_id == 2) active   @endif @endif" href="javascript:;">{{__('main.Rating_Tech_Voc_Educ_Org')}}</a></li>                            
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
                        <p data-attr="0" class="sel_title last_sel">{{__('main.Year')}}</p>
                        <ul class="options">
                            @foreach(\App\Models\StaticPage::getYearsArray() as $year_d)
                                <li><a  data-value="{{$year_d}}"   class="sel_opt date_start_option @if(isset($year)) @if($year == $year_d) active  @endif @endif "  href="javascript:;" >{{$year_d}} </a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <a href="#" id="submit_search_form_rating" class="re_search_submit">{{__('main.Confirm')}}</a>
            </div>
        </div>
        @if(isset($item))
<div class="rating_result" style="display:block; margin-top: 40px;">
    <div class="container">
        <p class="search_title">{{$item->getLocaleNode($lang)->title}}</p>
        <div class="documents_block rating_docs">
            <ul class="docs_list">
                @foreach($item->getLocaleNode($lang)->getDecodedDocuments() as $document)
                <li><a href="{{asset($document['file'])}}" download>{{$document['name']}}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="rating_res_block">
            @foreach($item->getLocaleNode($lang)->getDecodedAddDocuments() as $document)
                <div class="rate-item">
                    <div class="rating_item" style="background: url('{{asset($document['image_preview'])}}') center / cover no-repeat;">
                        <div class="bg">
                            <a class="open_report" data-file="{{asset($document['file'])}}" data-fancybox data-src="#report_1" href="javascript:;">Открыть отчет</a>
                        </div>                       
                    </div>
                     <span class="rate-item__heading">{{$document['name']}}</span>
                </div>    
            @endforeach
        </div>
    </div>
</div>
@endif
@if(!isset($item) and isset($request->country_id))
    <p class="title">{{__('main.Not_Found')}}</p>
@endif
         @if(!isset($item))
           <p class="search_title" style="margin-top: 40px">{{__('main.Not_Found')}}</p>
        @endif
        <div class="top_rating">
            @if(isset($item))
            <img src="{{$item->main_image}}" class="rating_img2">
            @endif
            <div class="rating_text">

                <div class="static-info">
                @if(isset($item))
                    {!! $item->getLocaleNode($lang)->content !!}
                    @endif
                   <!--  <a href="/rating_council/{{$lang}}" class="href_btn re_search_submit">{{__('main.Advisory_Board')}}</a> -->
                </div>
            </div>
        </div>
        <script>
            @if(isset($year))
                var year = '{{$year}}';
                        @else
                    @foreach(\App\Models\StaticPage::getYearsArray() as $year_d)
                @if($loop->first)
                     var year ='{{$year_d}}';
                     @endif
                    @endforeach
                        @endif
                            @if(isset($country_id))
                var country_id = '{{$country_id}}';
                        @else
                    @foreach($countries->sortBy('sort_order') as $country_d)
                    @if($loop->first)
                        var country_id = '{{$country_d->id}}';
                    @endif
                    @endforeach


                        @endif
                        @if(isset($country_id))
                var univer_type_id ='{{$univer_type_id}}';
                        @else
                var univer_type_id ='0';
            @endif
            $(document).ready(function(){

                $('.univer_type_id_change').on('click',function(){
                    var value = $(this).data('attr');
                    univer_type_id = value;

                });
                $('.country_id_change').on('click',function(){
                    var value = $(this).data('attr');
                    country_id  = value;

                });
                $('.date_start_option').on('click',function(){
                    var value= $(this).data('value');
                    year = value;
                });
                $('#submit_search_form_rating').on('click',function(event){
                    event.preventDefault();
                    if( validate()){
                            window.location.href = '{{App::make('url')->to('/')}}/rating/'+country_id+'/'+univer_type_id+'/'+year+'/{{$lang}}';
                    }
                    else
                    {   
                        window.location.href = '{{App::make('url')->to('/')}}/rating/'+9+'/'+0+'/'+2020+'/{{$lang}}';
                    }
                });

                function validate()
                {
                    console.log(univer_type_id);
                    if( year != 0 && country_id !=0 &&  (univer_type_id!=0 || univer_type_id ==0))
                    {
                        return 1;
                    }
                    else
                    {
                        return 0;
                    }
                }

            });
        </script>
        
    </div>
</section>

<div id="report_1" class="report_album">
    <!-- <div class="book_page"><img src="img/news_1.png" alt=""></div>
    <div class="book_page"><img src="img/news_2.png" alt=""></div>
    <div class="book_page"><img src="img/news_3.png" alt=""></div>
    <div class="book_page"><img src="img/news_1.png" alt=""></div>
    <div class="book_page"><img src="img/news_3.png" alt=""></div> -->
</div>
<script src="{{asset('front/js/flip/js/libs/pdf.min.js')}}"></script>
<script src="{{asset('front/js/flip/js/dflip.min.js')}}"></script>

<script>
    var dFlipLocation = '{{App::make('url')->to('/')}}/front/js/flip/';
    $(document).ready(function(){
        $('.open_report').on('click',function(){
            var pdf = encodeURI($(this).data('file'));
            var options = {
                height: 600,
                webgl: false
            };
            var flipBook = $('#report_1').flipBook(pdf, options);
        })
    });
</script>
@endsection