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
            @if(!empty($item->id))
                Редактирование перевода на язык "{{$lang}}" документа "{{$parent->title}}"  к новости
            @else
                Добавление перевода на язык "{{$lang}}" документа "{{$parent->title}}" к новости
            @endif

        </h2>
        <script src="{{ asset("vendor/laravel-filemanager/js/stand-alone-button.js") }}"></script>
        <form method="post" @if(empty($item->id))action="/admin/articles/nodes/attachment/create/{{$parent->id}}/{{$lang}}" @else action="/admin/articles/nodes/attachment/{{$item->id}}/{{$lang}}" @endif>
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
                </ul>
                <div id="myTabContent" class="tab-content scrollbar1">
                    <div role="tabpanel" class="tab-pane fade active in" id="main" aria-labelledby="main-tab">
                        <hr>
                        <div class="form-group">
                            <label for="title">Название документа:</label>
                            <input type="text" id="title" class="form-control"  value="{{$item->title}}" name="title" >
                        </div>
                        <div class="form-group">
                            <label for="short_desc">Краткое описание:</label>
                            <textarea  id="short_desc" class="form-control"   name="short_desc" >{{$item->short_desc}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">Картинка превью</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                  <a id="image_picker" data-input="image" class="btn btn-primary">
                                     <i class="fa fa-picture-o"></i> Выберите документ
                                    </a>
                                </span>
                                <input readonly="readonly" id="image" class="form-control" type="text" value="{{$item->image}}" name="image">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="file">Документ</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                  <a id="file_picker" data-input="file" class="btn btn-primary">
                                     <i class="fa fa-picture-o"></i> Выберите документ
                                    </a>
                                </span>
                                <input readonly="readonly" id="file" class="form-control" type="text" value="{{$item->file}}" name="file">
                            </div>
                        </div>
                        <button type="submit" class=" btn btn-success"> СОХРАНИТЬ</button>
                    </div>

                    <script>
                        $(document).ready(function(){
                            $('#image_picker').filemanager('image');
                            $('#file_picker').filemanager('image');
                        });
                    </script>


                </div>



            </div>

        </form>

    </div>





@endsection
