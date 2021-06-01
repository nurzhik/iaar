<!DOCTYPE html>
@extends('layouts.admin')
@section('content')
    <script type="text/javascript">
        $(document).ready(function(){
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

            Редактирование страницы "Подписка" Журнала EDUCATION QA

        </h2>
        <form method="post" action="/admin/reports/journal/journals_subscription" >
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
                    <li role="presentation" class="">
                        <a href="#documents" id="documents-tab" role="tab" data-toggle="tab" aria-controls="documents" aria-expanded="false">Документы</a>
                    </li>
                    <li role="presentation" class="">
                        <a href="#seo" id="seo-tab" role="tab" data-toggle="tab" aria-controls="seo" aria-expanded="false">SEO</a>
                    </li>
                    @if(!empty($item->id))
                        <li role="presentation" class="">
                            <a href="#translations" id="translations-tab" role="tab" data-toggle="tab" aria-controls="translations" aria-expanded="false">Переводы</a>
                        </li>
                    @endif
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
                        <label for="text">Контент</label>
                        <textarea name="text" id="text-editor" class="form-control my-editor">{!! $item->content !!}</textarea>

                        <button type="submit" class=" btn btn-success"> СОХРАНИТЬ</button>
                    </div>
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
                    @if(!empty($item->id))
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
                    @endif
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