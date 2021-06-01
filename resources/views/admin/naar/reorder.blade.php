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

    <div class="main-page">
        <form method="post" action="/admin/naar/reorder">
            {{csrf_field()}}
        <h2 class="title1">Изменениe порядка в подменю</h2>
        <a style="display:block;margin-bottom:22px;" href="{{route('create_board')}}"> <button type="submit" class="btn btn-pri btn-success"><i class="fa fa-plus" aria-hidden="true"></i>Сохранить изменения</button></a>
        <div class="blank-page widget-shadow scroll" id="reor">
            <static-page-reorder-component ></static-page-reorder-component>
        </div>
        </form>
    </div>


    <!--footer-->
@endsection


