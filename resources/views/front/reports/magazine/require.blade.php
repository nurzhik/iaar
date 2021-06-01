@extends('layouts.front')
@section('content')
    <div class="page">
        <div class="container">
            <div class="page_sidebar">
                <ul class="page_nav">
                    <li><a class="nav_item " href="/reports/{{\App\Models\StaticPage::where('type_id',29)->first()->slug}}/{{$lang}}">{{\App\Models\StaticPage::where('type_id',29)->first()->getLocaleNode($lang)->title}} </a></li>
                    <li><a class="nav_item " href="/reports/{{\App\Models\StaticPage::where('type_id',25)->first()->slug}}/{{$lang}}">{{\App\Models\StaticPage::where('type_id',25)->first()->getLocaleNode($lang)->title}} </a></li>
                    <li><a class="nav_item " href="/reports/{{\App\Models\StaticPage::where('type_id',26)->first()->slug}}/{{$lang}}">{{\App\Models\StaticPage::where('type_id',26)->first()->getLocaleNode($lang)->title}} </a></li>
                    <li><a class="nav_item active" href="/reports/{{\App\Models\StaticPage::where('type_id',27)->first()->slug}}/{{$lang}}">{{\App\Models\StaticPage::where('type_id',27)->first()->getLocaleNode($lang)->title}} </a></li>
                    <li><a class="nav_item" href="/reports/{{\App\Models\StaticPage::where('type_id',28)->first()->slug}}/{{$lang}}">{{\App\Models\StaticPage::where('type_id',28)->first()->getLocaleNode($lang)->title}} </a></li>
                    <li><a class="nav_item " href="/reports/{{\App\Models\StaticPage::where('type_id',13)->first()->slug}}/{{$lang}}">{{\App\Models\StaticPage::where('type_id',13)->first()->getLocaleNode($lang)->title}} </a></li>
                </ul>
                @if(strlen($item->getLocaleNode($lang)->documents))
                    <div class="page_docs">
                        <p class="sidebar_title">{{__('main.Documents')}}</p>
                        <ul class="docs">
                            @if(is_array(json_decode($item->getLocaleNode($lang)->documents,true)))
                                @foreach(json_decode($item->getLocaleNode($lang)->documents,true) as $document)
                                    <li><a class="doc_link" target="_blank" href="{{$document['file']}}">{{$document['name']}}</a></li>
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
                                <a href="/news/{{$article->slug}}/{{$lang}}" class="news_img" style="background: url('{{$article->main_image}}') center / cover no-repeat;"></a>
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
                    @if(strlen($item->main_image))                            
                            <img class="static-info__img" src="{{$item->main_image}}">
                        @endif
                    {!!  $item->getLocaleNode($lang)->content !!}
                </div>
            </div>
        </div>
    </div>
@endsection
