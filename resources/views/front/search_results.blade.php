@extends('layouts.front')
@section('content')
    <section class="news_page">
        <div class="container">
                <ul class="breadcrumbs">
                    <li><a href="/{{$lang}}">{{ __('main.Main')}}</a></li>
                    <li><a>{{ __('main.Search')}}</a></li>
                </ul>
                <p class="title">{{ __('main.Search')}}</p>
                <div class="search_result_block">
                    <form   action="/search/@if(app()->getLocale()!=='ru'){{app()->getLocale()}}@endif" class="search_result_top">
                        {{csrf_field()}}
                        <input class="program_search" type="search" name="search" placeholder="{{ __('main.Search') }}">
                        <button class="vyz_page_btn" style="border:none" type="submit">{{ __('main.Search')}}</button>
                    </form>
                    @if(count($results)>0)
                    <div class="result_list">
                        @foreach($results as $result)
                        <div class="result_list_item">
                            <a href="@if($result->is_event)/event/{{$result->slug}}/{{$lang}}@else{{''}}/news/{{$result->slug}}/{{$lang}}@endif" class="sidebar_title">{{$result->getLocaleNode($lang)->title}}</a>
                            <p class="about_result">{{$result->getLocaleNode($lang)->short_desc}}</p>
                        </div>
                        @endforeach
                    </div>
                    @else
                        <h2 style="font-weight:500;">{{ __('main.Not_Found')}}</h2>
                    @endif
                    {{ $results->appends([
                        'search' => $request->search,
                    ])->links('vendor.pagination.front')
                    }}
                </div>            
        </div>
    </section>
@endsection