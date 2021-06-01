@extends('layouts.front')
@section('content')
    <section class="video">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/{{$lang}}">{{__('main.Main')}}</a></li>
                <li><a>{{__('main.Events')}}</a></li>
            </ul>
            <script>
                $(document).ready(function(){
                    @if($type=='past')
                    $('.next_events').show();
                    $('.prev_events').hide();
                    @endif
                    $('.date_start_option').on('click',function(){
                        var value = $(this).data('value');
                        window.location.href = '{{App::make('url')->to('/')}}/events/past/{{$lang}}/?year='+value;
                    })
                });
            </script>
            <p class="title">{{__('main.Events')}}</p>
            <div class="event_btn_block">
                <a class="event_prev event_btn  @if($type=='future' )active @endif " href="javascript:;">{{__('main.Upcoming_Events')}}</a>
                <a class="event_next event_btn @if($type=='past' )active @endif  " href="javascript:;">{{__('main.Past_Events')}}</a>
            </div>
            <div class="event_block prev_events">
                @foreach($future_events as $event)
                <div class="event_item">
                    <a href="/event/{{$event->slug}}/{{$lang}}" class="event_img" style="background-image: url('{{asset($event->main_image)}}');"></a>
                    <div class="video_text">
                        <span class="video_date">{{date('d.m.Y',strtotime($event->event_date))}}</span>
                        <a href="/event/{{$event->slug}}/{{$lang}}" class="sidebar_title event_name">{{$event->getLocaleNode($lang)->title}}</a>
                        <p class="event_text">{{$event->getLocaleNode($lang)->short_desc}}</p>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="next_events">
                <div class="sel_block event_year">
                    <div class="sel_block__top">
                        <label class="label" for="">{{__('main.Year')}}</label>
                        <div class="help">
                            <div class="help__part">
                                <div class="help_text">
                                    Выберите год события
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="reestr_select">
                        <p data-attr="{{isset($request->year) ? $request->year : \Carbon\Carbon::now()->year}}" class="sel_title last_sel">{{isset($request->year) ? $request->year : \Carbon\Carbon::now()->year}}</p>
                        <ul class="options">
                            @foreach(\App\Models\StaticPage::getYearsArray() as $year)
                                <li data-value="{{$year}}"  class="sel_opt date_start_option @if($request->year == $year) active @endif"  href="javascript:;">{{$year}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="event_block">
                    @foreach($past_events as $event)
                        <div class="event_item">
                            <a href="/event/{{$event->slug}}/{{$lang}}" class="event_img" style="background-image: url('{{asset($event->main_image)}}');"></a>
                            <div class="video_text">
                                <span class="video_date">{{date('d.m.Y',strtotime($event->event_date))}}</span>
                                <a href="/event/{{$event->slug}}/{{$lang}}" class="sidebar_title event_name">{{$event->getLocaleNode($lang)->title}}</a>
                                <p class="event_text">{{$event->getLocaleNode($lang)->short_desc}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!--
            <div class="pagination">
                <a href="javascript:;" class="pag first"></a>
                <a href="javascript:;" class="pag">1</a>
                <a href="javascript:;" class="pag">2</a>
                <a href="javascript:;" class="pag active">3</a>
                <a href="javascript:;" class="pag">4</a>
                <a href="javascript:;" class="pag">5</a>
                <a href="javascript:;" class="pag last"></a>
            </div>
            -->
        </div>
    </section>

@endsection