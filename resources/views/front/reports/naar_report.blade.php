@extends('layouts.front')
@section('content')
    <div class="page">
        <div class="container">
            <div class="page_sidebar">
                <ul class="page_nav">
                    <li><a class="nav_item @if($page_type=='year')active @endif " href="/reports/{{\App\Models\StaticPage::where('type_id',11)->first()->slug}}/{{$lang}}">{{\App\Models\StaticPage::where('type_id',11)->first()->getLocaleNode($lang)->title}}</a></li>
                    <li><a class="nav_item @if($page_type =='anal') active @endif"   href="/reports/{{\App\Models\StaticPage::where('type_id',12)->first()->slug}}/{{$lang}}">{{\App\Models\StaticPage::where('type_id',12)->first()->getLocaleNode($lang)->title}}</a></li>
                </ul>
                @if($page_type=='year')
                <div class="sidebar_img" style="background: url('{{asset('front/img/sidebar_img.png')}}') center / cover no-repeat;"></div>
                @else
                    <div class="sidebar_img" style="background:url('{{asset('front/img/sidebar_img.png')}}') center / cover no-repeat;"></div>
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
            </div>
            <div class="content_block">
                <ul class="breadcrumbs">
                    <li><a href="/{{$lang}}">{{__('main.Main')}}</a></li>
                    <li><a>{{__('main.Otchety_NAAR')}}</a></li>
                </ul>
                <div class="page_nav_title"><p></p></div>
                <p class="title">{{$item->getLocaleNode($lang)->title}}</p>
                @if($page_type == "year")
                <div class="grafik_block">
                    <div class="grafik_top" id="grafik"></div>
                </div>
                @else
                    <div class="grafik_block">
                        <div class="grafik_top_2">
                            <ul class="left_number">
                                <li>1000</li>
                                <li>750</li>
                                <li>500</li>
                                <li>250</li>
                                <li>0</li>
                            </ul>
                            <div class="grafik_item_block">
                                <div class="grafik_item" data-attr="65"><p>2016</p></div>
                                <div class="grafik_item" data-attr="100"><p>2017</p></div>
                                <div class="grafik_item" data-attr="115"><p>2018</p></div>
                                <div class="grafik_item" data-attr="120"><p>2019</p></div>
                                <div class="grafik_item" data-attr="150"><p>2020</p></div>
                                <div class="grafik_item" data-attr="200"><p>2021</p></div>
                            </div>
                        </div>
                        <ul class="bottom_number">
                        </ul>
                    </div>
                @endif
                <div class="public_block">
                    <p class="year otchet_list_title">{{__('main.List_Reports')}}</p>
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
            </div>
        </div>
    </div>
    <div id="report_1" class="report_album">
    <script src="{{asset('front/js/chart/core.js')}}"></script>
    <script src="{{asset('front/js/chart/animated.js')}}"></script>
    <script src="{{asset('front/js/chart/charts.js')}}"></script>
    <script>
            am4core.useTheme(am4themes_animated);

            var chart = am4core.create("grafik", am4charts.XYChart);
            chart.paddingRight = 20;

            var data = [];
            var visits = 10;
            for (var i = 1; i < 366; i++) {
                visits += Math.round((Math.random() < 0.5 ? 1 : -1) * Math.random() * 10);
                data.push({ date: new Date(2018, 0, i), value: visits });
            }

            chart.data = data;

            var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
            dateAxis.renderer.grid.template.location = 0;

            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis.tooltip.disabled = true;
            valueAxis.renderer.minWidth = 35;
            valueAxis.renderer.labels.template.fontSize = 0;

            var series = chart.series.push(new am4charts.LineSeries());
            series.dataFields.dateX = "date";
            series.dataFields.valueY = "value";
            series.tooltipText = "{valueY}";
            series.tooltip.pointerOrientation = "vertical";
            series.tooltip.background.fillOpacity = 0.5;

            chart.cursor = new am4charts.XYCursor();
            chart.cursor.snapToSeries = series;
            chart.cursor.xAxis = dateAxis;

            var bullet = series.bullets.push(new am4charts.CircleBullet());
            bullet.circle.strokeWidth = 2;
            bullet.circle.radius = 4;
            bullet.circle.fill = am4core.color("#fff");

            var bullethover = bullet.states.create("hover");
            bullethover.properties.scale = 1.3;

            // var scrollbarX = new am4charts.XYChartScrollbar();
            // scrollbarX.series.push(series);
            // chart.scrollbarX = scrollbarX;

            chart.data = [{
                "date": "2013-01-01",
                "value":37
            }, {
                "date": "2014-01-01",
                "value":50
            }, {
                "date": "2015-01-01",
                "value":60
            }, {
                "date": "2016-01-01",
                "value":65
            }, {
                "date": "2017-01-01",
                "value":70
            }, {
                "date": "2018-01-01",
                "value":103
            }, {
                "date": "2019-01-01",
                "value":126
            }, {
                "date": "2020-01-01",
                "value":129
            }, {
                "date": "2021-01-01",
                "value":170
            }]
        </script>
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