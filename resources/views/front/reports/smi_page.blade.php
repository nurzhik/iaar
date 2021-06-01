@extends('layouts.front')
@section('content')
    <div class="page">
        <div class="container">
            <div class="page_sidebar">
                <ul class="page_nav">
                    <li><a class="nav_item" href="/reports/{{\App\Models\StaticPage::where('type_id',11)->first()->slug}}/{{$lang}}">{{__('main.Otchety_NAAR')}}</a></li>
                    <li><a class="nav_item" href="/reports/vek-reports/{{$lang}}">{{__('main.Otchety_VEK')}}</a></li>
                    <li><a class="nav_item" href="/reports/{{\App\Models\StaticPage::where('type_id',29)->first()->slug}}/{{$lang}}">{{__('main.Journal_QA')}}</a></li>
                    <li><a class="nav_item " href="/reports/{{\App\Models\StaticPage::where('type_id',14)->first()->slug}}/{{$lang}}">{{__('main.Publication_IAAR')}}</a></li>
                    <li><a class="nav_item" href="/reports/{{\App\Models\StaticPage::where('type_id',15)->first()->slug}}/{{$lang}}">{{__('main.Videoachive')}}</a></li>
                    <li><a class="nav_item active" href="/reports/{{\App\Models\StaticPage::where('type_id',16)->first()->slug}}/{{$lang}}">{{__('main.Smii_o_naar')}}</a></li>
                </ul>
                @if(strlen($item->getLocaleNode($lang)->documents))
                    <div class="page_docs">
                        <p class="sidebar_title">{{__('main.Documents')}}</p>
                        <ul class="docs">
                            @if(is_array(json_decode($item->getLocaleNode($lang)->documents,true)))
                                @foreach(json_decode($item->getLocaleNode($lang)->documents,true) as $document)
                                    <li><a class="doc_link"  download   href="{{$document['file']}}">{{$document['name']}}</a></li>
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
            <div class="structure_block">
                <ul class="breadcrumbs">
                    <li><a href="/{{$lang}}">{{__('main.Main')}}</a></li>
                    <li>{{__('main.IAAR')}}</li>
                    <li><a>{{$item->getLocaleNode($lang)->title}}</a></li>
                </ul>
                <div class="page_nav_title"><p></p></div>
                <span class="page-title">{{$item->getLocaleNode($lang)->title}}</span>
                @if(strlen($item->getLocaleNode($lang)->additional_documents))
                    <div class="public_block">
                        <div class="naar_report_list naar_report_list--2">
                            @foreach(json_decode($item->getLocaleNode($lang)->additional_documents,true) as $document)
                                <div class="pdf-item  @if($loop->first)active @endif">
                                    <p class="pdf-item__name">{{$document['name']}}</p>
                                    <div class="pdf-item__text">
                                        <div class="pdf-item__pad">
                                            <a data-file="{{$document['file']}}" data-fancybox data-src="#report_1" href="javascript:;" class="pdf-img" style="background: url('{{asset($document['image_preview'])}}') center / cover no-repeat;"></a>
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