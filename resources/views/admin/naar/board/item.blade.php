<!DOCTYPE html>
@extends('layouts.admin')
@section('content')
    <script type="text/javascript">
        $(document).ready(function(){
            $('.delete_node').on('click',function(){
                var item_id = $(this).attr('itemid');
                $('#delete_node_form').attr('action','/admin/naar/board/nodes/delete/'+item_id);
                $('#delete_node_title').html('Удаление перевода"'+item_name+'"');
            });
            function translit(text) {
                // Символ, на который будут заменяться все спецсимволы
                var space = '-';

                // Массив для транслитерации
                var transl = {
                    'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'e', 'ж': 'zh',
                    'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n',
                    'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h',
                    'ц': 'c', 'ч': 'ch', 'ш': 'sh', 'щ': 'sh', 'ъ': '', 'ы': 'y', 'ь': '', 'э': 'e', 'ю': 'yu', 'я': 'ya',
                    ' ': space, '_': space, '`': space, '~': space, '!': space, '@': space,
                    '#': space, '$': space, '%': space, '^': space, '&': space, '*': space,
                    '(': space, ')': space, '-': space, '\=': space, '+': space, '[': space,
                    ']': space, '\\': space, '|': space, '/': space, '.': space, ',': space,
                    '{': space, '}': space, '\'': space, '"': space, ';': space, ':': space,
                    '?': space, '<': space, '>': space, '№': space,
                    'ә': 'a', 'Ә': 'a',
                    'Ғ': 'g', 'ғ': 'g',
                    'Ө': 'o', 'ө': 'o',
                    'Қ': 'k', 'қ': 'k',
                    'ң': 'n', 'і': 'i',
                    'Ұ': 'u', 'ұ': 'u',
                    'Ү': 'u', 'ү': 'u'
                };

                var result = '';
                var curent_sim = '';

                for (i = 0; i < text.length; i++) {
                    // Если символ найден в массиве то меняем его
                    if (transl[text[i]] != undefined) {
                        if (curent_sim != transl[text[i]] || curent_sim != space) {
                            result += transl[text[i]];
                            curent_sim = transl[text[i]];
                        }
                    }
                    // Если нет, то оставляем так как есть
                    else {
                        result += text[i];
                        curent_sim = text[i];
                    }
                }

                return result;
            }

            if ($('[name="title"]').length && $('[name="slug').length) {
                $('[name="title').on('keyup', function () {
                    $('[name="slug').val(translit($(this).val().toLowerCase()));
                });
            }
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
                $('#delete_item_form').attr('action','/admin/naar/board-member/delete/'+item_id);
                $('#delete_title').html('Удаление члена совета"'+item_name+'"');
            });
            $('.delete_tab').on('click',function(){
                var item_id = $(this).attr('itemid');
                var item_name = $(this).attr('itemname');
                $('#delete_item_form').attr('action','/admin/naar/commisiontabs/delete/'+item_id);
                $('#delete_title').html('Удаление члена команды"'+item_name+'"');
            });
            $('.delete_file').on('click',function(){
                var item_id = $(this).attr('itemid');
                var item_name = $(this).attr('itemname');
                $('#delete_item_form').attr('action','/admin/naar/files/delete/'+item_id);
                $('#delete_title').html('Удаление файла"'+item_name+'"');
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
            @if(empty($item->id))
                Добавление новой страницы списка совета
            @else
                Редактирование страницы списка совета "{{$item->title}}"
            @endif
        </h2>
        <form method="post" @if(empty($item->id))action="/admin/naar/board/create" @else action="/admin/naar/board/{{$item->id}}" @endif>
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
                        <a href="#documents" id="documents-tab" role="tab" data-toggle="tab" aria-controls="documents" aria-expanded="false">Документы</a>
                    </li>
                    @if(!empty($item->id))
                    <li role="presentation" >
                        <a href="#team" id="documents-tab" role="tab" data-toggle="tab" aria-controls="documents" aria-expanded="false">Члены совета</a>
                    </li>
                    @endif
                    @if($item->id == 57)
                        <li role="presentation">
                            <a href="#commision" id="commision-tab" role="tab" data-toggle="tab" aria-controls="commision" aria-expanded="false">Табы</a>
                        </li>
                        <li role="presentation">
                            <a href="#commisionfile" id="commisionfile-tab" role="tab" data-toggle="tab" aria-controls="commisionfile" aria-expanded="false">Файлы</a>
                        </li>
                    @endif
                    <li role="presentation">
                        <a href="#seo" id="seo-tab" role="tab" data-toggle="tab" aria-controls="seo" aria-expanded="false">SEO</a>
                    </li>
                    <li role="presentation" >
                        <a href="#translations" id="translations-tab" role="tab" data-toggle="tab" aria-controls="translations" aria-expanded="false">Переводы</a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content scrollbar1">
                    <div role="tabpanel" class="tab-pane fade active in" id="main" aria-labelledby="main-tab">
                        <hr>
                        <div class="form-group">
                            <label for="title">Заголовок</label>
                            <input type="text" class="form-control" required="required" value="{{$item->title}}" name="title" id="title">
                        </div>
                        <div class="form-group">
                            <label for="slug">SLUG</label>
                            <input type="text" class="form-control"   required="required"  value="{{$item->slug}}" name="slug" id="slug">
                        </div>

                        <script src="{{ asset("vendor/laravel-filemanager/js/stand-alone-button.js") }}"></script>
                        <script>
                            $(document).ready(function(){
                                $('#og_img_picker').filemanager('image');
                            });
                        </script>
                        <script>
                            $(document).ready(function(){
                                $('.documents_raw').filemanager('image');
                                $('#lfm').filemanager('image');
                                $('#og_img_picker').filemanager('image');
                                $('#new-category-img-picker').filemanager('image');
                                $('#edit-category-img-picker').filemanager('image');
                            });
                        </script>
                        <script src="https://cdn.tiny.cloud/1/4iqdsgxu33edjknrgw8elp9e698blgtt685x0ob8uozetya0/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
                        <label for="text">Контент</label>
                        <textarea name="text" id="text-editor" class="form-control my-editor">{!! $item->content !!}</textarea>
                     <!--    <script>
                          var editor_config = {
                            path_absolute : "/",
                            selector: 'textarea.my-editor',
                            relative_urls: false,
                            plugins: [
                              "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                              "searchreplace wordcount visualblocks visualchars code fullscreen",
                              "insertdatetime media nonbreaking save table directionality",
                              "emoticons template paste textpattern"
                            ],
                            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
                            file_picker_callback : function(callback, value, meta) {
                              var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                              var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;
                        console.log(meta.field_name);
                              var cmsURL = window.location.origin + '/laravel-filemanager?field_name=' + 'url';
                              if (meta.filetype == 'image') {
                                cmsURL = cmsURL + "&type=Images";
                              } else {
                                cmsURL = cmsURL + "&type=Files";
                              }
                              tinyMCE.activeEditor.windowManager.openUrl({
                                url : cmsURL,
                                title : 'Filemanager',
                                width : x * 0.8,
                                height : y * 0.8,
                                resizable : "yes",
                                close_previous : "no",
                                onMessage: (api, message) => {
                                  callback(message.content);
                                }
                              });
                            }
                          };
                          tinymce.init(editor_config);
                        </script> -->
                        <button type="submit" class=" btn btn-success"> СОХРАНИТЬ</button>
                    </div>
                    @if(!empty($item->id))
                    <div role="tabpanel" class="tab-pane fade" id="team" aria-labelledby="team-tab">
                        <hr>
                        Члены совета
                        <hr>
                        <a style="display:block;margin-bottom:22px;" href="{{route('create_board_member',['parent' => $item->id])}}"> <button type="button" class="btn btn-pri btn-success"><i class="fa fa-plus" aria-hidden="true"></i>Добавить члена совета</button></a>
                        <table class="table table-bordered">
                            <thead>
                            <tr> <th>ID </th><th>ПОРЯДОК СОРТИРОВКИ</th> <th>ФОТО</th> <th>ИМЯ ФАМИЛИЯ </th> <th>ДОЛЖНОСТЬ </th> <th> ОПЕРАЦИИ </th>                            </tr>
                            </thead>
                            <tbody>
                            @foreach($item->boardMembers()->orderBy('sort_order')->get() as $member)
                                <tr class="success">
                                    <th scope="row">{{$member->id}}</th>
                                    <td>{{$member->sort_order}}</td>
                                    <td><img class="logo" src="{{$member->photo}}"></td>
                                    <td>{{$member->title}}</td>
                                    <td>{{$member->job}}</td>
                                    <td><a href="{{route('edit_board_member',['parent'=>$item->id,'item'=>$member->id])}}"><i class="glyphicon glyphicon-edit"></i></a><a class="delete_category" data-toggle="modal" data-target="#delete-element-modal" itemname="{{$member->title}}" itemid="{{$member->id}}" href="#"><i class="glyphicon glyphicon-remove"></i></a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @endif
                    @if($item->id == 57)
                        <div role="tabpanel" class="tab-pane fade " id="commision" aria-labelledby="commision">
                            <hr>
                            <h3>Табы</h3>
                            <hr>

                            <div >
                                <a style="display:block;margin-bottom:22px;" href="{{route('create_commisiontab',['parent' => $item->id])}}"> <button type="button" class="btn btn-pri btn-success"><i class="fa fa-plus" aria-hidden="true"></i>Добавить таб </button></a>
                                <div class="blank-page widget-shadow scroll">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr> <th>Порядок сортировки </th>  <th> Заголовок</th>  <th> ОПЕРАЦИИ </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($item->tabs()->orderBy('sort_order')->get() as $tab)
                                                <tr class="success">
                                                    <th scope="row">{{$tab->sort_order}}</th>
                                                    <td>{{$tab->title}}</td>
                                                    <td><a href="{{route('edit_commisiontab',['item'=>$tab->id,'parent' =>  $item->id])}}"><i class="glyphicon glyphicon-edit"></i></a>
                                                        <a class="delete_tab" data-toggle="modal" data-target="#delete-element-modal"  itemid="{{$tab->id}}" href="#"><i class="glyphicon glyphicon-remove"></i></a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>


                            </div>

                            <button type="submit" class="submit_button btn btn-success">СОХРАНИТЬ</button>
                        </div>
                        <div role="tabpanel" class="tab-pane fade " id="commisionfile" aria-labelledby="commision">
                            <hr>
                            <h3>Файлы</h3>
                            <hr>

                            <div >
                                <a style="display:block;margin-bottom:22px;" href="{{route('create_commisionfile_postmonitoring',['parent' => $item->id])}}"> <button type="button" class="btn btn-pri btn-success"><i class="fa fa-plus" aria-hidden="true"></i>Добавить вложение </button></a>
                                <div class="blank-page widget-shadow scroll">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr> <th>Порядок сортировки </th>  <th> Заголовок</th>  <th> ОПЕРАЦИИ </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                                @foreach($item->files()->orderBy('sort_order')->get() as $file)
                                                <tr class="success">
                                                    <th scope="row">{{$file->sort_order}}</th>
                                                    <td>{{$file->title}}</td>
                                                    <td><a href="{{route('edit_commisionfile_postmonitoring',['item'=>$file->id,'parent' =>  $item->id])}}"><i class="glyphicon glyphicon-edit"></i></a><a class="delete_file" data-toggle="modal" data-target="#delete-element-modal"  itemid="{{$file->id}}" href="#"><i class="glyphicon glyphicon-remove"></i></a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>


                            </div>

                            <button type="submit" class="submit_button btn btn-success">СОХРАНИТЬ</button>
                        </div>
                    @endif
                    <div role="tabpanel" class="tab-pane fade " id="documents" aria-labelledby="documents-tab">
                        <hr>
                        <h3>Список документов</h3>
                        <hr>
                        <div id="app">
                            @if(strlen($item->documents))
                                <page-documents-component ></page-documents-component>
                            @else
                                <page-documents-component  ></page-documents-component>
                            @endif
                        </div>

                        <button type="submit" class="submit_button btn btn-success">СОХРАНИТЬ</button>
                    </div>
                    <div role="tabpanel" class="tab-pane fade " id="seo" aria-labelledby="seo-tab">
                        <hr>
                        <div class="form-group">
                            <label for="seo_title">SEO заголовок</label>
                            <input type="text" value="{{$item->seo_title}}" class="form-control" name="seo_title" id="seo_title">
                        </div>
                        <div class="form-group">
                            <label for="seo_keywords">SEO ключевые слова</label>
                            <textarea class="form-control"  name="seo_keywords" id="seo_keywords">{{$item->seo_keywords}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="seo_description">SEO описание</label>
                            <textarea class="form-control" name="seo_description" id="seo_description">{{$item->seo_description}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="og_title">OG заголовок</label>
                            <input type="text" value="{{$item->og_title}}" class="form-control" name="og_title" id="og_title">
                        </div>
                        <div class="form-group">
                            <label for="og_img">OG img</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                  <a id="og_img_picker" data-input="og_img" data-preview="og_img_preview" class="btn btn-primary">
                                     <i class="fa fa-picture-o"></i> Выберите картинку
                                    </a>
                                </span>
                                <input readonly="readonly" id="og_img" class="form-control" type="text" value="{{$item->og_img}}" name="og_img">
                            </div>
                            <span id="og_img_preview" style="margin-top:15px;">
                                @if(isset($item->og_img))
                                    <img src="{{$item->og_img}}" class="preview-icon">
                                @endif
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="og_description">OG описание</label>
                            <textarea class="form-control" name="og_description" id="og_description">{{$item->og_description}}</textarea>
                        </div>
                        <hr>
                        <button type="submit" class=" btn btn-success">СОХРАНИТЬ</button>
                    </div>
                    <div role="tabpanel" class="tab-pane fade in" id="translations" aria-labelledby="translations-tab">
                        <hr>
                        <h2>Список переводов</h2>
                        <hr>

                        @if(!($item->nodes()->where('lang','kz')->exists()))
                            <a style="display:block;margin-bottom:22px;" href="{{route('create_board_node',['lang' =>'kz','parent' => $item->id])}}"> <button type="button" class="btn btn-pri btn-success"><i class="fa fa-plus" aria-hidden="true"></i>Добавить перевод на казахский язык </button></a>
                        @endif
                        @if(!($item->nodes()->where('lang','en')->exists()))
                            <a style="display:block;margin-bottom:22px;" href="{{route('create_board_node',['lang' =>'en','parent' => $item->id])}}"> <button type="button" class="btn btn-pri btn-success"><i class="fa fa-plus" aria-hidden="true"></i>Добавить перевод на английский язык </button></a>
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
                                    <td><a href="{{route('edit_board_node',['item'=>$node->id])}}"><i class="glyphicon glyphicon-edit"></i></a><a class="delete_node" data-toggle="modal" data-target="#delete-node-modal" itemname="{{$node->lang}}" itemid="{{$node->id}}" href="#"><i class="glyphicon glyphicon-remove"></i></a></td>
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
    <div id="delete-element-modal" class="modal fade" tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="delete_title">Удаление бренда</h4>
                </div>
                <div class="modal-body">
                    <form  action="задается скриптом" method="POST" id="delete_item_form">
                        {{ csrf_field() }}
                        <div class="form-group">
                            Удалить  ?
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