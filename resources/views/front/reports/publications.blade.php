@extends('layouts.front')
@section('content')
<div class="page">
    <div class="container">
        <div class="page_sidebar">
            <ul class="page_nav">

                <li><a class="nav_item" href="/reports/{{\App\Models\StaticPage::where('type_id',11)->first()->slug}}/{{$lang}}">{{__('main.Otchety_NAAR')}}</a></li>
                <li><a class="nav_item" href="/reports/vek-reports/{{$lang}}">{{__('main.Otchety_VEK')}}</a></li>
                <li><a class="nav_item" href="/reports/{{\App\Models\StaticPage::where('type_id',29)->first()->slug}}/{{$lang}}">{{__('main.Journal_QA')}}</a></li>
                <li><a class="nav_item active " href="/reports/{{\App\Models\StaticPage::where('type_id',14)->first()->slug}}/{{$lang}}">{{\App\Models\StaticPage::where('type_id',14)->first()->getLocaleNode($lang)->title}}</a></li>
                <li><a class="nav_item" href="/reports/{{\App\Models\StaticPage::where('type_id',15)->first()->slug}}/{{$lang}}">{{__('main.Videoachive')}}</a></li>
                <!-- <li><a class="nav_item " href="/reports/{{\App\Models\StaticPage::where('type_id',16)->first()->slug}}/{{$lang}}">{{__('main.Smii_o_naar')}}</a></li> -->
            </ul>
            <div class="page_news">
                <p class="sidebar_title">{{__('main.More')}}</p>
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
                <li><a>{{\App\Models\StaticPage::where('type_id',14)->first()->getLocaleNode($lang)->title}}</a></li>
            </ul>
            <div class="page_nav_title"><p></p></div>
            <p class="title">{{\App\Models\StaticPage::where('type_id',14)->first()->getLocaleNode($lang)->title}}</p>

            @foreach($documents as $document)
                @if($loop->first)
                    <?php $current_year = 0; ?>
                @endif
            @if($current_year !== $document->year)
                        @if(!$loop->first)
                            </div>
                        @endif
                <div class="public_block">
                    <p class="year">{{$document->year}} г.</p>
                @endif
                <div class="public_item">
                    <div class="public_img" style="background-image: url('{{$document->getLocaleNode($lang)->image}}');"></div>
                    <div class="public_text">
                        <p>{{$document->getLocaleNode($lang)->title}}</p>
                        <a class="sovet_btn"  data-file="{{$document->getLocaleNode($lang)->file}}" data-fancybox data-src="#report_1" href="javascript:;">{{__('main.More')}}</a>
                    </div>
                </div>
                    @if($loop->last)
                        </div>
                    @endif
                <?php $current_year = $document->year; ?>
            @endforeach
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