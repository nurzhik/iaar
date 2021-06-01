@extends('layouts.front')
@section('content')
    <div class="page">
        <div class="container">
            <div class="page_sidebar">
                <ul class="page_nav">
                    @foreach(\App\Models\Postmonitoring::get() as $nav)
                        <li><a class="nav_item " href="/postmonitorings/{{$nav->slug}}/{{$lang}}">
                            {{$nav->getLocaleNode($lang)->title}} </a></li>
                    @endforeach
                   
                </ul>
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
                @if($item->slug =="postakkreditacionnyj-monitoring")
                <div style="margin-top:40px;" class="akkr_docs">
                    <p class="sidebar_title">{{__('main.Documents')}}</p> 
                    <ul class="docs" style="margin-bottom:25px;">
                        @foreach($documents as $document)
                            <li>
                                <a download="download" class="doc_link" href="{{$document->getLocaleNode($lang)->file}}">
                                    {{$document->getLocaleNode($lang)->title}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
            <div class="content_block">
                <ul class="breadcrumbs">
                    <li><a href="/{{$lang}}">{{__('main.Main')}}</a></li>
                    <li><a>{{$item->getLocaleNode($lang)->title}}</a></li>
                </ul>
                <div class="page_nav_title"><p></p></div>
                <p class="page-title">{{$item->getLocaleNode($lang)->title}}</p>
                 <div class="page-text">{!!$item->getLocaleNode($lang)->content!!}</div>

                @if($item->id != 8)

                    @foreach($tabs as $tab)
                        @if($item->id != 6)
        	            <div class="pdf-item  @if($loop->first) active @endif">
        	                <div class="pdf-item__name @if($loop->first) active @endif">{{$tab->getLocaleNode($lang)->title}}</div>
        	                @foreach(\App\Models\File::where('type_id',$tab->id)->orderBy('title','asc')->get() as $file)
                           
                                    <div class="pdf-item__text">
                	                    <div class="public_item public_item--text">
                                            @if($item->id != 5)
                	                        <div class="public_img" style="background-image: url('{{$file->getLocaleNode($lang)->image}}');"></div>
                                            @endif
                	                        <div class="public_text">
                	                            <p>{{$file->getLocaleNode($lang)->title}}</p>
                	                            <a class="sovet_btn"  data-file="{{$file->getLocaleNode($lang)->file}}" data-fancybox data-src="#report_1" href="javascript:;">{{__('main.More')}}</a>
                	                        </div>
                	                    </div>
                	                </div>
                               
                            @endforeach
        	          
        	            </div>  
                        @else
                        <div class="public_block">
                            <p class="year">
                                {{$tab->getLocaleNode($lang)->title}}
                            </p>
                            @foreach(\App\Models\File::where('type_id',$tab->id)->get() as $file)
                                <div class="public_item">
                                    <div class="public_img" style="background-image: url('{{$file->getLocaleNode($lang)->image}}');"></div>
                                    <div class="public_text">
                                        <p>{{$file->getLocaleNode($lang)->title}}</p>
                                        <a class="sovet_btn" data-file="{{$file->getLocaleNode($lang)->file}}" data-fancybox="" data-src="#report_1" href="javascript:;">Подробнее</a>
                                    </div>
                                </div>
                            @endforeach
                        </div> 
                        @endif
    	            @endforeach
               @else
                   @foreach(\App\Models\File::where('page_id',$item->id)->get() as $file)
                            <div class="public_item public_item--text" style="margin-bottom: 25px;">
                                <div class="public_img" style="background-image: url('{{$file->getLocaleNode($lang)->image}}');"></div>
                                <div class="public_text">
                                    <p>{{$file->getLocaleNode($lang)->title}}</p>
                                    <a class="sovet_btn"  data-file="{{$file->getLocaleNode($lang)->file}}" data-fancybox data-src="#report_1" href="javascript:;">{{__('main.More')}}</a>
                                </div>
                            </div>
                    @endforeach
                @endif
        
    </div>
    </div>
    <div id="report_1" class="report_album">

    </div>
    <script src="{{asset('front/js/flip/js/libs/pdf.min.js')}}"></script>
    <script src="{{asset('front/js/flip/js/dflip.min.js')}}"></script>
    <script>
        var dFlipLocation = '{{App::make('url')->to('/')}}/front/js/flip/';
        $(document).ready(function(){
            $('.sovet_btn').on('click',function(){
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