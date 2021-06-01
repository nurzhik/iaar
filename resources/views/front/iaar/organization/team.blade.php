@extends('layouts.front')
@section('content')
<div class="page">
    <div class="container">
        <div class="page_sidebar">
            <ul class="page_nav">
                @foreach(\App\Models\StaticPage::where('type_id',2)->orderBy('sort_order')->get() as $page)
                    <li><a class="nav_item" href="/iaar/{{$page->slug}}/{{$lang}}">{{$page->getLocaleNode($lang)->title}}</a></li>
                @endforeach
                <li><a class="nav_item" href="/iaar/{{\App\Models\StaticPage::where('type_id',4)->first()->slug}}/{{$lang}}">{{__('main.Experts')}}</a></li>
                <li><a class="nav_item active" href="">{{__('main.Our_team')}}</a></li>
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
        <div class="team">
            <ul class="breadcrumbs">
                <li><a href="/{{$lang}}">{{__('main.Main')}}</a></li>
                <li><a>{{__('main.Our_team')}}</a></li>
            </ul>
            <div class="page_nav_title"><p></p></div>
            <p class="title">{{__('main.Our_team')}}</p>
            <div class="team_item director way">
                <a class="team_img" data-fancybox data-src="#team_{{$director->id}}" href="javascript:;">
                    <div class="view">
                        <div class="view_img"></div>
                        <p class="view_text">{{__('main.view_profile')}}</p>
                    </div>
                    <img src="{{$director->photo}}" alt="{{$director->getLocaleNode($lang)->name}}">
                </a>
                <div class="director_text">
                    <span class="director_name">{{$director->getLocaleNode($lang)->name}}</span>
                    <p class="team_position">{{$director->getLocaleNode($lang)->job}}</p>
                    <a href="javascript:;" data-fancybox data-src="#team_{{$director->id}}" class="vyz_info_btn">{{__('main.More')}}</a>
                </div>
            </div>
            <div class="team_cards">
                @foreach($team_members as $member)
                <div class="team_item way">
                    <a class="team_img" data-fancybox data-src="#team_{{$member->id}}" href="javascript:;">
                        <div class="view">
                            <div class="view_img"></div>
                            <p class="view_text">{{__('main.view_profile')}}</p>
                        </div>
                        <img src="{{$member->photo}}" alt="{{$member->getLocaleNode($lang)->name}}">
                    </a>
                    <span class="team_name">{{$member->getLocaleNode($lang)->name}}</span>
                    <p class="team_position">{{$member->getLocaleNode($lang)->job}}</p>
                </div>
                @endforeach
            </div>
            <div id="team_{{$director->id}}" class="team_info">
                <div class="info_top">
                    <div class="info_img">
                        <img src="{{$director->photo}}" alt="{{$director->getLocaleNode($lang)->name}}">
                    </div>
                    <div class="info_name">
                        <span class="team_name">{{$director->getLocaleNode($lang)->name}}</span>
                        <ul class="team_contact">
                            <li><a class="team_tel" href="tel:{{$director->phone}}">{{$director->phone}}</a></li>
                            <li><a class="team_skype" href="javascript:;">{{$director->skype}}</a></li>
                            <li><a class="team_mail" href="mailto:{{$director->email}}">{{$director->email}}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="info_bottom">
                    <div class="row">
                        <div class="col_1">{{__('main.Position')}}:</div>
                        <div class="col_2">{{$director->getLocaleNode($lang)->job}}</div>
                    </div>
                    <!-- <div class="row">
                        <div class="col_1">Опыт работы:</div>
                        <div class="col_2">{{$director->getLocaleNode($lang)->experience}}</div>
                    </div> -->
                    <div class="row">
                        <div class="col_1">{{__('main.Education')}}:</div>
                        <div class="col_2">{{$director->getLocaleNode($lang)->education}}</div>
                    </div>
                    <div class="row">
                        <div class="col_1">{{__('main.Languages')}}:</div>
                        <div class="col_2">{{$director->getLocaleNode($lang)->languages}}</div>
                    </div>
                   <!--  <div class="row">
                        <div class="col_1">Область отвественности:</div>
                        <div class="col_2">{{$director->getLocaleNode($lang)->qualities}}</div>
                    </div>  -->
                </div>
            </div>
            @foreach($team_members as $member)
                <div id="team_{{$member->id}}" class="team_info">
                    <div class="info_top">
                        <div class="info_img">
                            <img src="{{$member->photo}}" alt="{{$member->getLocaleNode($lang)->name}}">
                        </div>
                        <div class="info_name">
                            <span class="team_name">{{$member->getLocaleNode($lang)->name}}</span>
                            <ul class="team_contact">
	                            <li><a class="team_tel" href="tel:{{$director->phone}}">{{$member->phone}}</a></li>
	                            <li><a class="team_skype" href="javascript:;">{{$member->skype}}</a></li>
	                            <li><a class="team_mail" href="mailto:{{$director->email}}">{{$member->email}}</a></li>
	                        </ul>
                        </div>
                    </div>
                    <div class="info_bottom">
                        <div class="row">
                            <div class="col_1">{{__('main.Position')}}:</div>
                            <div class="col_2">{{$member->getLocaleNode($lang)->job}}</div>
                        </div>
                        <!-- <div class="row">
                            <div class="col_1">Опыт работы:</div>
                            <div class="col_2">{{$member->getLocaleNode($lang)->experience}}</div>
                        </div> -->
                        <div class="row">
                            <div class="col_1">{{__('main.Education')}}:</div>
                            <div class="col_2">{{$member->getLocaleNode($lang)->education}}</div>
                        </div>
                        <div class="row">
                            <div class="col_1">{{__('main.Languages')}}:</div>
                            <div class="col_2">{{$member->getLocaleNode($lang)->languages}}</div>
                        </div>
                        <div class="row">
                            <div class="col_1">{{__('main.area_responsibility')}}:</div>
                            <div class="col_2">{{$member->getLocaleNode($lang)->qualities}}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection