@extends('layouts.front')
@section('content')
    <section class="news_page">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/{{$lang}}">{{__('main.Main')}}</a></li>
                <li><a href="javascript:;">{{__('main.News')}}</a></li>
            </ul>
            <p style="margin-bottom:35px" class="title">{{__('main.News')}}</p>
            <ul class="news-list">
                @foreach($items as $article)
                <li>
                    <div class="news_item">
                        <a href="/news/{{$article->slug}}/{{$lang}}" class="news_img" style="background: url('{{asset($article->main_image)}}') center / cover no-repeat;"></a>
                        <div class="news_text">
                            <span class="date">  {{date('d.m.Y', strtotime($article->published_at))}}</span>
                            <a class="news_title" href="/news/{{$article->slug}}/{{$lang}}">{{$article->getLocaleNode($lang)->title}}</a>
                            <p class="text">{{$article->getLocaleNode($lang)->short_desc}} </p>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            <div class="pagination">
                {{ $items->appends([])->links('vendor.pagination.front')
                }}
            </div>
        </div>
    </section>

@endsection