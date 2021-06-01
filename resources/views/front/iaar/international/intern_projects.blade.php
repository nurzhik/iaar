@extends('layouts.front')
@section('content')
    <div class="page">
        <div class="container">
            <div class="page_sidebar">
                <ul class="page_nav">
                    <li><a class="nav_item"  href="/iaar/{{\App\Models\StaticPage::where('type_id',20)->first()->slug}}/{{$lang}}">{{\App\Models\StaticPage::where('type_id',20)->first()->getLocaleNode($lang)->title}}</a></li>
                    <li><a class="nav_item" href="/iaar/{{\App\Models\StaticPage::where('type_id',21)->first()->slug}}/{{$lang}}">{{\App\Models\StaticPage::where('type_id',21)->first()->getLocaleNode($lang)->title}}</a></li>
                    <li><a class="nav_item active" href="/iaar/{{\App\Models\StaticPage::where('type_id',22)->first()->slug}}/{{$lang}}">{{\App\Models\StaticPage::where('type_id',22)->first()->getLocaleNode($lang)->title}}</a></li>
                    <li><a class="nav_item" href="/iaar/{{\App\Models\StaticPage::where('type_id',23)->first()->slug}}/{{$lang}}">{{\App\Models\StaticPage::where('type_id',23)->first()->getLocaleNode($lang)->title}}</a></li>
                </ul>
                <div class="contact-mezh">
                    <div class="contact-mezh__img" style="background-image: url('{{$item->teamMembers()->first()->photo}}');"></div>
                    <div class="contact-mezh__text">
                        <div class="contmezh-text">
								<span class="contact-mezh__heading">
									{{__('main.Contact_Person')}}
								</span>
                            <span class="contact-mezh__name">
									{{$item->teamMembers()->first()->getLocaleNode($lang)->name}}
								</span>
                            <span class="contact-mezh__mail">{{$item->teamMembers()->first()->email}}</span>
                        </div>
                    </div>
                </div>
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
            <div class="structure_block">
                <ul class="breadcrumbs">
                    <li><a href="/{{$lang}}">{{__('main.Main')}}</a></li>
                    <li><a>{{__('main.IAAR')}}</a></li>
                    <li><a>{{$item->getLocaleNode($lang)->title}}</a></li>
                </ul>
                <div class="page_nav_title"><p></p></div>
                <span class="page-title">{{$item->getLocaleNode($lang)->title}}</span>
                <div class="static-info">
                    {!! $item->getLocaleNode($lang)->content!!}
                </div>
                @if(is_array(json_decode($item->getLocaleNode($lang)->additional_documents,true)))
                    <div class="tab-part">
                        <ul class="tab-ul">
                            @foreach(json_decode($item->getLocaleNode($lang)->additional_documents,true) as $document)
                                <li class=" @if($loop->first)active @endif">
                                   {{$document['name']}}
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-areas tab-content">
                            @foreach(json_decode($item->getLocaleNode($lang)->additional_documents,true) as $document)
                                <div id="document_{{$loop->index}}" class="tab-content__item @if($loop->first)active @endif">
                                    {!! $document['content'] !!}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection