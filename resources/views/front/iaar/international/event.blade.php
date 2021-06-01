@extends('layouts.front')
@section('content')
    <section class="news_page">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/{{$lang}}">{{__('main.Main')}}</a></li>
                <li><a href="/iaar/mezhdunarodnye-meropriyatiya/{{$lang}}">{{__('main.International_events')}}</a></li>
                <li><a>{{$item->getLocaleNode($lang)->title}}</a></li>
            </ul>
            <p class="title">{{$item->getLocaleNode($lang)->title}}</p>
            <p style="margin-bottom:30px" class="date">{{date('d.m.Y',strtotime($item->created_at))}} </p>
            <div class="news-part">
                <div class="news-part__info">
                    <div class="static-info">
                        <img src="{{asset($item->main_image)}}">
                        {!! $item->getLocaleNode($lang)->content !!}
                    </div>
                </div>
                <div class="news-part__right">
                    <div class="news-right">
                        <ul class="news-list">
                            @foreach(\App\Models\StaticPage::where('id','<>',$item->id)->where('type_id',24)->orderBy('created_at','DESC')->get()->take(4) as $event)
                                    <li>
                                        <div class="news_item">
                                            <a href="/iaar/international_events/{{$event->slug}}/{{$lang}}" class="news_img" style="background: url('{{asset($event->main_image)}}') center / cover no-repeat;"></a>
                                            <div class="news_text">
                                                <span class="date">{{date('d.m.Y',strtotime($event->created_at))}}</span>
                                                <a class="news_title" href="/iaar/international_events/{{$event->slug}}/{{$lang}}">{{$event->getLocaleNode($lang)->title}}</a>
                                                <p class="text">{{$event->getLocaleNode($lang)->additional_documents}}</p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection