@extends('layouts.admin')
@section('content')
    <script type="text/javascript">
        $(document).ready(function(){
            $('.delete_node').on('click',function(){
                var item_id = $(this).attr('itemid');
                var item_name = $(this).attr('itemname');
                $('#delete_node_form').attr('action','/admin/postmonitorings/nodes/delete/'+item_id);
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
            $('.delete_tab').on('click',function(){
                var item_id = $(this).attr('itemid');
                var item_name = $(this).attr('itemname');
                $('#delete_item_form').attr('action','/admin/tabs/delete/'+item_id);
            });
             $('.delete_file').on('click',function(){
                var item_id = $(this).attr('itemid');
                var item_name = $(this).attr('itemname');
                $('#delete_item_form').attr('action','/admin/files/delete/'+item_id);
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
        <h2 class="title">
            @if(empty($item->id))
                Добавление 
            @else
                Редактирование  "{{$item->title}}"
            @endif
        </h2>
        <form method="post" @if(empty($item->id))action="/admin/postmonitorings/create" @else action="/admin/postmonitorings/{{$item->id}}" @endif >
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
                    @if($item->id != 8)
                    <li role="presentation" class="">
                        <a href="#add_documents" id="add_documents-tab" role="tab" data-toggle="tab" aria-controls="add_documents" aria-expanded="false">Табы</a>
                    </li>
                    @endif
                    <li role="presentation" class="">
                        <a href="#add_files" id="add_files-tab" role="tab" data-toggle="tab" aria-controls="add_files" aria-expanded="false">Файлы</a>
                    </li>
                    <!-- <li role="presentation" class="">
                        <a href="#seo" id="seo-tab" role="tab" data-toggle="tab" aria-controls="seo" aria-expanded="false">SEO</a>
                    </li> -->
                    <li role="presentation" class="">
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
                        <script src="https://cdn.tiny.cloud/1/4iqdsgxu33edjknrgw8elp9e698blgtt685x0ob8uozetya0/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
                        <label for="content">Контент</label>
                        <textarea name="content" id="text-editor" class="form-control my-editor">{!! $item->content !!}</textarea>
                        <button type="submit" class=" btn btn-success"> СОХРАНИТЬ</button>
                    </div>
                     @if($item->id != 8)
                    <div role="tabpanel" class="tab-pane fade " id="add_documents" aria-labelledby="add_documents-tab">
                        <hr>
                        <h3>Табы</h3>
                        <hr>
                        <div >
                            <a style="display:block;margin-bottom:22px;" href="{{route('create_tab',['parent' => $item->id])}}"> <button type="button" class="btn btn-pri btn-success"><i class="fa fa-plus" aria-hidden="true"></i>Добавить таб </button></a>
                            <div class="blank-page widget-shadow scroll">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr> <th>Порядок сортировки </th>  <th> Заголовок</th>  <th> ОПЕРАЦИИ </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($item->tabs()->orderBy('sort_order','DESC')->get() as $tab)
                                        <tr class="success">
                                            <th scope="row">{{$tab->sort_order}}</th>
                                            <td>{{$tab->title}}</td>
                                            <td><a href="{{route('edit_tab',['item'=>$tab->id,'parent' =>  $item->id])}}"><i class="glyphicon glyphicon-edit"></i></a>
                                                <a class="delete_tab" data-toggle="modal" data-target="#delete-element-modal"  itemid="{{$tab->id}}" href="#"><i class="glyphicon glyphicon-remove"></i></a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>


                        </div>

                        <button type="submit" class="submit_button btn btn-success">СОХРАНИТЬ</button>
                    </div>
                     @endif
                    <div role="tabpanel" class="tab-pane fade " id="add_files" aria-labelledby="add_files-tab">
                        <hr>
                        <h3>Файлы</h3>
                        <hr>
                        <div >
                            <a style="display:block;margin-bottom:22px;" href="{{route('create_file_postmonitoring',['parent' => $item->id])}}"> <button type="button" class="btn btn-pri btn-success"><i class="fa fa-plus" aria-hidden="true"></i>Добавить вложение </button></a>
                            <div class="blank-page widget-shadow scroll">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr> <th>Порядок сортировки </th>  <th> Заголовок</th>  <th> ОПЕРАЦИИ </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($item->files()->orderBy('sort_order','DESC')->get() as $file)
                                        <tr class="success">
                                            <th scope="row">{{$file->sort_order}}</th>
                                            <td>{{$file->title}}</td>
                                            <td><a href="{{route('edit_file_postmonitoring',['item'=>$file->id,'parent' =>  $item->id])}}"><i class="glyphicon glyphicon-edit"></i></a><a class="delete_file" data-toggle="modal" data-target="#delete-element-modal"  itemid="{{$file->id}}" href="#"><i class="glyphicon glyphicon-remove"></i></a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>


                        </div>

                        <button type="submit" class="submit_button btn btn-success">СОХРАНИТЬ</button>
                    </div>
                    <!-- <div role="tabpanel" class="tab-pane fade " id="seo" aria-labelledby="seo-tab">
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
                        
                        <hr>
                        <button type="submit" class=" btn btn-success">СОХРАНИТЬ</button>
                    </div> -->
                    @if(!empty($item->id))
                        <div role="tabpanel" class="tab-pane fade in" id="translations" aria-labelledby="translations-tab">
                            <hr>
                            <h2>Список переводов</h2>
                            <hr>

                            @if(!($item->nodes()->where('lang','kz')->exists()))
                                <a style="display:block;margin-bottom:22px;" href="{{route('create_postmonitoring_node',['lang' =>'kz','type' => $item->id])}}"> <button type="button" class="btn btn-pri btn-success"><i class="fa fa-plus" aria-hidden="true"></i>Добавить перевод на казахский язык </button></a>
                            @endif
                            @if(!($item->nodes()->where('lang','en')->exists()))
                                <a style="display:block;margin-bottom:22px;" href="{{route('create_postmonitoring_node',['lang' =>'en','type' => $item->id])}}"> <button type="button" class="btn btn-pri btn-success"><i class="fa fa-plus" aria-hidden="true"></i>Добавить перевод на английский язык </button></a>
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
                                        <td><a href="{{route('edit_postmonitorings_node',['item'=>$node->id])}}"><i class="glyphicon glyphicon-edit"></i></a><a class="delete_node" data-toggle="modal" data-target="#delete-node-modal" itemname="{{$node->lang}}" itemid="{{$node->id}}" href="#"><i class="glyphicon glyphicon-remove"></i></a></td>
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
    <div id="delete-element-modal" class="modal fade" tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="delete_title">Удаление </h4>
                </div>
                <div class="modal-body">
                    <form  action="задается скриптом" method="POST" id="delete_item_form">
                        {{ csrf_field() }}
                        <div class="form-group">
                            Удалить ?
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