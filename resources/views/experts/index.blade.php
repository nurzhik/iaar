@extends('layouts.front')
@section('content')
    <section class="baz_expert">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/{{$lang}}">{{__('main.Main')}}</a></li>
                <li><a>{{__('База экспертов')}}</a></li>
            </ul>
            <form id="experts_search_form" method="get" action="/experts_database">
                {{csrf_field()}}
                <input type="hidden" value="{{$request->country_id}}" name="country_id" id="country_id">
                <input type="hidden" value="{{$request->accr_type}}"  name="accr_type" id="accr_type">
                <input type="hidden" value="{{isset($request->univer_type_id)|| $request->univer_type_id === 0  ? $request->univer_type_id : -1}}" name="univer_type_id" id="univer_type_id">
                <input type="hidden" value="{{isset($request->expert_category_id)|| $request->expert_category_id === 0  ? $request->expert_category_id : -1}}" name="expert_category_id" id="expert_category_id">
                <input type="hidden" value="{{isset($request->direction_type_id) ? $request->direction_type_id : 0}}" name="direction_type_id" id="direction_type_id">
                <input type="hidden" value="{{$request->expert_direction_id}}" name="expert_direction_id" id="expert_direction_id">
                <input type="hidden" value="{{$request->expert_spec_id}}" name="expert_spec_id" id="expert_spec_id">
                <input type="hidden" value="{{$request->is_participated}}" name="is_participated" id="is_participated">
                <input type="hidden" value="{{$request->category_number}}" name="category_number" id="category_number">
                <input type="hidden" value="{{$request->is_chairman}}" name="is_chairman" id="is_chairman">
                <input type="hidden" value="{{$request->foreign_expert_type}}" name="foreign_expert_type" id="foreign_expert_type">
            </form>
            <script>
                $(document).ready(function(){
                    $('#search_submit').on('click',function(event){
                        $('#experts_search_form').submit();
                    });
                    $('.country_id_option').on('click',function(){
                        $('#country_id').val($(this).data('id'));
                    });
                    $('.foreign_expert_type').on('click',function(){
                        $('#foreign_expert_type').val($(this).data('id'));
                    });
                    $('.expert_category_id_option').on('click',function(){
                        $('#expert_category_id').val($(this).data('id'));
                    });
                    $('.accr_type_option').on('click',function(){
                        $('#accr_type').val($(this).data('id'));
                    });
                    $('.univer_type_id_option').on('click',function(){
                        $('#univer_type_id').val($(this).data('id'));
                        loadDirections($(this).data('id'),$('#direction_type_id').val());
                    });
                    $('.direction_type_id_option').on('click',function(){
                        $('#direction_type_id').val($(this).data('id'));
                        loadDirections($('#univer_type_id').val(),$(this).data('id'));
                    });
                    $('.choice_bottom').delegate('.expert_direction_id_option','click',function(){
                        $('#expert_direction_id').val($(this).data('id'));
                        loadSpecs($(this).data('id'));
                    });
                    $('.choice_bottom').delegate('.expert_spec_id_option','click',function(){
                        $('#expert_spec_id').val($(this).data('id'));
                    });
                    $('.category_number_option').on('click',function(){
                        $('#category_number').val($(this).data('id'));
                    });
                    $('.is_participated_option').on('click',function(){
                        $('#is_participated').val($(this).data('id'));
                    });
                    $('.is_chairman_option').on('click',function(){
                        $('#is_chairman').val($(this).data('id'));
                    });
                    function loadDirections(univer_type_id,direction_type_id)
                    {
                        $.ajax({
                            type: "POST",
                            url: "/get_expert_directions",
                            dataType: "json",
                            data: {
                                univer_type_id: univer_type_id,
                                direction_type_id: direction_type_id,
                            },
                            success: function (data) {
                                console.log(data);
                                if(data.directions)
                                {
                                    var text ='';
                                    for(var i = 0 ; i<data.directions.length; i++)
                                    {
                                        text = text+'<li><a data-id="'+data.directions[i].id+'" class="sel_opt expert_direction_id_option" href="javascript:;">'+data.directions[i].title+'</a></li>';

                                    }
                                    $('#direction_id_options').html(text);

                                }
                                else
                                    alert('Произошла ошибка');
                            },
                        });

                    }
                    function loadSpecs(expert_direction_id)
                    {
                        $.ajax({
                            type: "POST",
                            url: "/get_expert_specs",
                            dataType: "json",
                            data: {
                                expert_direction_id: expert_direction_id,
                            },
                            success: function ( data ) {
                                if(data.specs)
                                {
                                    var text ='';
                                    for(var i = 0 ; i<data.specs.length; i++)
                                    {
                                        text = text+'<li><a data-id="'+data.specs[i].id+'" class="sel_opt expert_spec_id_option" href="javascript:;">'+data.specs[i].title+'</a></li>';

                                    }
                                    $('#spec_id_options').html(text);
                                }
                                else
                                    alert('Произошла ошибка');
                            },
                        });
                    }

                });
            </script>
            <p class="title">База экспертов</p>
            <div class="reestr_block">
                <div class="choice_top">
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
                            <p data-attr="0" class="sel_title">{{__('main.Country_Select')}}</p>
                            <ul class="options">
                                <li><a data-id="0"  class="sel_opt country_id_option @if($request->country_id == 0 ) active @endif " href="javascript:;">Все страны</a></li>
                                @foreach($countries as $country)
                                    <li><a data-id="{{$country->id}}"  class="sel_opt country_id_option @if($request->country_id == $country->id ) active @endif " href="javascript:;">{{$country->getLocaleNode($lang)->title}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="sel_block">
                        <div class="sel_block__top">
                            <label class="label" for="">Выберите вид базы</label>
                            <div class="help">
                                <div class="help__part">
                                    <div class="help_text">
                                        Выберите вид базы
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="reestr_select">
                            <p data-attr="0" class="sel_title">Выберите вид базы</p>
                            <ul class="options">
                                <li><a data-id="-1"  class="sel_opt univer_type_id_option @if($request->univer_type_id == 1001) active @endif" href="javascript:;">Все виды базы</a></li>
                                <li><a data-id="0"  class="sel_opt univer_type_id_option @if($request->univer_type_id === '0' ) active @endif" href="javascript:;">{{__('main.Org_High_Post_Educ')}}</a></li>
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
                            <label class="label" for="">Категория эксперта</label>
                            <div class="help">
                                <div class="help__part">
                                    <div class="help_text">
                                        Выберите категорию эксперта
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="reestr_select">
                            <p data-attr="0" class="sel_title">Выберите категорию</p>
                            <ul class="options">
                                <li><a data-id="-1" class="sel_opt expert_category_id_option @if($request->expert_category_id == -1 or  $request->expert_category_id===null)  active @endif" href="javascript:;">Все категории</a></li>
                                @foreach(\App\Models\Expert::availableCategoryId() as $key=>$value)
                                <li><a data-id="{{$value}}" class="sel_opt expert_category_id_option @if($request->expert_category_id === (string)$value )  active @endif" href="javascript:;">{{$key}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="dop_filter">
                    <span>{{__('main.Add_Filters')}}</span>
                    <div class="black_line"></div>
                    <div class="arrow"></div>
                </div>

                <div class="choice_bottom">
                    <div class="sel_block">
                        <div class="sel_block__top">
                            <label class="label" for="">Направления</label>
                            <div class="help">
                                <div class="help__part">
                                    <div class="help_text">
                                        Выберите направление
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="reestr_select">
                            <p data-attr="0" class="sel_title sel_2">  Выберите направление</p>
                            <ul class="options">
                                <li><a data-id="0" class="sel_opt direction_type_id_option @if($request->direction_type_id == 0 ) active @endif " href="javascript:;">Без направления</a></li>
                                <li><a data-id="1" class="sel_opt direction_type_id_option @if($request->direction_type_id == 1 ) active @endif " href="javascript:;">Фактическое</a></li>
                                <li><a data-id="2" class="sel_opt direction_type_id_option @if($request->direction_type_id == 2 ) active @endif " href="javascript:;">Возможное</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="sel_block">
                        <div class="sel_block__top">
                            <label class="label" for="">Направления</label>
                            <div class="help">
                                <div class="help__part">
                                    <div class="help_text">
                                        Выберите направление направления
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="reestr_select">
                            <p data-attr="2012" class="sel_title">Выберите направление</p>
                            <ul class="options" id="direction_id_options">
                                @foreach($directions as $direction)
                                <li><a data-id="{{$direction->id}}" class="sel_opt expert_direction_id_option @if($loop->first)  @endif" href="javascript:;">{{$direction->title}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="sel_block">
                        <div class="sel_block__top">
                            <label class="label" for="">Специализация</label>
                            <div class="help">
                                <div class="help__part">
                                    <div class="help_text">
                                        Выберите специализацию
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="reestr_select">
                            <p data-attr="2012" class="sel_title">Выберите специализацию</p>
                            <ul class="options" id="spec_id_options">

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="choice_bottom last_choice">
                    <div class="sel_block">
                        <div class="sel_block__top">
                            <label class="label" for="">Вид акредитации</label>
                            <div class="help">
                                <div class="help__part">
                                    <div class="help_text">
                                        Выберите вид акредитации
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="reestr_select">
                            <p data-attr="1" class="sel_title">Выберите тип аккредитации</p>
                            <ul class="options">
                                <li><a data-id="1" class="sel_opt accr_type_option @if($request->accr_type == 1 ) active @endif " href="javascript:;">{{__('main.Institutional')}}</a></li>
                                <li><a data-id="2" class="sel_opt accr_type_option @if($request->accr_type == 2 ) active @endif " href="javascript:;">{{__('main.Specialized')}}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="sel_block">
                        <div class="sel_block__top">
                            <label class="label" for="">Категория эксперта</label>
                            <div class="help">
                                <div class="help__part">
                                    <div class="help_text">
                                        Выберите категорию эксперта
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="reestr_select">
                            <p data-attr="2012" class="sel_title">Выберите категорию эксперта</p>
                            <ul class="options">
                                <li><a data-id="1" class="sel_opt category_number_option @if($request->category_number == 1 ) active @endif " href="javascript:;">1</a></li>
                                <li><a data-id="2" class="sel_opt category_number_option @if($request->category_number == 2 ) active @endif " href="javascript:;">2</a></li>
                                <li><a data-id="3" class="sel_opt category_number_option @if($request->category_number == 3 ) active @endif " href="javascript:;">3</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="sel_block">
                        <div class="sel_block__top">
                            <label class="label" for="">Участие</label>
                            <div class="help">
                                <div class="help__part">
                                    <div class="help_text">
                                        Выберите вид участия
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="reestr_select">
                            <p data-attr="2012" class="sel_title">Выберите вид участия</p>
                            <ul class="options">
                                <li><a data-id="1" class="sel_opt is_participated_option @if($request->is_participated == 1 ) active @endif" href="javascript:;">Участвовал</a></li>
                                <li><a data-id="2" class="sel_opt  is_participated_option @if($request->is_participated == 2 ) active @endif" href="javascript:;">Не участвовал</a></li>
                                <li><a data-id="3" class="sel_opt  is_participated_option @if($request->is_participated == 3 ) active @endif" href="javascript:;">Оба варианта</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="sel_block">
                        <div class="sel_block__top">
                            <label class="label" for="">Председатель</label>
                            <div class="help">
                                <div class="help__part">
                                    <div class="help_text">
                                        Выберите является ли эксперт председателем
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="reestr_select">
                            <p data-attr="2012" class="sel_title">Выберите является ли эксперт председателем</p>
                            <ul class="options">
                                <li><a data-id="1" class="sel_opt is_chairman_option @if($request->is_chairman == 1 ) active @endif" href="javascript:;">Председатель</a></li>
                                <li><a data-id="2" class="sel_opt  is_chairman_option @if($request->is_chairman == 2 ) active @endif" href="javascript:;">Не председатель</a></li>
                                <li><a data-id="3" class="sel_opt is_chairman_option  @if($request->is_chairman == 3 ) active @endif" href="javascript:;">Оба варианта</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                    <div class="choice_bottom last_choice">
                    <div class="sel_block">
                        <div class="sel_block__top">
                            <label class="label" for="">Тип рекрутинга</label>
                            <div class="help">
                                <div class="help__part">
                                    <div class="help_text">
                                        Выберите тип рекрутинга эксперта
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="reestr_select">
                            <p data-attr="2012" class="sel_title"> Выберите тип рекрутинга эксперта</p>
                            <ul class="options">
                                <li><a data-id="-1" class="sel_opt foreign_expert_type @if($request->foreign_expert_type == -1 or  $request->foreign_expert_type===null)  active @endif" href="javascript:;"> Все виды</a></li>
                                @foreach(\App\Models\Expert::availableForeignExpertType() as $key=>$value)
                                    <li><a data-id="{{$value}}" class="sel_opt foreign_expert_type @if($request->foreign_expert_type == $value and   $request->foreign_expert_type!=null ) active @endif" href="javascript:;">{{$key}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="submit_block">
                    <a href="/experts_database"  class="re_search_submit">Сбросить все фильтры</a>
                </div>
                <div class="submit_block" style="text-align: center">
                    <a href="javascript:;"  id="search_submit" class="re_search_submit">{{__('main.Confirm')}}</a>
                </div>

            </div>
        </div>
    </section>

    @if(count($results))
    <section class="expert_search" style="display: block">
        <div class="container">
                <p class="title">{{__('main.Search_Results')}}: {{$count}} </p>
                <div class="result_expert">
                @foreach($results as $result)
                <div class="result_item">
                    <div class="result_img">
                        <div class="result_img__photo" style="background-image: url('{{$result->photo}}');"></div>
                    </div>
                    <div class="result_text result-text--database">
                        <p class="expert_name">{{$result->name}}</p>
                        <ul class="result_info">
                            <li><span>№ сертификата:</span> {{$result->certificate_number}}</li>
                            <li><span>Дата выдачи сертификата:</span> {{date('d.m.Y',strtotime($result->certificate_date))}}</li>
                            <li><span>Дата окончания действия сертификата:</span> {{\Carbon\Carbon::parse($result->certificate_date)->addYears(5)->format('d.m.Y')}}</li>
                            <li><span>Место работы:</span> {{$result->place_of_work}}</li>
                            <li><span>{{__('main.Position')}}:</span> {{$result->position}}</li>
                        </ul>
                        <a href="/experts_database/expert/{{$result->id}}" style="color:#fff" class="vyz_info_btn">{{__('main.More')}}</a>
                    </div>
                </div>
                @endforeach
            </div>

            {{ $results->appends([
                'expert_category_id' => $request->expert_category_id,
                'country_id' => $request->country_id,
                'accr_type' => $request->accr_type,
                 'univer_type_id' => $request->univer_type_id,
                'expert_spec_id' => $request->expert_spec_id,
                'expert_direction_id' => $request->expert_direction_id,
                'direction_type_id' => $request->direction_type_id,
                'category_number' => $request->category_number,
                'is_chairman' => $request->is_chairman,
                'is_participated' => $request->is_participated,
            ])->links('vendor.pagination.front')
            }}
        </div>
    </section>
    @endif
    @if(!count($results) and isset($request->country_id))
    <section>
        <div class="container">
            <p class="title">{{__('main.Not_Found')}}</p>
        </div>
    </section>
    @endif
@endsection
