<!DOCTYPE html>
@extends('layouts.admin')
@section('content')
    <script type="text/javascript">
        $(document).ready(function(){
            $('.delete_main_accr').on('click',function(){
                var item_id = $(this).attr('itemid');
                $('#delete_exist_form').attr('action','/admin/reports/16/attachment/delete/'+item_id);
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
        <h2 class="title">
            Редактирование перевода на язык "{{$lang}}" страницы "Сми о нас"
        </h2>
        <form method="post" action="/admin/nodes/reports/16/{{$lang}}/edit" >
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
                        <a href="#documents" id="add_documents-tab" role="tab" data-toggle="tab" aria-controls="documents" aria-expanded="false">Список Документов</a>
                    </li>
                    <li role="presentation" class="">
                        <a href="#add_documents" id="add_documents-tab" role="tab" data-toggle="tab" aria-controls="add_documents" aria-expanded="false">Отчеты PDF</a>
                    </li>

                    <li role="presentation" class="">
                        <a href="#seo" id="seo-tab" role="tab" data-toggle="tab" aria-controls="seo" aria-expanded="false">SEO</a>
                    </li>

                </ul>
                <div id="myTabContent" class="tab-content scrollbar1">
                    <div role="tabpanel" class="tab-pane fade active in" id="main" aria-labelledby="main-tab">
                        <hr>
                        <div class="form-group">
                            <label for="title">Заголовок</label>
                            <input type="text" class="form-control" required="required" value="{{$item->title}}" name="title" id="title">
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
                    <div role="tabpanel" class="tab-pane fade " id="add_documents" aria-labelledby="add_documents-tab">
                        <hr>
                        <h3>Список отчетов PDF</h3>
                        <hr>
                        <div id="app_1">
                            @if(strlen($item->add_documents))
                                <page-add-documents-component ></page-add-documents-component>
                            @else
                                <page-add-documents-component  ></page-add-documents-component>
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
                            <label for="og_description">OG описание</label>
                            <textarea class="form-control" name="og_description" id="og_description">{{$item->og_description}}</textarea>
                        </div>
                        <hr>
                        <button type="submit" class=" btn btn-success">СОХРАНИТЬ</button>
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
                    <h4 class="modal-title" >Удаление  вложения</h4>
                </div>
                <div class="modal-body">
                    <form  action="задается скриптом" method="POST" id="delete_exist_form">
                        {{ csrf_field() }}
                        <div class="form-group">
                            Удалить данное вложение?
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