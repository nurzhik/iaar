@extends('layouts.front')
@section('content')
    <section class="news_page">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/{{$lang}}">{{__('main.Main')}}</a></li>
                <li><span>{{$item->getLocaleNode($lang)->title}}</span></li>
            </ul>
            <h1 class="page-title">{{$item->getLocaleNode($lang)->title}}</h1>
            <div class="static-info static-info--ov">
                <div class="static-info__partner">
                    <img src="{{$item->image}}">
                    <a class="btn" href="{{$item->link}}">{{__('main.Go_to_web')}}</a>
                </div> 
                <div class="static-info__partnerText">               
                        {!! $item->getLocaleNode($lang)->text !!}
                </div>
                
            </div>
        </div>
    </section>

@endsection