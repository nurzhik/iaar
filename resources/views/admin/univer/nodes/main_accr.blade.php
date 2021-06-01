@extends('layouts.admin')
@push('additional_scripts')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>

    <script src="/assets/admin/js/moment/moment-with-locales.min.js" type="text/javascript" ></script>
    <link href="/assets/admin/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
    <script src="/assets/admin/js/datepicker/bootstrap-datetimepicker.js"  charset="UTF-8" type="text/javascript"></script>
    <script src="/assets/admin/js/datepicker/locales/bootstrap-datetimepicker.ru.js" type="text/javascript"></script>
@endpush
@section('content')

    <script type="text/javascript">
        $(document).ready(function(){
            $('.form_datetime').datetimepicker({
                language:  'ru',
                weekStart: 1,
                todayBtn:  1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                forceParse: 0,
                showMeridian: 1,
                minView: 2,
            });
            $('.form_datetime').datetimepicker('loadFromInput');
            $('.select2').select2({
                width: '50%',
                templateResult: function (data) {
                    // We only really care if there is an element to pull classes from
                    if (!data.element) {
                        return data.text;
                    }
                    var $element = $(data.element);
                    var $wrapper = $('<span></span>');
                    $wrapper.addClass($element[0].className);
                    $wrapper.text(data.text);
                    return $wrapper;
                }
            });
            function tableSearch() {
                var phrase = document.getElementById('search_accessory');
                var table = document.getElementById('accessories_table');
                var regPhrase = new RegExp(phrase.value, 'i');
                var flag = false;
                for (var i = 1; i < table.rows.length; i++) {
                    flag = false;
                    for (var j = table.rows[i].cells.length - 1; j >= 0; j--) {
                        flag = regPhrase.test(table.rows[i].cells[j].innerHTML);
                        if (flag) break;
                    }
                    if (flag) {
                        table.rows[i].style.display = "";
                    } else {
                        table.rows[i].style.display = "none";
                    }
                }
            }
            $('#search_accessory').on('keyup',function () {
                tableSearch();
            });
            $('.delete_category').on('click',function(){
                var item_id = $(this).attr('itemid');
                var item_name = $(this).attr('itemname');
                $('#delete_item_form').attr('action','/admin/naar/team-member/delete/'+item_id);
                $('#delete_title').html('Удаление члена команды"'+item_name+'"');
            });
        });
    </script>
    <style>
        .non-vis{
            display:none;
        }
        .keyword-div{
            word-wrap: break-word;
        }
        .remove-keyword{
            position:absolute;
            right:16px;
            top:0;
        }
        .remove-keyword i{
            color:red;
        }
        .preview-icon{
            height: 5em;
        }
        .category-checked{
            background: cornflowerblue;
        }
        .category-main{
            background: red;
        }
        .second-level{
            margin-left:10px;
        }
        .third-level{
            margin-left:20px;
        }
        .table input[type="text"] {
            border: none;
        }
        .name-char{
            font-weight: bold;
        }
        .delete_main_chars_block i{
            color:red;
        }
        .delete_main_chars_row i{
            color:red;
        }
        .add_main_chars_row{
            margin-right: 10px;
        }
        .add_main_chars_row i{
            color:green;
        }
        .glyphicon-plus{
            color: green;
            margin-right: 10px;
        }
        .glyphicon-edit{
            color: dodgerblue;
            margin-right: 40px;
        }
        .glyphicon-remove{
            color: red;
            margin-right: 10px;
        }
        .logo{
            height: 50px;
        }
        .info{
            height: 60px;
        }
        .success{
            min-height: 60px;
        }
        .warning{
            min-height: 60px;
        }
    </style>
    <div class="blank-page">
        <h2 class="title1">
            @if(empty($item->id))
                Добавление перевода на язык "{{$lang}}" к  институциональной аккредитации
            @else
                Редактирования перевода на язык "{{$lang}}" к   институциональной аккредитации
            @endif
        </h2>
        <form method="post" @if(empty($item->id))action="/admin/univer/nodes/main_accr/{{$parent->id}}/{{$lang}}/create" @else action="/admin/univer/nodes/main_accr/{{$item->id}}" @endif>
            {{csrf_field()}}
            <div class="blank-page">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                @if (session('error') or count($errors))
                    <div class="alert is-relative alert-error">
                        {{ session('error') }}
                        @foreach($errors->all() as $message)
                            {{$message}}
                        @endforeach

                    </div>
                @endif
                <ul id="myTabs" class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#main" id="main-tab" role="tab" data-toggle="tab" aria-controls="main" aria-expanded="false">Основная информация</a>
                    </li>
                    <li role="presentation" >
                        <a href="#vek" id="vek-tab" role="tab" data-toggle="tab" aria-controls="main" aria-expanded="false">Комиссия ВЭК</a>
                    </li>
                </ul>
                <script src="{{ asset("vendor/laravel-filemanager/js/stand-alone-button.js") }}"></script>
                <div id="myTabContent" class="tab-content scrollbar1">
                    <div role="tabpanel" class="tab-pane fade active in" id="main" aria-labelledby="main-tab">
                        <hr>
                        <div class="form-group">
                            <label for="license">Лицензия:</label>
                            <input type="text" id="license" class="form-control"  value="{{$item->license}}" name="license" >
                        </div>
                        <div class="form-group">
                            <label for="org_form">Организационно-правовая форма:</label>
                            <input type="text" id="org_form" class="form-control"  value="{{$item->org_form}}" name="org_form" >
                        </div>
                        <div class="form-group">
                            <label for="notation">Примечание:</label>
                            <input type="text" id="notation" class="form-control"  value="{{$item->notation}}" name="notation" >
                        </div>
                        <button type="submit" class=" btn btn-success"> СОХРАНИТЬ</button>
                    </div>
                    <div role="tabpanel" class="tab-pane fade in" id="vek" aria-labelledby="vek-tab">
                        <hr>
                        <h2>Данные о комиссии</h2>
                        <hr>
                        <div class="form-group">
                            <label for="main_image">Отчет ВЭК</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                  <a data-inputid="report_doc" class="btn btn-primary popup_selector">
                                     <i class="fa fa-picture-o"></i> Выберите документ
                                    </a>
                                </span>
                                <input id="report_doc" class="form-control" type="text" value="{{$item->report_doc}}" name="report_doc">
                            </div>
                            <div class="form-group">
                                <label for="report_doc_lang_select">Отчет ВЭК язык:</label>
                                <select name="report_doc_lang_select" id="report_doc_lang">
                                    <option value="0">
                                        Другой язык
                                    </option>
                                    <option value="@if($lang =='kz')Қаз @elseif($lang == 'en') Kaz @else Каз @endif"   @if($item->report_doc_lang == 'Каз' || $item->report_doc_lang == 'Қаз' || $item->report_doc_lang == 'Kaz') selected="selected" @endif>
                                        @if($lang == 'kz') Қаз @elseif($lang == 'en') Kaz @else Каз @endif
                                    </option>
                                    <option value="@if($lang =='kz') Орыс @elseif($lang == 'en') Rus @else Рус @endif" @if($item->report_doc_lang == 'Рус' || $item->report_doc_lang == 'Rus' || $item->report_doc_lang == 'Орыс' ) selected="selected" @endif>
                                        @if($lang =='kz')
                                            Орыс
                                        @elseif($lang == 'en')
                                        Rus
                                        @else
                                        Рус
                                        @endif
                                    </option>
                                    <option value="@if($lang =='kz') Ағыл @elseif($lang == 'en') Eng @else Анг @endif" @if($item->report_doc_lang == 'Ағыл' || $item->report_doc_lang == 'Eng' || $item->report_doc_lang == 'Анг' ) selected="selected" @endif>
                                        @if($lang =='kz')
                                            Ағыл
                                        @elseif($lang == 'en')
                                        Eng
                                        @else
                                        Анг
                                        @endif
                                    </option>
                                </select>
                                <input type="text" id="report_doc_lang" class="form-control"  value="{{$item->report_doc_lang}}" placeholder="Отчет ВЭК язык" name="report_doc_lang_input" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="main_image">Решение Аккредитационного Совета</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                  <a data-inputid="decision_doc" class="btn btn-primary popup_selector">
                                     <i class="fa fa-picture-o"></i> Выберите документ
                                    </a>
                                </span>
                                <input id="decision_doc" class="form-control" type="text" value="{{$item->decision_doc}}" name="decision_doc">
                            </div>
                            <div class="form-group">
                                <label for="decision_doc_lang">Решение Аккредитационного Совета язык:</label>
                                <select name="decision_doc_lang_select" id="">
                                    
                                    <option value="0">
                                        Другой язык
                                    </option>
                                    <option value="@if($lang =='kz')Қаз @elseif($lang == 'en') Kaz @else Каз @endif"    @if($item->decision_doc_lang == 'Қаз' || $item->decision_doc_lang == 'Kaz' || $item->decision_doc_lang == 'Каз' ) selected="selected" @endif>
                                        @if($lang == 'kz') Қаз @elseif($lang == 'en') Kaz @else Каз @endif
                                    </option>
                                    <option value="@if($lang =='kz') Орыс @elseif($lang == 'en') Rus @else Рус @endif" @if($item->decision_doc_lang == 'Рус' || $item->decision_doc_lang == 'Rus' || $item->decision_doc_lang == 'Орыс' ) selected="selected" @endif>
                                        @if($lang =='kz')
                                            Орыс
                                        @elseif($lang == 'en')
                                        Rus
                                        @else
                                        Рус
                                        @endif
                                    </option>
                                    <option value="@if($lang =='kz') Ағыл @elseif($lang == 'en') Eng @else Анг @endif" @if($item->decision_doc_lang == 'Анг' || $item->decision_doc_lang == 'Eng' || $item->decision_doc_lang == 'Ағыл' ) selected="selected" @endif>
                                        @if($lang =='kz')
                                            Ағыл
                                        @elseif($lang == 'en')
                                        Eng
                                        @else
                                        Анг
                                        @endif
                                    </option>
                                </select>
                                <input type="text" id="decision_doc_lang" class="form-control"  value="{{$item->decision_doc_lang}}" placeholder="Другой язык" name="decision_doc_lang_input" >
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="main_image">Состав ВЭК</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                  <a data-inputid="committee_consist_doc"  class="btn btn-primary popup_selector">
                                     <i class="fa fa-picture-o"></i> Выберите документ
                                    </a>
                                </span>
                                <input id="committee_consist_doc" class="form-control" type="text" value="{{$item->committee_consist_doc}}" name="committee_consist_doc">
                            </div>
                            <div class="form-group">
                                <label for="committee_consist_doc_lang">Состав ВЭК язык:</label>
                                <select name="committee_consist_doc_lang_select" id="">
                                    <option value="0">
                                        Другой язык
                                    </option>
                                    <option value="@if($lang =='kz')Қаз @elseif($lang == 'en') Kaz @else Каз @endif"    @if($item->committee_consist_doc_lang == 'Қаз' || $item->committee_consist_doc_lang == 'Kaz' || $item->committee_consist_doc_lang == 'Каз' ) selected="selected" @endif>
                                        @if($lang == 'kz') Қаз @elseif($lang == 'en') Kaz @else Каз @endif
                                    </option>
                                    <option value="@if($lang =='kz') Орыс @elseif($lang == 'en') Rus @else Рус @endif" @if($item->committee_consist_doc_lang == 'Рус' || $item->committee_consist_doc_lang == 'Rus' || $item->committee_consist_doc_lang == 'Орыс' ) selected="selected" @endif>
                                        @if($lang =='kz')
                                            Орыс
                                        @elseif($lang == 'en')
                                        Rus
                                        @else
                                        Рус
                                        @endif
                                    </option>
                                    <option value="@if($lang =='kz') Ағыл @elseif($lang == 'en') Eng @else Анг @endif" @if($item->committee_consist_doc_lang == 'Анг' || $item->committee_consist_doc_lang == 'Eng' || $item->committee_consist_doc_lang == 'Ағыл' ) selected="selected" @endif>
                                        @if($lang =='kz')
                                            Ағыл
                                        @elseif($lang == 'en')
                                        Eng
                                        @else
                                        Анг
                                        @endif
                                    </option>
                                </select>
                                <input type="text" id="committee_consist_doc_lang" class="form-control"  value="{{$item->committee_consist_doc_lang}}" name="committee_consist_doc_lang_input" placeholder="Состав ВЭК язык">
                            </div>
                        </div>
                        <div class="form-group">
                                <label for="main_image">Дополнительный документ</label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                      <a data-inputid="other_doc" class="btn btn-primary popup_selector">
                                         <i class="fa fa-picture-o"></i> Выберите документ
                                        </a>
                                    </span>
                                    <input id="other_doc" class="form-control" type="text" value="{{$item->other_doc}}" name="other_doc">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="other_doc_name">Дополнительный документ название:</label>
                                <input type="text" id="other_doc_name" class="form-control"  value="{{$item->other_doc_name}}" name="other_doc_name" >
                            </div>
                        <script>
                            $(document).ready(function(){
                                $('#report_doc_picker').filemanager('image');
                                $('#decision_doc_picker').filemanager('image');
                                $('#committee_consist_doc_picker').filemanager('image');
                                $('#other_doc_picker').filemanager('image')
                            });
                        </script>
                        <button type="submit" class=" btn btn-success"> СОХРАНИТЬ</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection