@extends('layouts.front')
@section('content')
    <div class="" style="padding: 45px 0;">
        <div class="container">
            <!-- <div class="page_sidebar">
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
            </div> -->
            <ul class="breadcrumbs">
                <li><a href="/{{$lang}}">{{__('main.Main')}}</a></li>
                <li><a>{{__('main.IAAR')}}</a></li>
                <li><a>{{$item->getLocaleNode($lang)->title}}</a></li>
            </ul>
            <div class="page_nav_title"><p></p></div>
            <span class="page-title">{{$item->getLocaleNode($lang)->title}}</span>
            <div class="static-info">
                {!! $item->getLocaleNode($lang)->content !!}
            </div>
            <div class="partner-area">
                @foreach(\App\Models\MainPartner::orderBy('sort_order')->where('is_international',FALSE)->get() as $document)
                    <a href="/partner/{{$document->slug}}/{{$lang}}" class="mezh_partner_block">
                        <div class="mezh_partner__img"><img  src="{{$document->logo}}"></div>
                        <span class="mezh_partner_title">{{$document->getLocaleNode($lang)->title}}</span>
                        <div class="partner-text">
                            {!!  $document->getLocaleNode($lang)->text !!}
                        </div>    
                    </a>
                @endforeach
            </div>
        </div>
    </div>

@endsection