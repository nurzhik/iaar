@extends('layouts.front')
@section('content')
<div class="page">
    <div class="container">
        <div class="page_sidebar">
            <ul class="page_nav">
                @foreach(\App\Models\StaticPage::where('type_id',2)->orderBy('sort_order')->get() as $page)
                    <li><a class="nav_item @if($page->id == $item->id) active @endif" href="/iaar/{{$page->slug}}/{{$lang}}">{{$page->getLocaleNode($lang)->title}}</a></li>
                @endforeach
                <li><a class="nav_item" href="/iaar/{{\App\Models\StaticPage::where('type_id',4)->first()->slug}}/{{$lang}}">{{__('main.Experts')}}</a></li>
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
        <div class="sovet">
            <ul class="breadcrumbs">
                <li><a href="/{{$lang}}">{{__('main.Main')}}</a></li>
                <li><a>{{$item->getLocaleNode($lang)->title}}</a></li>
            </ul>
            <div class="page_nav_title"><p></p></div>
            <p class="page-title">{{$item->getLocaleNode($lang)->title}}</p>
            <div class="static-info">
                {!!  $item->getLocaleNode($lang)->content !!}
            </div>
            <div class="sovet_block">
                @foreach($board_members as $member)
                @if(empty($member->tab_id) )
                <div class="sovet_item @if($loop->first)sovet_item--active @endif way">
                    <div class="sovet_img" style="background: url('{{$member->photo}}') center / cover no-repeat;"></div>
                    <div class="sovet_text">
                        <div class="sovet_name">
                            <p class="team_name">{{$member->getLocaleNode($lang)->title}}</p>
                            <p class="team_position">{{$member->getLocaleNode($lang)->job}}</p>
                        </div>
                        <div class="about_sovet_text">
                            <p class="about_sovet_item">{{$member->getLocalenode($lang)->short_desc}}</p>
                        </div>    
                        <a class="sovet_btn" data-fancybox data-src="#sovet_{{$member->id}}" href="javascript:;">{{__('main.More')}}</a>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
            @foreach($board_members as $member)
            <div id="sovet_{{$member->id}}" class="sovet_info">
                <div class="sovet_img" style="background: url('{{$member->photo}}') center / cover no-repeat;"></div>
                <p class="title">{{$member->getLocaleNode($lang)->title}}</p>
                {!! $member->getLocalenode($lang)->content !!}
            </div>
            @endforeach


            @foreach($tabs as $tab)
                <div class="pdf-item ">
                    <div class="pdf-item__name @if($loop->first) active @endif">{{$tab->getLocaleNode($lang)->title}}</div>
                    @foreach($board_members as $member)
                        @if($member->tab_id == $tab->id)
                            <div class="sovet_item @if($loop->first)sovet_item--active @endif way">
                                <div class="sovet_img" style="background: url('{{$member->photo}}') center / cover no-repeat;"></div>
                                <div class="sovet_text">
                                    <div class="sovet_name">
                                        <p class="team_name">{{$member->getLocaleNode($lang)->title}}</p>
                                        <p class="team_position">{{$member->getLocaleNode($lang)->job}}</p>
                                    </div>
                                    <div class="about_sovet_text">
                                        <p class="about_sovet_item">{{$member->getLocalenode($lang)->short_desc}}</p>
                                    </div>    
                                    <a class="sovet_btn" data-fancybox data-src="#sovet_{{$member->id}}" href="javascript:;">{{__('main.More')}}</a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    <ul class="docs">
                    @foreach(\App\Models\CommisionFile::where('type_id',$tab->id)->get() as $file)
                           
                               <li>
                                   <a class="doc_link" target="_blank" href="{{$file->getLocaleNode($lang)->file}}">{{$file->getLocaleNode($lang)->title}}</a>
                               </li>
                          
                         
                       
                    @endforeach
                     </ul>

                </div>  
            @endforeach
        </div>
    </div>
</div>
@endsection