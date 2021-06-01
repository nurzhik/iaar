@extends('layouts.front')
@section('content')
    <div class="page">
        <div class="container">
            <div class="page_sidebar">
                <ul class="page_nav">
                        @foreach(\App\Models\StaticPage::where('type_id',2)->orderBy('sort_order')->get() as $page)
                            <li><a class="nav_item" href="/iaar/{{$page->slug}}/{{$lang}}">{{$page->getLocaleNode($lang)->title}}</a></li>
                        @endforeach
                        <li><a class="nav_item active" href="/iaar/{{\App\Models\StaticPage::where('type_id',4)->first()->slug}}/{{$lang}}">{{__('main.Experts')}}</a></li>
                        <li><a class="nav_item" href="/iaar/{{\App\Models\StaticPage::where('type_id',3)->first()->slug}}/{{$lang}}">{{__('main.Our_team')}}</a></li>
                </ul>
                @if(strlen($item->getLocaleNode($lang)->documents))
                    <div class="page_docs">
                        <p class="sidebar_title">{{__('main.Documents')}}</p>
                        <ul class="docs">
                            @if(is_array(json_decode($item->getLocaleNode($lang)->documents,true)))
                                @foreach(json_decode($item->getLocaleNode($lang)->documents,true) as $document)
                                    <li><a class="doc_link"  target="_blank" href="{{$document['file']}}">{{$document['name']}}</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                @endif
                <div class="page_news">
                    <p class="sidebar_title">{{__('main.News')}}</p>
                    <div class="page_news_slider">
                        @foreach($news as $article)
                            <div class="news_item">
                                <a href="/news/{{$article->slug}}/{{$lang}}" class="news_img" style="background: url('{{asset($article->main_image)}}') center / cover no-repeat;"></a>
                                <div class="news_text">
                                    <span class="date">{{date('d.m.Y', strtotime($article->published_at))}}</span>
                                    <a class="news_title" href="/news/{{$article->slug}}/{{$lang}}">{{$article->getLocaleNode($lang)->title}}</a>
                                    <p class="text">{{$article->getLocaleNode($lang)->short_desc}}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="expert">
                <ul class="breadcrumbs">
                    <li><a href="/{{$lang}}">{{__('main.Main')}}</a></li>
                    <li><a>{{$item->getLocaleNode($lang)->title}}</a></li>
                </ul>
                <div class="page_nav_title"><p></p></div>
                <p class="page-title">{{$item->getLocaleNode($lang)->title}}</p>
                <div class="static-info">
                        <!-- @if(strlen($item->main_image)>2)
                            <img class="static-info__img" src="{{$item->main_image}}">
                        @endif -->
                    {!!  $item->getLocaleNode($lang)->content !!}
                </div>
            </div>
        </div>
    </div>
@endsection
