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


            $('#existing_directions').delegate('.type_org_exist','change',function(){
                let dir_id = $(this).data('id');
                let type_id = $(this).val();
                if(type_id !== '9999')
                {
                    $.ajax({
                        type: "POST",
                        url: "/admin/experts/get_directions",
                        dataType: "json",
                        data: {
                            base_type: type_id
                        },
                        success: function ( data ) {
                            // console.log(data);
                            if(typeof data.error !== "undefined")
                            {
                                alert('Произошла ошибка!');
                            }
                            else
                            {
                                //console.log(dir_id);
                                $('#existing_dirs_'+dir_id+'_direction_id').html('');
                                $('#existing_dirs_'+dir_id+'_direction_id').append('<option value="618">Пусто</option>');
                                for(var i = 0; i < data.items.length;i++)
                                {
                                    var NewOption = new Option(data.items[i].title,data.items[i].id,false,false);
                                    $('#existing_dirs_'+dir_id+'_direction_id').append(NewOption);

                                }
                                $('#existing_dirs_'+dir_id+'_direction_id').trigger('change');

                            }
                        },
                    });
                }
                else
                {

                    $('#existing_dirs_'+dir_id+'_direction_id').html('');
                    $('#existing_dirs_'+dir_id+'_direction_id').append('<option value="618">Пусто</option>');
                }
            });
            $('#existing_directions').delegate('.direction_select','change',function(){

                let dir_id = $(this).data('id');
                let parent_id = $(this).val();
                if(parent_id)
                {
                    $.ajax({
                        type: "POST",
                        url: "/admin/experts/get_specs",
                        dataType: "json",
                        data: {
                            direction_id: parent_id
                        },
                        success: function ( data ) {

                            if(typeof data.error !== "undefined")
                            {
                                alert('Произошла ошибка!');
                            }
                            else
                            {
                                console.log(data);
                                console.log(dir_id);
                                //console.log(dir_id);
                                $('#existing_dirs_'+dir_id+'_spec_id').html('');
                                $('#existing_dirs_'+dir_id+'_spec_id').html('<option value="408">Пусто</option>');
                                for(var i = 0; i < data.items.length;i++)
                                {
                                    var NewOption = new Option(data.items[i].title,data.items[i].id,false,false);
                                    $('#existing_dirs_'+dir_id+'_spec_id').append(NewOption);

                                }
                                $('#existing_dirs_'+dir_id+'_spec_id').trigger('change');

                            }
                        },
                    });

                }

            });
            $('#existing_directions').delegate('.remove-exist-dir','click',function(){
                var id = $(this).data('id');
                var direction_id = $('existing_dirs_'+id+'_id').val();
                if(typeof direction_id !== "undefined")
                {
                    $('#deleted_exist_dirs').append('<input type="hidden" name="delete_exist_dir[]" value="'+direction_id+'">');
                }
                $(this).parent().remove();

            });
            $('#existing_directions').delegate('.add_direction_modal_open','click',function(){
                var dir_id = $(this).data('id');
                var value = $('#existing_dirs_'+dir_id+'_organization_type_id').val();
                $('#modal_base_type').val(value);
                $('#add_direction_button').attr('data-id',dir_id);
            });
            $('#existing_directions').delegate('.add_spec_modal_open','click',function(){
                var dir_id = $(this).data('id');
                var value = $('#existing_dirs_'+dir_id+'_direction_id').val();
                var text = $('#existing_dirs_'+dir_id+'_direction_id option:selected').text();
                $('#modal_spec_direction_id').val(value);
                $('#modal_spec_title').html('Добавление специализации к направлению "'+text+'"');
                $('#add_spec_button').attr('data-id',dir_id);
            });
            $('#add_direction_button').on('click',function(event){
                event.preventDefault();
                var value = $('#modal_direction_title').val();
                var base_type = $('#modal_base_type').val();
                var dir_id = $(this).data('id');
                if(value.length <1)
                {
                    $('#direction_hint').removeClass('non-vis');
                }
                else
                {
                    $('#direction_hint').addClass('non-vis');
                    $.ajax({
                        type: "POST",
                        url: "/admin/experts/create_direction",
                        dataType: "json",
                        data: {
                            title: value,
                            base_type: base_type
                        },
                        success: function ( data ) {
                            // console.log(data);
                            if(typeof data.error !== "undefined")
                            {
                                alert('Произошла ошибка!');
                            }
                            else
                            {
                                $('#existing_dirs_'+dir_id+'_organization_type_id').trigger('change');
                                $('#add-direction-modal').modal('hide');
                            }
                        },
                    });

                }

            });
            $('#add_spec_button').on('click',function(event){
                event.preventDefault();
                var value = $('#modal_spec_title').val();
                var direction_id = $('#modal_spec_direction_id').val();
                var dir_id = $(this).data('id');
                if(value.length <1)
                {
                    $('#spec_hint').removeClass('non-vis');
                }
                else
                {
                    $('#spec_hint').addClass('non-vis');
                    $.ajax({
                        type: "POST",
                        url: "/admin/experts/create_spec",
                        dataType: "json",
                        data: {
                            title: value,
                            direction_id: direction_id
                        },
                        success: function ( data ) {
                            // console.log(data);
                            if(typeof data.error !== "undefined")
                            {
                                alert('Произошла ошибка!');
                            }
                            else
                            {
                                $('#existing_dirs_'+dir_id+'_direction_id').trigger('change');
                                $('#add-spec-modal').modal('hide');
                            }
                        },
                    });

                }
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
            $('#existing_dirs_1_organization_type_id').trigger('change');
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
                Добавление фактического направления к эксперту {{$parent->name}}
            @else
                Редактирование фактического направления эксперта  {{$parent->name}}
            @endif
        </h2>
        <form method="post" @if(empty($item->id))action="/admin/experts/exist-dir/{{$parent->id}}/create" @else action="/admin/experts/exist-dir/{{$parent->id}}/{{$item->id}}" @endif>
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
                        <div class="bordered-dir " id="existing_directions">
                            <button type="button" data-id="1" class="close remove-exist-dir" ><span class="glyphicon glyphicon-remove"></span></button>
                            <div class="form-group">
                                <label for="foreign_expert_type">Тип аккредитации:</label>
                                <select  class="form-control"    name="accr_type">
                                    <option value="0" @if($item->accr_type == 0) selected="selected" @endif >Институциональная</option>
                                    <option value="1" @if($item->accr_type == 1) selected="selected" @endif>Программная</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Название организации</label>
                                <input type="text" class="form-control"  value="{{$item->organization_title}}" name="organization_title" >
                            </div>
                            <div class="form-group">
                                <label for="dtp_input1" class=" control-label">Дата начала визита:</label>
                                <div class="input-group date form_datetime"  data-date-format="dd MM yyyy" data-link-field="existing_dirs_1_date_start">
                                    <input class="form-control" size="16" type="text" value="" readonly>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                </div>
                                <input type="hidden" id="existing_dirs_1_date_start" name="date_start"  value="{{$item->date_start}}" /><br/>
                            </div>
                            <div class="form-group">
                                <label for="dtp_input1" class=" control-label">Дата окончания визита:</label>
                                <div class="input-group date form_datetime"  data-date-format="dd MM yyyy" data-link-field="existing_dirs_1_date_end">
                                    <input class="form-control" size="16" type="text" value="" readonly>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                </div>
                                <input type="hidden" id="existing_dirs_1_date_end" name="date_end" value="{{$item->date_end}}"/><br/>
                            </div>
                            <div class="form-group">
                                <label for="foreign_expert_type">Тип организации образования:</label>
                                <select  class="form-control type_org_exist"   id="existing_dirs_1_organization_type_id" data-id="1"  name="organization_type_id">
                                    <option value="9999"> - </option>
                                    @foreach(\App\Models\Univer::availableTypeIdArray() as $key=>$value)
                                        <option value="{{$value}}" @if($item->organization_type_id == $value) selected="selected" @endif>{{$key}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label data-id="1" for="existing_dirs_1_direction_id">Направление:</label>
                                    <select class="select2 direction_select" data-id="1" id="existing_dirs_1_direction_id" name="direction_id">
                                        @if($item->organization_type_id)
                                            @foreach(\App\Models\ExpertDirection::where('base_type',$item->organization_type_id)->get() as $dir)
                                                <option value="{{$dir->id}}" @if($item->direction_id == $dir->id) selected="selected" @endif>{{$dir->title}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="button"  data-toggle="modal" data-target="#add-direction-modal"  data-id="1" class="btn btn-pri btn-success add_direction_modal_open"><i class="fa fa-plus" aria-hidden="true"></i>Добавить направление</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label for="existing_dirs_1_spec_id">Специализация:</label>
                                    <select  class="select2" id="existing_dirs_1_spec_id"   name="spec_id">
                                        @if($item->direction_id)
                                            @foreach(\App\Models\ExpertSpec::where('direction_id',$item->direction_id)->get() as $spec)
                                                <option value="{{$spec->id}}" @if($spec->spec_id == $spec->id) selected="selected" @endif>{{$spec->title}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="button" data-id="1"  data-toggle="modal" data-target="#add-spec-modal" class="btn btn-pri btn-success add_spec_modal_open"><i class="fa fa-plus" aria-hidden="true"></i>Добавить специализацию</button>
                                </div>
                            </div>
                        </div>


                        <button type="submit" class=" btn btn-success"> СОХРАНИТЬ</button>
                    </div>


                </div>
            </div>
        </form>

    </div>
    <div id="add-direction-modal" class="modal fade" tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="new_comment_title">Добавить новое направление</h4>
                </div>
                <div class="modal-body">
                    <form id="add_direction_form">

                        <div class="form-group">
                            <label for="name">Название направления</label>
                            <input type="text" class="form-control" required="required" value="" id="modal_direction_title" name="title" >
                        </div>
                        <div class="form-group">
                            <label for="foreign_expert_type">Тип организации образования:</label>
                            <select  class="form-control"   id="modal_base_type" name="base_type">
                                <option value="0">Организации высшего и послевузовского образования</option>
                                <option value="1">Медицинские организации высшего и послевузовского образования</option>
                                <option value="2">Организации ТиПО</option>
                                <option value="3">Медицинские организации ТиПО</option>
                                <option value="4">Организации среднего образования (международные школы)</option>
                                <option value="5">Организации дополнительного образования</option>
                                <option value="6">НИИ</option>
                            </select>
                        </div>
                        <div class="non-vis" id="direction_hint" style="color:red;">
                            Пожалуйста, введите название направления
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                            <button type="button" id="add_direction_button" class="btn btn-primary">Добавить</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div id="add-spec-modal" class="modal fade" tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modal_spec_titl">Добавить новую специализацию</h4>
                </div>
                <div class="modal-body">
                    <form id="add_spec_form">
                        <div class="form-group">
                            <label for="name">Название специализации</label>
                            <input type="text" class="form-control" required="required" value="" id="modal_spec_title" name="title" >
                        </div>
                        <input type="hidden" value="" name="direction_id" id="modal_spec_direction_id">
                        <div class="non-vis" id="spec_hint" style="color:red;">
                            Пожалуйста, введите название специализации
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                            <button type="button" id="add_spec_button" data-id="1" class="btn btn-primary">Добавить</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>




@endsection