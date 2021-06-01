@extends('layouts.front')
@section('content')
    <section>
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/{{$lang}}">{{__('main.Main')}}</a></li>
                <li><a>{{__('main.Contacts')}}</a></li>
            </ul>
            <p class="title">{{__('main.Contacts')}}</p>
            <div class="contact_block">
                <div class="left_contact">
                    <ul class="contact_list">
                        <li><span class="sidebar_title">{{__('main.Head_Office')}}</span></li>
                        <li><p><span>{{__('main.Address')}}: </span>{{$item->getLocaleNode($lang)->address}}</li>
                        <li><p><span>{{__('main.Contact_Phone_Numbers')}}: </span> <nobr><a href="tel:{{$item->phone_1}}">{{$item->phone_1}}</a>,</nobr> <nobr><a href="tel:{{$item->phone_2}}">{{$item->phone_2}}</a></nobr></p></li>
                        <li><p><span>{{__('main.Fax')}}: </span> <nobr>{{$item->fax}}</nobr></p></li>
                        <li><p><span>E-mail:</span> <a href="mailto:{{$item->email}}">{{$item->email}}</a></p></li>
                        <li><p><span>{{__('main.Website')}}:</span> <a href="{{$item->site}}" target="_blank">{{$item->site}}</a></p></li>
                    </ul>
                    <div class="soc_btn">
                        <a class="facebook_btn" target="_blank" href="{{$item->fb_link}}"></a>
                        <a class="youtube_btn" target="_blank" href="{{$item->youtube_link}}"></a>
                    </div>
                    {!! $item->getLocaleNode($lang)->content !!} 
                </div>
                <div class="map">
                        {!! $item->map_code !!}
                </div>
            </div>
        </div>
    </section>

@endsection