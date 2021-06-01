<!DOCTYPE html>
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
            Редактирование контактов
        </h2>
        <form method="post" action="/admin/other/contacts">
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

                    <li role="presentation" class="active">
                        <a href="#translations" id="translations-tab" role="tab" data-toggle="tab" aria-controls="main" aria-expanded="false">Переводы</a>
                    </li>


                </ul>
                    <script src="{{ asset("vendor/laravel-filemanager/js/stand-alone-button.js") }}"></script>
                <div id="myTabContent" class="tab-content scrollbar1">
                    <div role="tabpanel" class="tab-pane fade active in" id="main" aria-labelledby="main-tab">
                        <hr>
                        <div class="form-group">
                            <label for="address">Адрес:</label>
                            <input type="text" id="address" class="form-control"  value="{{$item->address}}" name="address" >
                        </div>
                        <div class="form-group">
                            <label for="phone_1">Телефон №1:</label>
                            <input type="text" id="phone_1" class="form-control"  value="{{$item->phone_1}}" name="phone_1" >
                        </div>
                        <div class="form-group">
                            <label for="phone_2">Телефон №2:</label>
                            <input type="text" id="phone_2" class="form-control"  value="{{$item->phone_2}}" name="phone_2" >
                        </div>
                        <div class="form-group">
                            <label for="fax">Факс:</label>
                            <input type="text" id="fax" class="form-control"  value="{{$item->fax}}" name="fax" >
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="text" id="email" class="form-control"  value="{{$item->email}}" name="email" >
                        </div>
                        <div class="form-group">
                            <label for="map_code">Код карты:</label>
                            <input type="text" id="map_code" class="form-control"  value="{{$item->map_code}}" name="map_code" >
                        </div>
                        <div class="form-group">
                            <label for="site">Адрес сайта:</label>
                            <input type="text" id="site" class="form-control"  value="{{$item->site}}" name="site" >
                        </div>
                        <div class="form-group">
                            <label for="fb_link">Ссылка на Facebook:</label>
                            <input type="text" id="fb_link" class="form-control"  value="{{$item->fb_link}}" name="fb_link" >
                        </div>
                        <div class="form-group">
                            <label for="youtube_link">Ссылка на YouTube:</label>
                            <input type="text" id="youtube_link" class="form-control"  value="{{$item->youtube_link}}" name="youtube_link" >
                        </div>
                        <script src="https://cdn.tiny.cloud/1/4iqdsgxu33edjknrgw8elp9e698blgtt685x0ob8uozetya0/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
                        <label for="text">Дополнительные контакты:</label>
                        <textarea name="text-editor" id="text" class="form-control my-editor">{!! $item->content !!}</textarea>
                    <button type="submit" class=" btn btn-success"> СОХРАНИТЬ</button>
                </div>

                <div role="tabpanel" class="tab-pane fade in" id="translations" aria-labelledby="translations-tab">
                    <hr>
                    <h2>Список переводов</h2>
                    <hr>

                    @if(!($item->nodes()->where('lang','kz')->exists()))
                        <a style="display:block;margin-bottom:22px;" href="{{route('edit_contacts_node',['lang' =>'kz'])}}"> <button type="button" class="btn btn-pri btn-success"><i class="fa fa-plus" aria-hidden="true"></i>Добавить перевод на казахский язык </button></a>
                    @endif
                    @if(!($item->nodes()->where('lang','en')->exists()))
                        <a style="display:block;margin-bottom:22px;" href="{{route('edit_contacts_node',['lang' =>'en'])}}"> <button type="button" class="btn btn-pri btn-success"><i class="fa fa-plus" aria-hidden="true"></i>Добавить перевод на английский язык </button></a>
                    @endif
                    <table class="table table-bordered">
                        <thead>
                        <tr> <th>ID </th><th> Язык перевода</th> <th> ОПЕРАЦИИ </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($item->nodes()->get() as  $node)
                            <tr class="success">
                                <th scope="row">{{$node->id}}</th>
                                <td>{{$node->lang}}</td>
                                <td><a href="{{route('edit_contacts_node',['lang' =>$node->lang])}}"><i class="glyphicon glyphicon-edit"></i></a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <button type="submit" class=" btn btn-success"> СОХРАНИТЬ</button>
                </div>



            </div>
            </div>

        </form>

    </div>

    <script> 
         $(document).ready(function(){    
            CKEDITOR.replace(`text-editor`, {
            filebrowserBrowseUrl: '/elfinder/ckeditor',
            filebrowserImageBrowseUrl: '/elfinder/ckeditor',
            uiColor: '#9AB8F3',
            height: 300
            });
        });        
    </script>



@endsection