@extends('layouts.front')
@section('content')
    <div class="page monitoring">
        <div class="container">
            <!-- <div class="page_sidebar">
                
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
            </div> -->            
            <ul class="breadcrumbs">
                <li><a href="/{{$lang}}">{{__('main.Main')}}</a></li>
                <li>{{__('main.Postmonitoring')}}</li>
            </ul>
            <p class="page-title">{{__('main.Postmonitoring')}}</p>            
            <div class="postable-part">                    
                <div class="post_table_block">
                    {!! $item->getLocaleNode($lang)->content !!}
                </div>
                <div class="documenting">
                    <p class="section-heading">{{__('main.Documents')}}</p>
                    <ul class="mydocs_list">
                        @if(is_array(json_decode($item->getLocaleNode($lang)->documents,true)))
                            @foreach(json_decode($item->getLocaleNode($lang)->documents,true) as $document)
                                <li><a  download  href="{{$document['file']}}">{{$document['name']}}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>                     
                <span class="section-heading">Результаты постаккредитационного мониторинга</span>
                @if(is_array(json_decode($item->getLocaleNode($lang)->additional_documents,true)))
                <ul class="post-ul post-ul--post">
                    @foreach(json_decode($item->getLocaleNode($lang)->additional_documents,true) as $document)
                    <li>
                        <div  class="post-item" >
                            <a class="post-item__img asdasdasd" data-file="{{$document['file']}}" data-fancybox data-src="#report_1" href="javascript:;" >
                                <img src="{{$document['image_preview']}}">
                                <span class="post-item__heading">{{$document['name']}}</span>
                            </a>
                        </div>
                    </li>
                    @endforeach

                </ul>
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
            $('.asdasdasd').on('click',function(){
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