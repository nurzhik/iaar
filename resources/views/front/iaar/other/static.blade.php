@extends('layouts.front')
@section('content')
    <div class="page">
        <div class="container">
            <div class="page_sidebar">
                @if(\App\Models\StaticPage::where('type_id',$item->type_id)
                    ->where('appearance_type',1)->count() > 0)
                    <ul class="page_nav">
                        @foreach(\App\Models\StaticPage::where('type_id',$item->type_id)
                        ->where('appearance_type',1)
                        ->orderBy('sort_order')->get() as $page)
                            <li><a class="nav_item @if($page->id == $item->id) active @endif" href="/@if($item->type_id==17){{'students-page'}}@elseif($item->type_id == 31){{'forum-page'}}@else{{'iaar'}}@endif/{{$page->slug}}/{{$lang}}">{{$page->getLocaleNode($lang)->title}}</a></li>
                        @endforeach
                    </ul>
                @endif
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
            <div class="content_block">
                <ul class="breadcrumbs">
                    <li><a href="/{{$lang}}">{{__('main.Main')}}</a></li>
                    <li><a>{{$item->getLocaleNode($lang)->title}}</a></li>
                </ul>
                <div class="page_nav_title"><p></p></div>
                <h1 class="page-title">{{$item->getLocaleNode($lang)->title}}</h1>
                <div class="static-info @if($item->type_id == 6 ) doc_href_show @endif">
                    @if(strlen($item->main_image)>3)
                        <img class="static-info__img" src="{{$item->main_image}}">
                    @endif
                    {!!  $item->getLocaleNode($lang)->content !!}
                </div>
                @if(strlen($item->getLocaleNode($lang)->additional_documents))
                    <div class="public_block">
                        <div class="naar_report_list naar_report_list--2">
                            @foreach(json_decode($item->getLocaleNode($lang)->additional_documents,true) as $document)
                                <div class="pdf-item  @if($loop->first)active @endif">
                                    <p class="pdf-item__name">{{$document['name']}}</p>
                                    <div class="pdf-item__text">
                                        <div class="pdf-item__pad">
                                            <a data-file="{{$document['file']}}" data-fancybox data-src="#report_1" href="javascript:;" class="pdf-img" style="background: url('{{asset($document['image_preview'])}}') center / cover no-repeat;">
                                                <div class="pdf-img__btn">
                                                   {{__('main.More')}}
                                                </div>
                                            </a>                                                                               
                                        </div>
                                    </div>                                        
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div id="report_1" class="report_album">
    </div>
    <script src="{{asset('front/js/flip/js/libs/pdf.min.js')}}"></script>
    <script src="{{asset('front/js/flip/js/dflip.min.js')}}"></script>
    <script>
        var dFlipLocation = '{{App::make('url')->to('/')}}/front/js/flip/';
        $(document).ready(function(){
            $('.pdf-img').on('click',function(){
                $('#report_1').html('');
                var pdf = encodeURI($(this).data('file'));
                var options = {
                    height: 600,
                    webgl: false
                };
                var flipBook = $('#report_1').flipBook(pdf, options);
            })
        });
    </script>
@endsection
