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
            Просмотр заявки эксперта
        </h2>
        <div>
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
                            <label for="title">Имя</label>
                            <input type="text" class="form-control" required="required" value="{{$item->name}}" readonly="readonly" name="title" id="title">
                        </div>
                        <div class="form-group">
                            <label for="title">Фамилия</label>
                            <input type="text" class="form-control" required="required" value="{{$item->surname}}" readonly="readonly" name="title" id="title">
                        </div>
                        <div class="form-group">
                            <label for="title">Отчество</label>
                            <input type="text" class="form-control" required="required" value="{{$item->third_name}}" readonly="readonly" name="title" id="title">
                        </div>
                        <div class="form-group">
                            <label for="title">Дата рождения</label>
                            <input type="text" class="form-control" required="required" value="{{$item->birth_date}}" readonly="readonly" name="title" id="title">
                        </div>
                        <div class="form-group">
                            <label for="title">Адрес проживания</label>
                            <input type="text" class="form-control" required="required" value="{{$item->address}}" readonly="readonly" name="title" id="title">
                        </div>
                        <div class="form-group">
                            <label for="title">Знание иностранного языка</label>
                            <input type="text" class="form-control" required="required" value="{{$item->languages}}" readonly="readonly" name="title" id="title">
                        </div>
                        <div class="form-group">
                            <label for="title">Язык / степень знания</label>
                            <input type="text" class="form-control" required="required" value="{{$item->level_of_knowing}}" readonly="readonly" name="title" id="title">
                        </div>
                        <div class="form-group">
                            <label for="title">Ученая степень</label>
                            <input type="text" class="form-control" required="required" value="{{$item->science_degree}}" readonly="readonly" name="title" id="title">
                        </div>
                        <div class="form-group">
                            <label for="title">Ученое звание</label>
                            <input type="text" class="form-control" required="required" value="{{$item->science_rank}}" readonly="readonly" name="title" id="title">
                        </div>
                        <div class="form-group">
                            <label for="title">Телефон</label>
                            <input type="text" class="form-control" required="required" value="{{$item->phone}}" readonly="readonly" name="title" id="title">
                        </div>
                        <div class="form-group">
                            <label for="title">Факс</label>
                            <input type="text" class="form-control" required="required" value="{{$item->fax}}" readonly="readonly" name="title" id="title">
                        </div>
                        <div class="form-group">
                            <label for="title">Email</label>
                            <input type="text" class="form-control" required="required" value="{{$item->email}}" readonly="readonly" name="title" id="title">
                        </div>
                        <div class="form-group">
                            <label for="title">Место работы</label>
                            <input type="text" class="form-control" required="required" value="{{$item->work_place}}" readonly="readonly" name="title" id="title">
                        </div>
                        <div class="form-group">
                            <label for="title">Занимаемая должность</label>
                            <input type="text" class="form-control" required="required" value="{{$item->job}}" readonly="readonly" name="title" id="title">
                        </div>
                        <div class="form-group">
                            <label for="title">Педагогический стаж работы</label>
                            <input type="text" class="form-control" required="required" value="{{$item->teaching_experience}}" readonly="readonly" name="title" id="title">
                        </div>
                        <div class="form-group">
                            <label for="title">Награды, почетные звания, членство в академиях наук</label>
                            <input type="text" class="form-control" required="required" value="{{$item->rewards}}" readonly="readonly" name="title" id="title">
                        </div>
                        <div class="form-group">
                            <label for="title">Сфера научных интересов</label>
                            <input type="text" class="form-control" required="required" value="{{$item->science_sphere}}" readonly="readonly" name="title" id="title">
                        </div>
                        <div class="form-group">
                            <label for="title">Предполагаемые области экспертной деятельности</label>
                            <input type="text" class="form-control" required="required" value="{{$item->expert_spheres}}" readonly="readonly" name="title" id="title">
                        </div>
                        <div class="form-group">
                            <label for="title">Список прикрепленных документов</label>
                            @if($item->documents)
                                @foreach(json_decode($item->documents,true) as $document)
                                    <a target="_blank" href="/files/{{$document}}">{{$document}}</a>
                                @endforeach
                            @endif
                        </div>
                        <button type="submit" class=" btn btn-success"> <a href="/admin/naar/experts_callbacks">Назад к списку</a></button>
                    </div>




                </div>
            </div>
        </div>
    </div>



@endsection