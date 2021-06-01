@extends('layouts.admin')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif
    <style>
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

    <script>
        $(document).ready(function(){
            $('.delete_category').on('click',function(){
                var item_id = $(this).attr('itemid');
                var item_name = $(this).attr('itemname');
                $('#delete_item_form').attr('action','/admin/accreditation/{{$type}}/delete/'+item_id);
                $('#delete_title').html('Удаление страницы аккредитации"'+item_name+'"');
            });
        });
    </script>
    <div class="main-page">
        <h2 class="title1">Список страниц аккредитации типа организации "{{array_flip(\App\Models\Univer::availableTypeIdArray())[$type]}}"</h2>
        <a style="display:block;margin-bottom:22px;" href="{{route('create_accr_page',['type' => $type])}}"> <button type="button" class="btn btn-pri btn-success"><i class="fa fa-plus" aria-hidden="true"></i>Добавить страницу </button></a>
        <div class="blank-page widget-shadow scroll">
            <table class="table table-bordered">
                <thead>
                <tr> <th>ID </th><th>Тип аккредитации</th> <th>Заголовок</th> <th>Страна</th>  <th> ОПЕРАЦИИ </th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr class="success">
                        <th scope="row">{{$item->id}}</th>
                        <td>
                            @switch($item->sort_order)
                                @case(1)
                                        Институциональная аккредитация
                                @break
                                @case(2)
                                Специализированная прпограммная аккредитация
                                @break
                                @case(3)
                                     Специализированная прпограммная аккредитация(ex-ante)
                                @break
                                @case(4)
                                     Институциональная первичная аккредитация (Ex-Ante) 
                                @break
                                @case(5)
                                     Международная совместная аккредитация с агентством-партнером 
                                @break
                                @default
                                        --
                                @break

                            @endswitch


                        </td>
                        <td>{{$item->title}}</td>
                        <td>{{isset($item->country) ? $item->country->title: ''}}</td>
                        <td><a href="{{route('edit_accr_page',['item'=>$item->id,'type' => $type])}}"><i class="glyphicon glyphicon-edit"></i></a><a class="delete_category" data-toggle="modal" data-target="#delete-element-modal" itemname="{{$item->title}}" itemid="{{$item->id}}" href="#"><i class="glyphicon glyphicon-remove"></i></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div id="delete-element-modal" class="modal fade" tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="delete_title">Удаление страницы</h4>
                </div>
                <div class="modal-body">
                    <form  action="задается скриптом" method="POST" id="delete_item_form">
                        {{ csrf_field() }}
                        <div class="form-group">
                            Удалить данную страницу?
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

    <!--footer-->
@endsection


