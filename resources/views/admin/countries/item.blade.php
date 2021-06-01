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
            $('.delete_node').on('click',function(){
                var item_id = $(this).attr('itemid');
                var item_name = $(this).attr('itemname');
                $('#delete_node_form').attr('action','/admin/countries/nodes/delete/'+item_id);
                $('#delete_node_title').html('Удаление перевода"'+item_name+'"');
            });
            $('.form_datetime').datetimepicker({
                language:  'ru',
                weekStart: 1,
                todayBtn:  1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                forceParse: 0,
                showMeridian: 1,
                minView: 2
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
                Добавление страны
            @else
                Редактирование страны "{{$item->title}}"
            @endif
        </h2>
        <form method="post" @if(empty($item->id))action="/admin/countries/create" @else action="/admin/countries/{{$item->id}}" @endif>
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
                    @if(!empty($item->id))
                        <li role="presentation" >
                            <a href="#translations" id="translations-tab" role="tab" data-toggle="tab" aria-controls="main" aria-expanded="false">Переводы</a>
                        </li>
                    @endif

                </ul>
                <div id="myTabContent" class="tab-content scrollbar1">
                    <div role="tabpanel" class="tab-pane fade active in" id="main" aria-labelledby="main-tab">
                        <hr>
                        <div class="form-group">
                            <label for="title">Название страны:</label>
                            <input type="text" id="title" class="form-control"  value="{{$item->title}}" name="title" >
                        </div>
                        <div class="form-group">
                            <label for="main_image">Флаг</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                  <a id="main_image_picker" data-input="main_image" data-preview="main_image_preview" class="btn btn-primary">
                                     <i class="fa fa-picture-o"></i> Выберите картинку
                                    </a>
                                </span>
                                <input readonly="readonly" id="main_image" class="form-control" type="text" value="{{$item->icon}}" name="icon">
                            </div>
                            <span id="main_image_preview" style="margin-top:15px;">
                                @if(isset($item->icon))
                                    <img src="{{$item->icon}}" class="preview-icon">
                                @endif
                             </span>
                        </div>
                        <div class="form-group">
                            <label for="sort_order">Порядок сортировки:</label>
                            <input type="number" id="sort_order" class="form-control"  value="{{$item->sort_order}}" name="sort_order" >
                        </div>
                        <div class="form-group">
                            <label for="is_registry">Доступна для РЕЕСТРА?</label>
                            <input type="checkbox"   class="tgl tgl-light" {{$item->is_registry ? 'checked' : ''}} name="is_registry" id="is_registry">
                            <label class="tgl-btn"   for="is_registry"></label>
                        </div>

                        <div class="form-group">
                            <label for="is_accr">Доступна для АККРЕДИТАЦИИ?</label>
                            <input type="checkbox"   class="tgl tgl-light" {{$item->is_accr ? 'checked' : ''}} name="is_accr" id="is_accr">
                            <label class="tgl-btn"   for="is_accr"></label>
                        </div>
                        <div class="form-group">
                            <label for="is_rating">Доступна для РЕЙТИНГА?</label>
                            <input type="checkbox"   class="tgl tgl-light" {{$item->is_rating ? 'checked' : ''}} name="is_rating" id="is_rating">
                            <label class="tgl-btn"   for="is_rating"></label>
                        </div>
                        <div class="form-group">
                            <label for="is_expert">Доступна для Эксперта?</label>
                            <input type="checkbox"   class="tgl tgl-light" {{$item->is_expert ? 'checked' : ''}} name="is_expert" id="is_expert">
                            <label class="tgl-btn"   for="is_expert"></label>
                        </div>

                        <script src="{{ asset("vendor/laravel-filemanager/js/stand-alone-button.js") }}"></script>
                        <script>
                            $(document).ready(function(){
                                $('#main_image_picker').filemanager('image');
                            });
                        </script>
                        <button type="submit" class=" btn btn-success"> СОХРАНИТЬ</button>
                    </div>
                    @if(!empty($item->id))
                        <div role="tabpanel" class="tab-pane fade in" id="translations" aria-labelledby="translations-tab">
                            <hr>
                            <h2>Список переводов</h2>
                            <hr>

                            @if(!($item->nodes()->where('lang','kz')->exists()))
                                <a style="display:block;margin-bottom:22px;" href="{{route('create_country_node',['lang' =>'kz','parent' => $item->id])}}"> <button type="button" class="btn btn-pri btn-success"><i class="fa fa-plus" aria-hidden="true"></i>Добавить перевод на казахский язык </button></a>
                            @endif
                            @if(!($item->nodes()->where('lang','en')->exists()))
                                <a style="display:block;margin-bottom:22px;" href="{{route('create_country_node',['lang' =>'en','parent' => $item->id])}}"> <button type="button" class="btn btn-pri btn-success"><i class="fa fa-plus" aria-hidden="true"></i>Добавить перевод на английский язык </button></a>
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
                                        <td><a href="{{route('edit_country_node',['item'=>$node->id])}}"><i class="glyphicon glyphicon-edit"></i></a><a class="delete_node" data-toggle="modal" data-target="#delete-node-modal" itemname="{{$node->lang}}" itemid="{{$node->id}}" href="#"><i class="glyphicon glyphicon-remove"></i></a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <button type="submit" class=" btn btn-success"> СОХРАНИТЬ</button>
                        </div>
                    @endif


                </div>
            </div>

        </form>

    </div>

    <div id="delete-node-modal" class="modal fade" tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="delete_node_title">Удаление </h4>
                </div>
                <div class="modal-body">
                    <form  action="задается скриптом" method="POST" id="delete_node_form">
                        {{ csrf_field() }}
                        <div class="form-group">
                            Удалить данный перевод?
                        </div>

                        <span id="holder" style="margin-top:15px;"></span>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                            <button type="submit" id="delete_element_button" class="btn btn-danger">Подтвердить удаление</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>





@endsection