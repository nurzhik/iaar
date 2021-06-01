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
            $('.delete_main_accr').on('click',function(){
                var item_id = $(this).attr('itemid');
                $('#delete_main_accr_form').attr('action','/admin/univer/main_accr/delete/'+item_id);
            });
            $('.delete_program_accr').on('click',function(){
                var item_id = $(this).attr('itemid');
                $('#delete_program_accr_form').attr('action','/admin/univer/program_accr/delete/'+item_id);
            });
            $('.delete_vek_report').on('click',function(){
                var item_id = $(this).attr('itemid');
                $('#delete_vek_report_form').attr('action','/admin/univer/ext_report/delete/'+item_id);
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

              $('.delete_node').on('click',function(){
                var item_id = $(this).attr('itemid');
                var item_name = $(this).attr('itemname');
                $('#delete_node_form').attr('action','/admin/univer/nodes/univer/delete/'+item_id);
                $('#delete_node_title').html('Удаление перевода"'+item_name+'"');
            });

        });
    </script>
    <style>
        .non-vis{
            display:none;
        }
        .bordered-dir{
            border-style: solid;
            border-width: 5px;
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
                Добавление университета
            @else
                Редактирование университета "{{$item->title}}"
            @endif
        </h2>
        <form method="post" @if(empty($item->id))action="/admin/univer/create" @else action="/admin/univer/{{$item->id}}" @endif>
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
                        <li role="presentation" class="">
                            <a href="#main_accrs" id="documents-tab" role="tab" data-toggle="tab" aria-controls="documents" aria-expanded="false">Институциональные аккредитации</a>
                        </li>
                        <li role="presentation" class="">
                            <a href="#program_accrs" id="seo-tab" role="tab" data-toggle="tab" aria-controls="seo" aria-expanded="false">Программные аккредитации</a>
                        </li>
                        <li role="presentation" class="">
                            <a href="#reports" id="seo-tab" role="tab" data-toggle="tab" aria-controls="seo" aria-expanded="false">Отчеты ВЭК</a>
                        </li>
                        <li role="presentation" class="">
                            <a href="#translations" id="translations-tab" role="tab" data-toggle="tab" aria-controls="seo" aria-expanded="false">Переводы</a>
                        </li>
                    @endif
                </ul>
                <div id="myTabContent" class="tab-content scrollbar1">
                    <div role="tabpanel" class="tab-pane fade active in" id="main" aria-labelledby="main-tab">
                        <hr>
                        <div class="form-group">
                            <label for="title">Название университета</label>
                            <input type="text" class="form-control" required="required" value="{{$item->title}}" name="title" id="title">
                        </div>
                        <div class="form-group">
                            <label for="unique_index">Уникальный индекс</label>
                            <input type="text" class="form-control"  value="{{$item->unique_index}}" name="unique_index" id="unique_index">
                        </div>
                        <div class="form-group">
                            <label for="country">Страна университета</label>
                            <select  class="form-control"    name="country_id" id="country">
                                <option>Нет страны</option>
                                @foreach(\App\Models\Country::where('is_registry',TRUE)->get() as $country)
                                    <option value="{{$country->id}}" @if($item->country_id == $country->id ) selected="selected" @endif >{{$country->title}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="deqar_univer_id">ID  университета в базе DEQAR</label>
                            <input type="text" class="form-control"  value="{{$item->deqar_univer_id}}" name="deqar_univer_id" id="deqar_univer_id">
                        </div>

                        <button type="submit" class=" btn btn-success"> СОХРАНИТЬ</button>
                    </div>
                    @if(!empty($item->id))
                        <div role="tabpanel" class="tab-pane fade " id="main_accrs" aria-labelledby="existing_directions-tab">
                            <hr>
                            <h3>Институциональные аккредитации</h3>
                            <hr>
                            <a style="display:block;margin-bottom:22px;" href="{{route('create_main_accr',['parent' => $item->id])}}"> <button type="button" class="btn btn-pri btn-success"><i class="fa fa-plus" aria-hidden="true"></i>Добавить аккредитацию </button></a>
                            <div class="blank-page widget-shadow scroll">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr> <th>id </th><th>Дата начала аккредитации</th> <th>Дата окончания аккредитации</th> <th>Время визита комиссии</th>  <th>Включена отправка в DEQAR?</th> <th> Дата успешной отправки в DEQAR</th> <th> ОПЕРАЦИИ </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($item->mainAccrs()->orderBy('date_end')->get() as $accr)
                                        <tr class="success">
                                            <th scope="row">{{$accr->id}}</th>
                                            <td>{{date('d.m.Y', strtotime($accr->date_start))}}</td>
                                            <td>{{date('d.m.Y', strtotime($accr->date_end))}}</td>
                                            <td>{{date('d.m.Y', strtotime($accr->visit_date_start))}} - {{date('d.m.Y', strtotime($accr->visit_date_end))}}</td>
                                            <td>{{$accr->allow_deqar_sending ? 'Да' : 'Нет'}}</td>
                                            <td>{{$accr->deqar_send_date ? date('d.m.Y', strtotime($accr->deqar_send_date)) : '-'}}</td>
                                            <td><a href="{{route('edit_main_accr',['parent' => $item->id,'item'=>$accr->id])}}"><i class="glyphicon glyphicon-edit"></i></a><a class="delete_main_accr" data-toggle="modal" data-target="#delete-inst-modal"  itemid="{{$accr->id}}" href="#"><i class="glyphicon glyphicon-remove"></i></a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <button type="submit" class="submit_button btn btn-success">СОХРАНИТЬ</button>
                        </div>
                        <div role="tabpanel" class="tab-pane fade " id="program_accrs" aria-labelledby="possible_directions-tab">
                            <hr>
                            <h3>Програмные аккредитации</h3>
                            <hr>
                            <a style="display:block;margin-bottom:22px;" href="{{route('create_program_accr',['parent' => $item->id])}}"> <button type="button" class="btn btn-pri btn-success"><i class="fa fa-plus" aria-hidden="true"></i>Добавить аккредитацию </button></a>
                            <div class="blank-page widget-shadow scroll">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr> <th>id </th><th>Программа</th>  <th>Скрытый номер для связи</th> <th>Реаккредитация</th> <th>Ex-ante</th> <th>Дата начала аккредитации</th> <th>Дата окончания аккредитации</th> <th>Время визита комиссии</th> <th>Включена отправка в DEQAR?</th> <th> Дата успешной отправки в DEQAR</th> <th> ОПЕРАЦИИ </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($item->programAccrs()->orderBy('hidden_relation_id')->get() as $accr)
                                        <tr class="success">
                                            <th scope="row">{{$accr->id}}</th>
                                            <th scope="row">{{$accr->program_index}} {{$accr->program_title}}</th>
                                            <th scope="row">{{$accr->hidden_relation_id}}</th>
                                            <th scope="row">{{$accr->reaccr ? 'Да' : 'Нет'}}</th>
                                            <th scope="row">{{$accr->ex_ante ? 'Да' : 'Нет'}}</th>
                                            <td>{{date('d.m.Y', strtotime($accr->date_start))}}</td>
                                            <td>{{date('d.m.Y', strtotime($accr->date_end))}}</td>
                                            <td>{{date('d.m.Y', strtotime($accr->visit_date_start))}} - {{date('d.m.Y', strtotime($accr->visit_date_end))}}</td>
                                            <td>{{$accr->allow_deqar_sending ? 'Да' : 'Нет'}}</td>
                                            <td>{{$accr->deqar_send_date ? date('d.m.Y', strtotime($accr->deqar_send_date)) : '-'}}</td>
                                            <td><a href="{{route('edit_program_accr',['parent' => $item->id,'item'=>$accr->id])}}"><i class="glyphicon glyphicon-edit"></i></a><a class="delete_program_accr" data-toggle="modal" data-target="#delete-program-modal"  itemid="{{$accr->id}}" href="#"><i class="glyphicon glyphicon-remove"></i></a> <a href="{{route('replicate_program_accr',['item'=>$accr->id])}}"><i class="glyphicon glyphicon-copy"></i></a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <button type="submit" class="submit_button btn btn-success">СОХРАНИТЬ</button>
                        </div>
                        <div role="tabpanel" class="tab-pane fade " id="reports" aria-labelledby="reports-tab">
                            <hr>
                            <h3>Список отчетов ВЭК</h3>
                            <hr>
                            <a style="display:block;margin-bottom:22px;" href="{{route('create_vek_report',['parent' => $item->id])}}"> <button type="button" class="btn btn-pri btn-success"><i class="fa fa-plus" aria-hidden="true"></i>Добавить отчет ВЭК </button></a>
                            <div class="blank-page widget-shadow scroll">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr> <th>id </th><th>Дата проведения отчета</th> <th> ОПЕРАЦИИ </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($item->extReports()->orderBy('date_start','DESC')->get() as $report)
                                        <tr class="success">
                                            <th scope="row">{{$report->id}}</th>
                                            <th scope="row">{{date('d.m.Y', strtotime($report->date_start))}} - {{date('d.m.Y', strtotime($report->date_end))}}</th>
                                            <td><a href="{{route('edit_vek_report',['item'=>$report->id])}}"><i class="glyphicon glyphicon-edit"></i></a><a class="delete_vek_report" data-toggle="modal" data-target="#delete-vek-modal"  itemid="{{$report->id}}" href="#"><i class="glyphicon glyphicon-remove"></i></a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <button type="submit" class="submit_button btn btn-success">СОХРАНИТЬ</button>
                        </div>
                        @if(!empty($item->id))
                            <div role="tabpanel" class="tab-pane fade in" id="translations" aria-labelledby="translations-tab">
                                <hr>
                                <h2>Список переводов</h2>
                                <hr>

                                @if(!($item->nodes()->where('lang','kz')->exists()))
                                    <a style="display:block;margin-bottom:22px;" href="{{route('create_univer_node',['lang' =>'kz','parent' => $item->id])}}"> <button type="button" class="btn btn-pri btn-success"><i class="fa fa-plus" aria-hidden="true"></i>Добавить перевод на казахский язык </button></a>
                                @endif
                                @if(!($item->nodes()->where('lang','en')->exists()))
                                    <a style="display:block;margin-bottom:22px;" href="{{route('create_univer_node',['lang' =>'en','parent' => $item->id])}}"> <button type="button" class="btn btn-pri btn-success"><i class="fa fa-plus" aria-hidden="true"></i>Добавить перевод на английский язык </button></a>
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
                                            <td><a href="{{route('edit_univer_node',['item'=>$node->id])}}"><i class="glyphicon glyphicon-edit"></i></a><a class="delete_node" data-toggle="modal" data-target="#delete-node-modal" itemname="{{$node->lang}}" itemid="{{$node->id}}" href="#"><i class="glyphicon glyphicon-remove"></i></a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <button type="submit" class=" btn btn-success"> СОХРАНИТЬ</button>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </form>

    </div>
    <div id="delete-inst-modal" class="modal fade" tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="delete_title">Удаление институциональной аккредитации</h4>
                </div>
                <div class="modal-body">
                    <form  action="задается скриптом" method="POST" id="delete_main_accr_form">
                        {{ csrf_field() }}
                        <div class="form-group">
                            Удалить данную институциональную аккредитацию?
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
    <div id="delete-program-modal" class="modal fade" tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >Удаление  программной аккредитации</h4>
                </div>
                <div class="modal-body">
                    <form  action="задается скриптом" method="POST" id="delete_program_accr_form">
                        {{ csrf_field() }}
                        <div class="form-group">
                            Удалить данную программную аккредитацию?
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
    <div id="delete-vek-modal" class="modal fade" tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >Удаление  отчета ВЭК</h4>
                </div>
                <div class="modal-body">
                    <form  action="задается скриптом" method="POST" id="delete_vek_report_form">
                        {{ csrf_field() }}
                        <div class="form-group">
                            Удалить данный отчет ВЭК?
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
