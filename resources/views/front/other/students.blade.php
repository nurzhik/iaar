@extends('layouts.front')
@section('content')
    <section class="news_page">
        <div class="container">
            <div class="expert">
                <ul class="breadcrumbs">
                    <li><a href="/{{$lang}}">{{__('main.Main')}}</a></li>
                    <li><a>{{__('main.Students')}}</a></li>
                </ul>
                <p class="title">{{__('main.Students')}}</p>
                <div class="expert_block">
                    <div class="text_block">
                            {!! $item->getLocaleNode($lang)->content !!}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection