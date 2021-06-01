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
        .error-ul{
            list-style: none;
            background-color:#fff;
            padding:30px;
            margin-bottom:20px;
        }
        .error-ul > li {
            border: 1px solid #ccc;
            margin-bottom: 22px;
            padding: 12px;
            border-radius: 6px;
        }        
        .error-under-ul{
            margin-left:25px;
            list-style: disc;
        }
        .error-univer{
            display:block;
            font-weight:bold;
            padding-bottom:10px;            
        }
        .error-prog{
            display:inline-block;            
        }
        .error-mar{
            display:inline-block;
            padding:0 4px;
        }
        .error-under-ul li{
            margin-bottom: 7px;
            font-size: 15px;
        }
        .error-message {
            font-weight: bold;
            font-style: italic;
            color: red;
        }
        .admin-row{
            display:flex;
            margin-bottom:15px;
            padding-bottom:15px;
            border-bottom:1px solid #ccc;
        }
        .admin-row a{
            margin-right:20px;
            margin-bottom:0;
        }
        .admin-row--last{
            border-bottom:none;
            padding-bottom:0;
        }
    </style>

    <script>
        $(document).ready(function(){
            $('.delete_category').on('click',function(){
                var item_id = $(this).attr('itemid');
                var item_name = $(this).attr('itemname');
                $('#delete_item_form').attr('action','/admin/univer/delete/'+item_id);
                $('#delete_title').html('Удаление университета"'+item_name+'"');
            });
        });
    </script>
    <div class="main-page">
        <h2 class="title1">Список университетов</h2>
        <div class="admin-row">
            <a href="{{route('create_univer')}}"> <button type="button" class="btn btn-pri btn-success"><i class="fa fa-plus" aria-hidden="true"></i>Добавить университет </button></a>
            <a href="/admin/log/registry-update"> <button type="button" class="btn btn-pri btn-success"><i class="fa fa-calendar-alt" aria-hidden="true"></i>Дата обновления реестра </button>   </a>
            <a href="{{route('deqar_accr_types')}}"> <button type="button" class="btn btn-pri btn-success"><i class="fa fa-compass"></i></i>Список доступных направлений аккредитаций  DEQAR</button>   </a>
        </div>
        <div class="admin-row admin-row--last">    
            @if($countUniver > 0)
            <a style="display:block;margin-bottom:22px;" href="{{route('deqar_send_all_instituition')}}"> <button type="button" class="btn btn-pri btn-danger"><i class="fa fa-paper-plane" aria-hidden="true"></i>Отправить институциональные аккредитации отчеты в DEQAR</button>   </a>
            @endif
            @if($countProgram > 0)
            <a style="display:block;margin-bottom:22px;" href="{{route('deqar_send_all_programm')}}"> <button type="button" class="btn btn-pri btn-danger"><i class="fa fa-paper-plane" aria-hidden="true"></i>Отправить Программные аккредитации отчеты в DEQAR</button>   </a>
              @endif
        </div>    
        @if(!empty($result))
        <div class="result-block">
            <div class="result-block__message">
                  {{$result['message']}}
            </div>
             @if(!empty($result['institute']))
            <div class="result-block-item">
                <h2>
                    Институциональные аккредитации
                </h2>
                    <ul class="error-ul">

                 @foreach($result['institute'] as $item=>$key)
                        <li>
                            <span class="error-univer">{{$item}}</span> 
                                <span class="error-message"><?php foreach ($result['institute'][$item] as $institute ): ?>
                                    {{$institute}}
                                <?php endforeach ?>
                            	</span>
                        </li>
                @endforeach
                    </ul>

            </div>
            @endif
            @if(!empty($result['programs']))
            <div class="result-block-item">
                <h2>
                    Программная аккредитации
                </h2>                
                    <ul class="error-ul">

                 @foreach($result['programs'] as $item=>$key)
                        <li>

                            <span class="error-univer">{{$item}} </span>
                            <ul class="error-under-ul">
                                <?php foreach ($result['programs'][$item] as $program=>$value  ): ?>
                                    <li>
                                        <span class="error-prog">{{$program}}</span>
                                        <span class="error-mar">-</span>
                                        <span class="error-message"><?php foreach ($result['programs'][$item][$program] as $error ): ?>{{ $error }}
                                        </span>
                                        <?php endforeach ?>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </li>
                    
                @endforeach
                    </ul>

            </div>
            @endif
        </div>
            
        @endif
        <div class="blank-page widget-shadow scroll">
            <table class="table table-bordered">
                <thead>
                <tr> <th>ID </th><th>Название</th> <th>Страна</th> <th>Количество институциональных аккр</th> <th>Количество программных аккр</th> <th> ОПЕРАЦИИ </th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr class="success">
                        <th scope="row">{{$item->id}}</th>
                        <td>{{$item->title}}</td>
                        <td>{{$item->country->title}}</td>
                        <td>{{$item->mainAccrs()->count()}}</td>
                        <td>{{$item->programAccrs()->count()}}</td>
                        <td><a href="{{route('edit_univer',['item'=>$item->id])}}"><i class="glyphicon glyphicon-edit"></i></a><a class="delete_category" data-toggle="modal" data-target="#delete-element-modal" itemname="{{$item->title}}" itemid="{{$item->id}}" href="#"><i class="glyphicon glyphicon-remove"></i></a></td>
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
                    <h4 class="modal-title" id="delete_title">Удаление </h4>
                </div>
                <div class="modal-body">
                    <form  action="задается скриптом" method="POST" id="delete_item_form">
                        {{ csrf_field() }}
                        <div class="form-group">
                            Удалить данный университет? Удаление необратимо и влечет за собой удаление всех аккредитаций университета
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


