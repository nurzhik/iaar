@extends('layouts.front')
@section('content')
    <section class="slide_blocks">
        <div class="container">
            <div class="head_into_container">
                             <div class="slider-part">
                <div class="top_slider">
                    @foreach($sliders as $slider)
                        <div>
                            <a href="{{$slider->getLocaleNode($lang)->link}}" class="slide" style="background: linear-gradient(189.95deg, rgba(0, 0, 0, 0) 44.62%, rgba(0, 0, 0, 0.75) 91.39%),  url('{{$slider->image}}') center / cover no-repeat;">
                                <div class="slide_text">
                                    <span class="slide_title">{{$slider->getLocaleNode($lang)->title}}</span>
                                    <!-- <p class="text">{{$slider->getLocaleNode($lang)->title}}</p> -->
                                    @if(strlen($slider->show_date)) <span class="date">{{date('d.m.Y', strtotime($slider->show_date))}}</span> @endif
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="naar_blocks">
                <div class="naar_blocks_into">

                    <a href="/accreditation/{{$lang}}" class="naar_item">
                    <div class="naar_item__bg"></div>
                    <div class="naar-item__text">
                        <div class="naar_img" style="background-image: url('{{asset('front/img/1.svg')}}');"></div>
                        <div class="naar_text">
                            {{ __('main.Accreditation') }}
                            <span class="naar_link">{{ __('main.More') }}</span>
                        </div>
                    </div>                                       
                </a>
                <a href="/registry/{{$lang}}" class="naar_item">
                    <div class="naar_item__bg"></div>
                    <div class="naar-item__text">
                        <div class="naar_img" style="background-image: url('{{asset('front/img/2.svg')}}');"></div>
                        <div class="naar_text">
                            {{ __('main.Register') }}
                            <span class="naar_link">{{ __('main.More') }}</span>
                        </div>
                    </div>
                </a>
                <a  href="/postmonitorings/postakkreditacionnyj-monitoring/{{$lang}}" class="naar_item">
                    <div class="naar_item__bg"></div>
                    <div class="naar-item__text">
                        <div class="naar_img" style="background-image: url('{{asset('front/img/3.svg')}}');"></div>
                        <div class="naar_text">
                            {{ __('main.Postmonitoring') }}
                            <span class="naar_link">{{ __('main.More') }}</span>
                        </div>
                    </div>
                </a>
                <a href="/iaar/{{\App\Models\StaticPage::where('type_id',4)->first()->slug}}/{{$lang}}" class="naar_item">
                    <div class="naar_item__bg"></div>
                    <div class="naar-item__text">
                        <div class="naar_img" style="background-image: url('{{asset('front/img/4.svg')}}');"></div>
                        <div class="naar_text">
                            {{ __('main.Experts') }}
                            <span class="naar_link">{{ __('main.More') }}</span>
                        </div>
                    </div>
                </a>
                    
                </div>

                <a href="/postmonitorings/1/{{$lang}}" class="naar_out_item"> 
                        <div class="naar_img img_new_item" style="background-image: url('{{asset('front/img/5.png')}}">
    
                        </div>

                        <div class="add_block_to">
                        <div class="naar_text_into">    {{ __('main.IiarEduc') }}
                        </div>
                        <span class="naar_link new_item">{{ __('main.More') }}</span>   
                        </div>
                       
                </a>
            
            </div> 
            </div>
   
       

        </div>
    </section>
    <section class="priznanie">
        <div class="container">
            <p class="section-title">{{ __('main.Priznanie') }}</p>
            <div class="priz_slider">
                @foreach($acceptance as $partner)
                    <div>
                        <a href="/partner/{{$partner->slug}}/{{app()->getLocale() == 'ru' ? '': app()->getLocale()}}" class="priz" style="background: url('{{asset($partner->logo)}}') center / contain no-repeat;"></a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="about_us">
        <div class="container">            
            <div class="about_block">
                @if(strlen($about->main_image))
                    <img src="{{$about->main_image}}" class="rating_img2">
                @else
                <div class="about_video">
                    <iframe width="560" height="315" src="{{$about->getLocaleNode($lang)->seo_title}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                @endif

                <div class="about_text">
                    <span class="about_text__heading">{{$about->getLocaleNode($lang)->title}}</span>
                        {!!  $about->getLocaleNode($lang)->content!!}
                    <a class="about_more" href="{{$about->getLocaleNode($lang)->seo_keywords}}">{{ __('main.More') }}</a>
                </div>                
            </div>
        </div>
    </section>
    <section class="noname">
        <div class="container">
            <div class="noname_block">
                <a href="/iaar/{{\App\Models\StaticPage::where('type_id',19)->first()->slug}}/{{$lang}}" class="noname_item v1" style="background: linear-gradient(88.84deg, rgba(0, 0, 0, 0.5) 0.42%, rgba(0, 0, 0, 0.5) 0.43%, rgba(0, 0, 0, 0) 48.09%);">
                    <img src="{{asset('front/img/sotrudnik.png')}}" alt="">
                    <span>{{ __('main.Mezh_sotrudnichestvo')}}</span>
                    <div class="item-bg">
                        <span class="noname_icon" style="background-image: url(front/img/mezh_icon.svg);"></span>
                    </div>
                </a>
                <a href="/forum/{{$lang}}" class="noname_item v1" style="background: linear-gradient(88.84deg, rgba(0, 0, 0, 0.5) 0.42%, rgba(0, 0, 0, 0.5) 0.43%, rgba(0, 0, 0, 0) 48.09%);">
                    <img src="{{asset('front/img/forum.png')}}" alt="">
                    <span>{{ __('main.central_forum')}}</span>
                    <div class="item-bg">
                        <span class="noname_icon" style="background-image: url(front/img/forum_icon.svg);"></span>
                    </div>
                </a>
                <a href="/reports/{{\App\Models\StaticPage::where('type_id',29)->first()->slug}}/{{$lang}}" class="noname_item v1" style="background: linear-gradient(97.23deg, #ffffff14 8.65%, rgba(255, 255, 255, 0.08) 55.15%);">
                    <img src="{{asset('front/img/journal.png')}}?v=1.1" alt="">
                    <span style="color: #262626;">{{ __('main.Magazines')}}</span>
                    <div class="item-bg">
                       <span class="noname_icon" style="background-image: url(front/img/journal_icon.svg);"></span>
                    </div>
                </a>
            </div>
        </div>
    </section>
    <section class="news">
        <div class="container">
            <div class="top_news">
                <p class="title">{{ __('main.News') }}</p>
                <a class="all_news" href="/news-all/{{$lang}}">{{ __('main.News_all') }}</a>
            </div>
            <ul class="news-list news-list--main">
                @foreach($news as $article)
                    <li>
	                    <div class="news_item">
	                        <a href="/news/{{$article->slug}}/{{$lang}}" class="news_img">
                                <img src="{{asset($article->main_image)}}">   
                            </a>
	                        <div class="news_text">
	                            <span class="date">  {{date('d.m.Y', strtotime($article->published_at))}}</span>
	                            <a class="news_title" href="/news/{{$article->slug}}/{{$lang}}">{{$article->getLocaleNode($lang)->title}}</a>
	                        </div>
	                    </div>
                	</li>
                @endforeach
            </ul>
        </div>
    </section>
    <section class="partners">
        <div class="container">
            <p class="section-title">{{ __('main.Partners') }}</p>
            <div class="partner_slider">
                @foreach(\App\Models\Partner::where('type_id',0)->orderBy('sort_order')->get() as $partner)
                    <div>
                        <a href="/partner/{{$partner->slug}}/{{app()->getLocale() == 'ru' ? '': app()->getLocale()}}" class="partner" style="background: url('{{$partner->logo}}') center / contain no-repeat;"></a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @include('front.partials.footer')
@endsection