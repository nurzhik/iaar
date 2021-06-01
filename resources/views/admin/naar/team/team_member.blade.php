@extends('layouts.admin')
@section('content')
    <script type="text/javascript">
        $(document).ready(function(){
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
    <div class="main-page">
        <h2 class="title1">
            @if(empty($item->id)) Добавление члена Нашей Команды @else Редактирование члена Нашей Команды @endif
        </h2>
        <form method="post"  @if(empty($item->id))action="/admin/naar/team-member/create" @else action="/admin/naar/team-member/{{$item->id}}" @endif>
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
                            <a href="#translations" id="translations-tab" role="tab" data-toggle="tab" aria-controls="translations" aria-expanded="false">Переводы</a>
                        </li>
                    </ul>
                    <div id="myTabContent" class="tab-content scrollbar1">
                        <div role="tabpanel" class="tab-pane fade active in" id="main" aria-labelledby="main-tab">
                    <div class="form-group">
                        <label for="name">Имя Фамилия</label>
                        <input type="text" class="form-control" required="required" value="{{$item->name}}" name="name" id="name">
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
                        <label for="job">Профессия</label>
                        <input type="text" class="form-control"   required="required"  value="{{$item->job}}" name="job" id="job">
                    </div>
                    <div class="form-group">
                        <label for="experience">Опыт работы</label>
                        <textarea name="experience" id="experience" class="form-control ">{{$item->experience}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="language">Знание языков</label>
                        <textarea name="language" id="language" class="form-control ">{{$item->languages}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="education">Образование</label>
                        <textarea name="education" id="education" class="form-control ">{{$item->education}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="qualities">Качества</label>
                        <textarea name="qualities" id="qualities" class="form-control ">{{$item->qualities}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="phone">Телефонный номер</label>
                        <input type="text" class="form-control"    value="{{$item->phone}}" name="phone" id="phone">
                    </div>
                    <div class="form-group">
                        <label for="email">Почта</label>
                        <input type="text" class="form-control"    value="{{$item->email}}" name="email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="skype">Skype</label>
                        <input type="text" class="form-control"     value="{{$item->skype}}" name="skype" id="skype">
                    </div>
                    <div class="form-group">
                        <label for="sort_order">Порядок сортировки</label>
                        <input type="number" class="form-control"   required="required"  value="{{$item->sort_order}}" name="sort_order" id="sort_order">
                    </div>

                    <script src="{{ asset("vendor/laravel-filemanager/js/stand-alone-button.js") }}"></script>
                    <script>
                        $(document).ready(function(){
                            $('#main_image_picker').filemanager('image');
                            $('#images_picker').filemanager('image');
                        });
                    </script>
                    <script src="{{ asset("vendor/laravel-filemanager/js/stand-alone-button.js") }}"></script>
                    <script>
                        $(document).ready(function(){
                            $('#lfm').filemanager('image');
                            $('#og_img_picker').filemanager('image');
                            $('#new-category-img-picker').filemanager('image');
                            $('#edit-category-img-picker').filemanager('image');
                        });
                    </script>



                    <hr>
                    <button type="submit" class=" btn btn-success"> СОХРАНИТЬ</button>
                        </div>
                        <div role="tabpanel" class="tab-pane fade in" id="translations" aria-labelledby="translations-tab">
                            <hr>
                            <h2>Список переводов</h2>
                            <hr>

                            @if(!($item->nodes()->where('lang','kz')->exists()))
                                <a style="display:block;margin-bottom:22px;" href="{{route('create_team_member_node',['lang' =>'kz','parent' => $item->id])}}"> <button type="button" class="btn btn-pri btn-success"><i class="fa fa-plus" aria-hidden="true"></i>Добавить перевод на казахский язык </button></a>
                            @endif
                            @if(!($item->nodes()->where('lang','en')->exists()))
                                <a style="display:block;margin-bottom:22px;" href="{{route('create_team_member_node',['lang' =>'en','parent' => $item->id])}}"> <button type="button" class="btn btn-pri btn-success"><i class="fa fa-plus" aria-hidden="true"></i>Добавить перевод на английский язык </button></a>
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
                                        <td><a href="{{route('edit_team_member_node',['item'=>$node->id])}}"><i class="glyphicon glyphicon-edit"></i></a><a class="delete_node" data-toggle="modal" data-target="#delete-node-modal" itemname="{{$node->lang}}" itemid="{{$node->id}}" href="#"><i class="glyphicon glyphicon-remove"></i></a></td>
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