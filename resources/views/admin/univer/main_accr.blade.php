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
                $('#delete_title').html('???????????????? ?????????? ??????????????"'+item_name+'"');
            });
            $('.delete_node').on('click',function(){
                var item_id = $(this).attr('itemid');
                var item_name = $(this).attr('itemname');
                $('#delete_item_form').attr('action','/admin/univer/nodes/main_accr/delete/'+item_id);
                $('#delete_title').html('???????????????? ?????????? ??????????????"'+item_name+'"');
            });
            $( "#report_doc_lang" ).change(function() {
			  	console.log('test');
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
    <script src="{{ asset("vendor/laravel-filemanager/js/stand-alone-button.js") }}"></script>
    <div class="blank-page">
        <h2 class="title1">
            @if(empty($item->id))
                ???????????????????? ?????????????????????????????????? ???????????????????????? ?? ???????????????????????? "{{$parent->title}}"
            @else
                ???????????????????????????? ?????????????????????????????????? ???????????????????????? ???????????????????????? "{{$parent->title}}"
            @endif
        </h2>
        <form method="post" @if(empty($item->id))action="/admin/univer/main_accr/{{$parent->id}}/create" @else action="/admin/univer/main_accr/{{$parent->id}}/{{$item->id}}" @endif>
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
                        <a href="#main" id="main-tab" role="tab" data-toggle="tab" aria-controls="main" aria-expanded="false">???????????????? ????????????????????</a>
                    </li>
                    <li role="presentation" >
                        <a href="#deqar" id="deqar-tab" role="tab" data-toggle="tab" aria-controls="deqar" aria-expanded="false">DEQAR</a>
                    </li>
                    <li role="presentation" >
                        <a href="#vek" id="vek-tab" role="tab" data-toggle="tab" aria-controls="main" aria-expanded="false">???????????????? ??????</a>
                    </li>
                    @if(!empty($item->id))
                        <li role="presentation" >
                            <a href="#translations" id="translations-tab" role="tab" data-toggle="tab" aria-controls="main" aria-expanded="false">????????????????</a>
                        </li>
                    @endif

                </ul>
                <div id="myTabContent" class="tab-content scrollbar1">
                    <div role="tabpanel" class="tab-pane fade active in" id="main" aria-labelledby="main-tab">
                        <hr>
                        <div class="form-group">
                            <label for="univer_type_id">?????? ?????????????????????? ??????????????????????:</label>
                            <select  class="select2 " id="univer_type_id"   name="univer_type_id">
                                @foreach(\App\Models\Univer::availableTypeIdArray() as $key=>$value)
                                    <option value="{{$value}}" @if($item->univer_type_id == $value) selected="selected" @endif>{{$key}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="unique_index">???????????????????? ????????????</label>
                            <input type="text" class="form-control"  value="{{$item->unique_index}}" name="unique_index" id="unique_index">
                        </div>
                        <div class="form-group">
                            <label for="years">???????? (??????):</label>
                            <input type="number" id="years" class="form-control"  value="{{$item->years}}" name="years" >
                        </div>
                        <div class="form-group">
                            <label for="dtp_input1" class=" control-label">???????? ???????????? ????????????????????????:</label>
                            <div class="input-group date form_datetime"  data-date-format="dd MM yyyy" data-link-field="date_start">
                                <input class="form-control" size="16" type="text" value="" readonly>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                            </div>
                            <input type="hidden" id="date_start" name="date_start"  value="{{$item->date_start}}" /><br/>
                        </div>
                        <div class="form-group">
                            <label for="dtp_input1" class=" control-label">???????? ?????????????????? ????????????????????????:</label>
                            <div class="input-group date form_datetime"  data-date-format="dd MM yyyy" data-link-field="date_end">
                                <input class="form-control" size="16" type="text" value="" readonly>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                            </div>
                            <input type="hidden" id="date_end" name="date_end" value="{{$item->date_end}}"/><br/>
                        </div>
                        <div class="form-group">
                            <label for="number">?????????????????????????????? ?????????? ???????????????????????? ????????:</label>
                            <input type="text" id="bin" class="form-control"  value="{{$item->bin}}" name="bin" >
                        </div>
                        <div class="form-group">
                            <label for="license">????????????????:</label>
                            <input type="text" id="license" class="form-control"  value="{{$item->license}}" name="license" >
                        </div>
                        <div class="form-group">
                            <label for="registration_number">?????????????????????????????? ?????????? ??????????????????????????:</label>
                            <input type="text" id="registration_number" class="form-control"  value="{{$item->registration_number}}" name="registration_number" >
                        </div>
                        <div class="form-group">
                            <label for="org_form">????????????????????????????-???????????????? ??????????:</label>
                            <input type="text" id="org_form" class="form-control"  value="{{$item->org_form}}" name="org_form" >
                        </div>
                        <div class="form-group">
                            <label for="notation">????????????????????:</label>
                            <input type="text" id="notation" class="form-control"  value="{{$item->notation}}" name="notation" >
                        </div>
                        <div class="form-group">
                            <label for="published">???????????????? ???????????????????????????????</label>
                            <input type="checkbox"   class="tgl tgl-light" {{$item->reakkr ? 'checked' : ''}} name="reaccr" id="reaccr">
                            <label class="tgl-btn"   for="reaccr"></label>
                        </div>
                        <div class="form-group">
                            <label for="ex_ante">???????????????? ex-ante?</label>
                            <input type="checkbox"   class="tgl tgl-light" {{$item->ex_ante ? 'checked' : ''}} name="ex_ante" id="ex_ante">
                            <label class="tgl-btn"   for="ex_ante"></label>
                        </div>
                        <div class="form-group">
                            <label for="partner">???????????????? ???????????????????? ?? ?????????????????? </label>
                            <input type="checkbox"   class="tgl tgl-light" {{$item->partner ? 'checked' : ''}} name="partner" id="partner">
                            <label class="tgl-btn"   for="partner"></label>
                        </div>
                        <button type="submit" class=" btn btn-success"> ??????????????????</button>
                    </div>
                    <div role="tabpanel" class="tab-pane fade  in" id="deqar" aria-labelledby="main-tab">
                        <hr>

                        <a style="display:block;margin-bottom:22px;" href="{{route('send_deqar_main',['item' => $item->id])}}"> <button type="button" class="btn btn-pri btn-success"><i class="fa " aria-hidden="true"></i>?????????????????? ???????????????????????? ?? DEQAR</button>   </a>
                        <div class="form-group">
                            <label for="">???????? ?????????????????? ???????????????? ????????????:</label>
                            <input type="text" id="" class="form-control" readonly="readonly" value="{{$item->deqar_send_date}}" name="" >
                        </div>

                        <div class="form-group">
                            <label for="deqar_type_id">?????? ???????????????????????? DEQAR:</label>
                            <select  class="select2 " id="deqar_type_id"   name="deqar_type_id">
                                @foreach($deqar_accr_types as $accr_type)
                                    <option value="{{$accr_type->id}}" @if($item->deqar_type_id == $accr_type->id) selected="selected" @endif>{{$accr_type->value}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="allow_deqar_sending">?????????????????? ???????????????? ???????????????? ?</label>
                            <input type="checkbox"   class="tgl tgl-light" {{$item->allow_deqar_sending ? 'checked' : ''}} name="allow_deqar_sending" id="allow_deqar_sending">
                            <label class="tgl-btn"   for="allow_deqar_sending"></label>
                        </div>

                        <div class="form-group">
                            <label for="deqar_status_id">???????????? "part of obligatory EQA system?" (???? ?????????????????? "voluntary")?</label>
                            <input type="checkbox"   class="tgl tgl-light" {{$item->deqar_status_id > 0  ? 'checked' : ''}} name="deqar_status_id" id="deqar_status_id">
                            <label class="tgl-btn"   for="deqar_status_id"></label>
                        </div>
                        <button type="submit" class=" btn btn-success"> ??????????????????</button>
                    </div>
                    <div role="tabpanel" class="tab-pane fade in" id="vek" aria-labelledby="vek-tab">
                        <hr>
                        <h2>???????????? ?? ????????????????</h2>
                        <hr>
                        <div class="form-group">
                            <label for="dtp_input1" class=" control-label">???????? ???????????? ????????????:</label>
                            <div class="input-group date form_datetime"  data-date-format="dd MM yyyy" data-link-field="visit_date_start">
                                <input class="form-control" size="16" type="text" value="" readonly>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                            </div>
                            <input type="hidden" id="visit_date_start" name="visit_date_start"  value="{{$item->visit_date_start}}" /><br/>
                        </div>
                        <div class="form-group">
                            <label for="dtp_input1" class=" control-label">???????? ?????????????????? ????????????:</label>
                            <div class="input-group date form_datetime"  data-date-format="dd MM yyyy" data-link-field="visit_date_end">
                                <input class="form-control" size="16" type="text" value="" readonly>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                            </div>
                            <input type="hidden" id="visit_date_end" name="visit_date_end" value="{{$item->visit_date_end}}"/><br/>
                        </div>
                        <div class="form-group">
                            <label for="main_image">?????????? ??????</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                  <a data-inputid="report_doc" class="btn btn-primary popup_selector">
                                     <i class="fa fa-picture-o"></i> ???????????????? ????????????????
                                    </a>
                                </span>
                                <input id="report_doc" class="form-control" type="text" value="{{$item->report_doc}}" name="report_doc">
                            </div>
                            <div class="form-group">
                                <label for="report_doc_lang_select">?????????? ?????? ????????:</label>
                                <select name="report_doc_lang_select" id="report_doc_lang">
                                	<option value="0">
                                		???????????? ????????
                                	</option>
                                	<option value="??????" @if($item->report_doc_lang == '??????') selected="selected" @endif>
                                		??????
                                	</option>
                                	<option value="??????" @if($item->report_doc_lang == '??????') selected="selected" @endif>
                                		??????
                                	</option>
                                	<option value="??????" @if($item->report_doc_lang == '??????') selected="selected" @endif>
                                		??????
                                	</option>
                                </select>
                                <input type="text" id="report_doc_lang" class="form-control"  value="{{$item->report_doc_lang}}" placeholder="?????????? ?????? ????????" name="report_doc_lang_input" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="main_image">?????????????? ?????????????????????????????????? ????????????</label>

                            <div class="input-group">
                                <span class="input-group-btn">
                                  <a data-inputid="decision_doc" class="btn btn-primary popup_selector">
                                     <i class="fa fa-picture-o"></i> ???????????????? ????????????????
                                    </a>
                                </span>
                                <input id="decision_doc" class="form-control" type="text" value="{{$item->decision_doc}}" name="decision_doc">
                            </div>
                            <div class="form-group">
                                <label for="decision_doc_lang">?????????????? ?????????????????????????????????? ???????????? ????????:</label>
                                <select name="decision_doc_lang_select" id="">
                                	<option value="0">
                                		???????????? ????????
                                	</option>
                                	<option value="??????" @if($item->decision_doc_lang == '??????') selected="selected" @endif>
                                		??????
                                	</option>
                                	<option value="??????" @if($item->decision_doc_lang == '??????') selected="selected" @endif>
                                		??????
                                	</option>
                                	<option value="??????" @if($item->decision_doc_lang == '??????') selected="selected" @endif>
                                		??????
                                	</option>
                                </select>
                                <input type="text" id="decision_doc_lang" class="form-control"  value="{{$item->decision_doc_lang}}" placeholder="???????????? ????????" name="decision_doc_lang_input" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="main_image">???????????? ??????</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                  <a data-inputid="committee_consist_doc"  class="btn btn-primary popup_selector">
                                     <i class="fa fa-picture-o"></i> ???????????????? ????????????????
                                    </a>
                                </span>
                                <input  id="committee_consist_doc" class="form-control" type="text" value="{{$item->committee_consist_doc}}" name="committee_consist_doc">
                            </div>
                            <div class="form-group">
                                <label for="committee_consist_doc_lang">???????????? ?????? ????????:</label>
                                <select name="committee_consist_doc_lang_select" id="">
                                	<option value="0">
                                		???????????? ????????
                                	</option>
                                	<option value="??????" @if($item->committee_consist_doc_lang == '??????') selected="selected" @endif>
                                		??????
                                	</option>
                                	<option value="??????" @if($item->committee_consist_doc_lang == '??????') selected="selected" @endif>
                                		??????
                                	</option>
                                	<option value="??????" @if($item->committee_consist_doc_lang == '??????') selected="selected" @endif>
                                		??????
                                	</option>
                                </select>
                                <input type="text" id="committee_consist_doc_lang" class="form-control"  value="{{$item->committee_consist_doc_lang}}" name="committee_consist_doc_lang_input" placeholder="???????????? ?????? ????????">
                            </div>
                            <div class="form-group">
                                <label for="main_image">???????????????????????????? ????????????????</label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                      <a data-inputid="other_doc" class="btn btn-primary popup_selector">
                                         <i class="fa fa-picture-o"></i> ???????????????? ????????????????
                                        </a>
                                    </span>
                                    <input id="other_doc" class="form-control" type="text" value="{{$item->other_doc}}" name="other_doc">
                                </div>


                            </div>
                            <div class="form-group">
                                <label for="other_doc_name">???????????????????????????? ???????????????? ????????????????:</label>
                                <input type="text" id="other_doc_name" class="form-control"  value="{{$item->other_doc_name}}" name="other_doc_name" >
                            </div>
                        </div>
                        <script>
                            $(document).ready(function(){
                                $('#report_doc_picker').filemanager('image');
                                $('#decision_doc_picker').filemanager('image');
                                $('#committee_consist_doc_picker').filemanager('image');
                                $('#other_doc_picker').filemanager('image')
                            });
                        </script>

                        <button type="submit" class=" btn btn-success"> ??????????????????</button>
                    </div>
                    @if(!empty($item->id))
                        <div role="tabpanel" class="tab-pane fade in" id="translations" aria-labelledby="translations-tab">
                            <hr>
                            <h2>???????????? ??????????????????</h2>
                            <hr>

                            @if(!($item->nodes()->where('lang','kz')->exists()))
                                <a style="display:block;margin-bottom:22px;" href="{{route('create_main_accr_node',['lang' =>'kz','parent' => $item->id])}}"> <button type="button" class="btn btn-pri btn-success"><i class="fa fa-plus" aria-hidden="true"></i>???????????????? ?????????????? ???? ?????????????????? ???????? </button></a>
                            @endif
                            @if(!($item->nodes()->where('lang','en')->exists()))
                                <a style="display:block;margin-bottom:22px;" href="{{route('create_main_accr_node',['lang' =>'en','parent' => $item->id])}}"> <button type="button" class="btn btn-pri btn-success"><i class="fa fa-plus" aria-hidden="true"></i>???????????????? ?????????????? ???? ???????????????????? ???????? </button></a>
                            @endif
                            <table class="table table-bordered">
                                <thead>
                                <tr> <th>ID </th><th> ???????? ????????????????</th> <th> ???????????????? </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($item->nodes()->get() as  $node)
                                    <tr class="success">
                                        <th scope="row">{{$node->id}}</th>
                                        <td>{{$node->lang}}</td>
                                        <td><a href="{{route('edit_main_accr_node',['item'=>$node->id])}}"><i class="glyphicon glyphicon-edit"></i></a><a class="delete_node" data-toggle="modal" data-target="#delete-node-modal" itemname="{{$node->lang}}" itemid="{{$node->id}}" href="#"><i class="glyphicon glyphicon-remove"></i></a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <button type="submit" class=" btn btn-success"> ??????????????????</button>
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
                    <h4 class="modal-title" id="delete_title">???????????????? </h4>
                </div>
                <div class="modal-body">
                    <form  action="???????????????? ????????????????" method="POST" id="delete_item_form">
                        {{ csrf_field() }}
                        <div class="form-group">
                            ?????????????? ???????????????
                        </div>

                        <span id="holder" style="margin-top:15px;"></span>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">????????????</button>
                            <button type="submit" id="delete_element_button" class="btn btn-danger">?????????????????????? ????????????????</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>




@endsection
