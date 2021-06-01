@extends('layouts.front')
@section('content')
    <section class="journal page">
        <div class="container">
            <div class="page_sidebar">
                <ul class="page_nav">
                    <li><a class="nav_item active" href="/reports/{{\App\Models\StaticPage::where('type_id',29)->first()->slug}}/{{$lang}}">{{\App\Models\StaticPage::where('type_id',29)->first()->getLocaleNode($lang)->title}} </a></li>
                    <li><a class="nav_item" href="/reports/{{\App\Models\StaticPage::where('type_id',25)->first()->slug}}/{{$lang}}">{{\App\Models\StaticPage::where('type_id',25)->first()->getLocaleNode($lang)->title}} </a></li>
                    <li><a class="nav_item" href="/reports/{{\App\Models\StaticPage::where('type_id',26)->first()->slug}}/{{$lang}}">{{\App\Models\StaticPage::where('type_id',26)->first()->getLocaleNode($lang)->title}} </a></li>
                    <li><a class="nav_item" href="/reports/{{\App\Models\StaticPage::where('type_id',27)->first()->slug}}/{{$lang}}">{{\App\Models\StaticPage::where('type_id',27)->first()->getLocaleNode($lang)->title}} </a></li>
                    <li><a class="nav_item" href="/reports/{{\App\Models\StaticPage::where('type_id',28)->first()->slug}}/{{$lang}}">{{\App\Models\StaticPage::where('type_id',28)->first()->getLocaleNode($lang)->title}} </a></li>
                    <li><a class="nav_item" href="/reports/{{\App\Models\StaticPage::where('type_id',13)->first()->slug}}/{{$lang}}">{{\App\Models\StaticPage::where('type_id',13)->first()->getLocaleNode($lang)->title}} </a></li>
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
            </div>
            <div class="content_block">
                <ul class="breadcrumbs">
                    <li><a href="/{{$lang}}">{{__('main.Main')}}</a></li>
                    <li><a>{{$item->getLocaleNode($lang)->title}}</a></li>
                </ul>
                <div class="page_nav_title"><p></p></div>
                <p class="title">{{$item->getLocaleNode($lang)->title}}</p>
                <div class="top_rating">
                    <!-- <div class="journal_img"></div> -->
                    <div class="rating_text">
                            {!! $item->getLocaleNode($lang)->content !!}
                    </div>
                </div>
                <div class="rating_res_block rating_res_block--journal">
                    @foreach($documents as $document)
                    <div class="journal_item">
                        <a href="javascript:;"   data-file="{{$document->getLocaleNode($lang)->file}}" class="magazine-item pdf_read journal_button" data-fancybox data-src="#report_1" style="background-image: url('{{$document->getLocaleNode($lang)->image}}');">
                            <div class="magazine-item__text">
                                <!--<div class="magazine-item__number"><span>№</span>{{$loop->index +1 }}</div> -->
                                <span class="magazine-item__heading" >{{$document->getLocaleNode($lang)->title}}</span>
                            </div>
                            <div class="magazine-item__btn">{{__('main.More')}}</div>
                        </a>                        
                        <!-- <p class="about_sovet_item">{{$document->getLocaleNode($lang)->short_desc}}</p> -->
                    </div>
                    @endforeach

                </div>
                <!--<div class="pagination">
                    <a href="javascript:;" class="pag first"></a>
                    <a href="javascript:;" class="pag">1</a>
                    <a href="javascript:;" class="pag">2</a>
                    <a href="javascript:;" class="pag active">3</a>
                    <a href="javascript:;" class="pag">4</a>
                    <a href="javascript:;" class="pag">5</a>
                    <a href="javascript:;" class="pag last"></a>
                </div> -->
            </div>
            <div id="report_1" class="report_album"></div>
        </div>
    </section>
    <script src="{{asset('front/js/flip/js/libs/pdf.min.js')}}"></script>
    <script src="{{asset('front/js/flip/js/dflip.min.js')}}"></script>
    <script>
        var dFlipLocation = '{{App::make('url')->to('/')}}/front/js/flip/';
        $(document).ready(function(){
            $('.journal_button').on('click',function(){
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