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
            $('.delete_exist_direction').on('click',function(){
                var item_id = $(this).attr('itemid');
                $('#delete_exist_form').attr('action','/admin/experts/exist-dir/delete/'+item_id);
            });
            $('.delete_possible_direction').on('click',function(){
                var item_id = $(this).attr('itemid');
                $('#delete_possible_form').attr('action','/admin/experts/possible-dir/delete/'+item_id);
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
                Добавление эксперта
            @else
                Редактирование страницы  эксперта
            @endif
        </h2>
        <form method="post" @if(empty($item->id))action="/admin/experts/create" @else action="/admin/experts/{{$item->id}}" @endif>
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
                        <a href="#existing_directions" id="documents-tab" role="tab" data-toggle="tab" aria-controls="documents" aria-expanded="false">Фактические направления</a>
                    </li>
                    <li role="presentation" >
                        <a href="#possible_directions" id="seo-tab" role="tab" data-toggle="tab" aria-controls="seo" aria-expanded="false">Возможные направления</a>
                    </li>
                    @endif
                </ul>
                <div id="myTabContent" class="tab-content scrollbar1">
                    <div role="tabpanel" class="tab-pane fade active in" id="main" aria-labelledby="main-tab">
                        <hr>
                        <div class="form-group">
                            <label for="name">ФИО</label>
                            <input type="text" class="form-control" required="required" value="{{$item->name}}" name="name" id="name">
                        </div>
                        <div class="form-group">
                            <label for="certificate_number">Номер сертификата</label>
                            <input type="text" class="form-control" required="required" value="{{$item->certificate_number}}" name="certificate_number" id="certificate_number">
                        </div>
                        <div class="form-group">
                            <label for="dtp_input1" class=" control-label">Дата получения сертификата:</label>
                            <div class="input-group date form_datetime"  data-date-format="dd MM yyyy" data-link-field="dtp_input2">
                                <input class="form-control" size="16" type="text" value="" readonly>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                            </div>
                            <input type="hidden" id="dtp_input2" name="certificate_date" value="{{$item->certificate_date}}" /><br/>
                        </div>

                        @if($item->certificate_date)
                        <div class="form-group">
                            <label for="">сертификат действителен до:</label>
                            <input type="text" class="form-control" readonly="readonly" disabled="disabled" value="{{\Carbon\Carbon::parse($item->certificate_date)->addYears(5)->format('d.m.Y')}}" name="" id="">
                        </div>
                        @endif

                        <div class="form-group">
                            <label for="country">Страна эксперта</label>
                            <select  class="select2 form-control"    name="country_id" id="country_id">
                                <option>Нет страны</option>
                                @foreach(\App\Models\Country::where('is_expert',TRUE)->get() as $country)
                                    <option value="{{$country->id}}" @if($item->country_id == $country->id ) selected="selected" @endif >{{$country->title}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="category_id">Категория эксперта</label>
                            <select  class="form-control"    name="category_id" id="category_id">
                                @foreach(\App\Models\Expert::availableCategoryId() as $key=>$value)
                                    <option value="{{$value}}" @if($item->category_id == $value) selected="selected" @endif >{{$key}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="foreign_expert_type">Тип рекрутинга эксперта</label>
                            <select  class="form-control"    name="foreign_expert_type" id="foreign_expert_type">
                                <option>-</option>
                                @foreach(\App\Models\Expert::availableForeignExpertType() as $key=>$value)
                                    <option value="{{$value}}" @if($item->foreign_expert_type == $value) selected="selected" @endif >{{$key}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="category_number">Номер категории</label>
                            <select  class="form-control"    name="category_number" id="category_number">
                                @for($i = 1; $i<=3; $i++)
                                    <option value="{{$i}}" @if($i == $item->category_number) selected="selected" @endif>{{$i}}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="main_image">Фото</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                  <a data-inputid="main_image" data-preview="main_image_preview" class="btn btn-primary popup_selector">
                                     <i class="fa fa-picture-o"></i> Выберите картинку
                                    </a>
                                </span>
                                <input readonly="readonly" id="main_image" class="form-control" type="text" value="{{$item->photo}}" name="photo">
                            </div>
                            <span id="main_image_preview" style="margin-top:15px;">
                                @if(isset($item->main_image))
                                    <img src="{{$item->main_image}}" class="preview-icon">
                                @endif
                             </span>
                        </div>
                        <div class="form-group">
                            <label for="place_of_work" class="control-label">Место работы:</label>
                            <textarea name="place_of_work" id="place_of_work"  class="form-control">{{$item->place_of_work}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="position" class="control-label">Должность:</label>
                            <textarea name="position" id="position"  class="form-control">{{$item->position}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="academic_degrees" class="control-label">Категория, академическая степень, ученая степень, ученое звание, членство в профессиональных организациях</label>
                            <textarea name="academic_degrees" id="academic_degrees"  class="form-control">{{$item->academic_degrees}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="languages" class="control-label">Знание языков:</label>
                            <textarea name="languages" id="languages"  class="form-control">{{$item->languages}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="contacts" class="control-label">Контакты:</label>
                            <textarea name="contacts" id="contacts"  class="form-control">{{$item->contacts}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="published">Участвовал?</label>
                            <input type="checkbox"   class="tgl tgl-light" {{$item->is_participated ? 'checked' : ''}} name="is_participated" id="is_participated">
                            <label class="tgl-btn"   for="is_participated"></label>
                        </div>
                        <div class="form-group">
                            <label for="published">Является председателем?</label>
                            <input type="checkbox"   class="tgl tgl-light" {{$item->is_chairman ? 'checked' : ''}} name="is_chairman" id="is_chairman">
                            <label class="tgl-btn"   for="is_chairman"></label>
                        </div>


                        <script src="{{ asset("vendor/laravel-filemanager/js/stand-alone-button.js") }}"></script>
                        <script>
                            $(document).ready(function(){
                                $('#og_img_picker').filemanager('image');
                                $('#main_image_picker').filemanager('image')

                            });
                        </script>
                        <script src="{{ asset("vendor/laravel-filemanager/js/stand-alone-button.js") }}"></script>
                        <script>
                            $(document).ready(function(){
                                $('.documents_raw').filemanager('image');
                                $('#lfm').filemanager('image');
                                $('#og_img_picker').filemanager('image');
                                $('#new-category-img-picker').filemanager('image');
                                $('#edit-category-img-picker').filemanager('image');
                            });
                        </script>

                        <button type="submit" class=" btn btn-success"> СОХРАНИТЬ</button>
                    </div>
                    @if(!empty($item->id))
                    <div role="tabpanel" class="tab-pane fade " id="existing_directions" aria-labelledby="existing_directions-tab">
                        <hr>
                        <h3>Фактические направления</h3>
                        <hr>

                        <a style="display:block;margin-bottom:22px;" href="{{route('create_exist_direction',['parent' => $item])}}"> <button type="button" class="btn btn-pri btn-success"><i class="fa fa-plus" aria-hidden="true"></i>Добавить фактическое направение </button></a>
                        <div class="blank-page widget-shadow scroll">
                            <table class="table table-bordered">
                                <thead>
                                <tr> <th>Тип аккредитации </th><th>Название учреждения</th> <th>Дата визита</th> <th>Тип организации</th> <th>Направление</th> <th>Специализация</th><th> ОПЕРАЦИИ </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($item->existDirections()->get() as $direction)
                                    <tr class="success">
                                        <th scope="row">{{$direction->accr_type ? 'Програмная' : 'Институциональная'}}</th>
                                        <td>{{$direction->organization_title}}</td>
                                        <td>{{$direction->date_start}}  - {{$direction->date_end}}</td>
                                        <td>
                                            @foreach(\App\Models\Univer::availableTypeIdArray() as $key=>$value)
                                                @if($value == $direction->organization_type_id)
                                                    {{$key}}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{$direction->direction->title}}</td>
                                        <td>{{$direction->spec->title}}</td>
                                        <td><a href="{{route('edit_exist_direction',['parent' => $item,'item'=>$direction->id])}}"><i class="glyphicon glyphicon-edit"></i></a><a class="delete_exist_direction" data-toggle="modal" data-target="#delete-exist-modal"  itemid="{{$direction->id}}" href="#"><i class="glyphicon glyphicon-remove"></i></a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <button type="submit" class="submit_button btn btn-success">СОХРАНИТЬ</button>
                    </div>
                    <div role="tabpanel" class="tab-pane fade " id="possible_directions" aria-labelledby="possible_directions-tab">
                        <hr>
                        <h3>Возможные направления</h3>
                        <hr>

                        <a style="display:block;margin-bottom:22px;" href="{{route('create_possible_direction',['parent' => $item])}}"> <button type="button" class="btn btn-pri btn-success"><i class="fa fa-plus" aria-hidden="true"></i>Добавить возможное направение </button></a>
                        <div class="blank-page widget-shadow scroll">
                            <table class="table table-bordered">
                                <thead>
                                <tr> <th>Тип аккредитации </th> <th>Тип организации</th> <th>Направление</th> <th>Специализация</th><th> ОПЕРАЦИИ </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($item->possibleDirections()->get() as $direction)
                                    <tr class="success">
                                        <th scope="row">{{$direction->accr_type ? 'Програмная' : 'Институциональная'}}</th>
                                        <td>
                                            @foreach(\App\Models\Univer::availableTypeIdArray() as $key=>$value)
                                                @if($value == $direction->organization_type_id)
                                                    {{$key}}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{$direction->direction->title}}</td>
                                        <td>{{$direction->spec->title}}</td>
                                        <td><a href="{{route('edit_possible_direction',['parent' => $item,'item'=>$direction->id])}}"><i class="glyphicon glyphicon-edit"></i></a><a class="delete_possible_direction" data-toggle="modal" data-target="#delete-possible-modal"  itemid="{{$direction->id}}" href="#"><i class="glyphicon glyphicon-remove"></i></a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <button type="submit" class=" btn btn-success">СОХРАНИТЬ</button>
                    </div>
                    @endif
                </div>
            </div>
        </form>

    </div>

    <div id="delete-exist-modal" class="modal fade" tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="delete_title">Удаление фактического направления</h4>
                </div>
                <div class="modal-body">
                    <form  action="задается скриптом" method="POST" id="delete_exist_form">
                        {{ csrf_field() }}
                        <div class="form-group">
                            Удалить данное фактическое направление?
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
    <div id="delete-possible-modal" class="modal fade" tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >Удаление возможного направления</h4>
                </div>
                <div class="modal-body">
                    <form  action="задается скриптом" method="POST" id="delete_possible_form">
                        {{ csrf_field() }}
                        <div class="form-group">
                            Удалить данное возможное направление?
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