@extends('layouts.front')
@section('content')
    <section class="video">
        <div class="container">
            <div class="video_top">
                <div class="video_title">
                    <ul class="breadcrumbs">
                        <li><a href="/{{$lang}}">{{__('main.Main')}}</a></li>
                        <li><a>{{__('main.Videoachive')}}</a></li>
                    </ul>
                    <p class="title">{{__('main.Videoachive')}}</p>
                </div>
                <div class="channel_slider">
                    <div>
                        <div class="channel" style="background-image: url('{{asset('front/img/habar.png')}}');"></div>
                    </div>
                    <div>
                        <div class="channel" style="background-image: url('{{asset('front/img/31_channel.png')}}');"></div>
                    </div>
                    <div>
                        <div class="channel" style="background-image: url('{{asset('front/img/kaz.png')}}');"></div>
                    </div>
                    <div>
                        <div class="channel" style="background-image: url('{{asset('front/img/ktk.png')}}');"></div>
                    </div>
                    <div>
                        <div class="channel" style="background-image: url('{{asset('front/img/24_habar.png')}}');"></div>
                    </div>
                    <div>
                        <div class="channel" style="background-image: url('{{asset('front/img/qaz.png')}}');"></div>
                    </div>
                </div>
            </div>
            <div class="video_block">
                @foreach($documents as $document)
                <div class="video_item way">
                    <div class="video_frame">
                        <iframe width="560" height="315" src="{{$document->getLocaleNode($lang)->file}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <div class="video_text">
                        <span class="video_date">{{date('d.m.Y',strtotime($document->show_date))}}</span>
                        <p class="sidebar_title video_name">{{$document->getLocaleNode($lang)->title}}</p>
                    </div>
                </div>
                @endforeach
            </div>
            {{ $documents->appends([])->links('vendor.pagination.front')
            }}
        </div>
    </section>

@endsection