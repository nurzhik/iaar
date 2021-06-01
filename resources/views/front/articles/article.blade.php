@extends('layouts.front')
@section('content')
    <section class="news_page">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/{{$lang}}">{{__('main.Main')}}</a></li>
                <li><a href="@if($item->is_event)/events/future/{{$lang}}@else/news-all/{{$lang}}@endif">@if($item->is_event){{__('main.Events')}} @else {{__('main.News')}} @endif</a></li>
                <li><a>{{$item->getLocaleNode($lang)->title}}</a></li>
            </ul>
            <p class="title">{{$item->getLocaleNode($lang)->title}}</p>
            <p style="margin: 15px 0 30px;" class="date">@if($item->is_event){{date('d.m.Y',strtotime($item->event_date))}} @else {{date('d.m.Y',strtotime($item->published_at))}} @endif</p>
            <div class="news-part">
                <div class="news-part__info">
                    <div class="static-info">
                        @if($item->is_event)
                            <img class="center-static-img" src="{{asset($item->main_image)}}">
                        @endif
                        {!! $item->getLocaleNode($lang)->text !!}
                    </div>
                    @if($item->attachments()->count())
                    <div class="public_block">
                        <p class="year otchet_list_title">Приложения</p>
                        <div class="naar_report_list naar_report_list--2">
                            @foreach($item->attachments()->orderBy('sort_order')->get() as $document)
                                <div class="pdf-item  @if($loop->first)active @endif">
                                    <p class="pdf-item__name">{{$document->getLocaleNode($lang)->title}}</p>
                                    <div class="pdf-item__text">
                                        <div class="pdf-item__pad">
                                            <a data-file="{{$document->getLocaleNode($lang)->file}}" data-fancybox data-src="#report_1" href="javascript:;" class="pdf-img" style="background: url('{{asset($document->getLocaleNode($lang)->image)}}') center / cover no-repeat;">
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

                <div class="news-part__right">
                    <div class="news-right">
                        <ul class="news-list">
                            @if($item->is_event)
                                @foreach(\App\Models\Events::where('id','<>',$item->id)->orderBy('event_date','DESC')->get()->take(4) as $event)
                                <li>
                                    <div class="news_item">
                                        <a href="/event/{{$event->slug}}/{{$lang}}" class="news_img" style="background: url('{{asset($event->main_image)}}') center / cover no-repeat;"></a>
                                        <div class="news_text">
                                            <span class="date">{{date('d.m.Y',strtotime($event->event_date))}}</span>
                                            <a class="news_title" href="/event/{{$event->slug}}/{{$lang}}">{{$event->getLocaleNode($lang)->title}}</a>
                                            <p class="text">{{$event->getLocaleNode($lang)->short_desc}}</p>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            @else
                                @foreach(\App\Models\News::where('id','<>',$item->id)->where('published',TRUE)->orderBy('published_at','DESC')->get()->take(4) as $article)
                                <li>
                                    <div class="news_item news_item--right">
                                        <a href="/news/{{$article->slug}}/{{$lang}}" class="news_img" style="background: url('{{asset($article->main_image)}}') center / cover no-repeat;"></a>
                                        <div class="news_text">
                                            <span class="date">{{date('d.m.Y',strtotime($article->published_at))}}</span>
                                            <a class="news_title" href="/news/{{$article->slug}}/{{$lang}}">{{$article->getLocaleNode($lang)->title}}</a>
                                            <p class="text">{{$article->getLocaleNode($lang)->short_desc}}</p>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="report_1"></div>
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
