<section class="page_naar">
    <div class="container">
        <div class="page_naar_blocks">
            <a href="/accreditation/{{$lang}}" class="naar_item">
                <div class="naar_item__bg"></div>
                <div class="naar-item__text">
                    <div class="naar_img" style="background-image: url('{{asset('front/img/1.svg')}}');"></div>
                    <div class="naar_text">
                        {{ __('main.Accreditation') }}
                        <span class="naar_link">{{__('main.More')}}</span>
                    </div>
                </div>                                       
            </a>
            <a href="/registry/{{$lang}}"class="naar_item">
                <div class="naar_item__bg"></div>
                <div class="naar-item__text">
                    <div class="naar_img" style="background-image: url('{{asset('front/img/2.svg')}}');"></div>
                    <div class="naar_text">
                        {{__('main.Register')}}
                        <span class="naar_link">{{__('main.More')}}</span>
                    </div>
                </div>
            </a>
            <a href="/postmonitorings/postakkreditacionnyj-monitoring/{{$lang}}" class="naar_item">
                <div class="naar_item__bg"></div>
                <div class="naar-item__text">
                    <div class="naar_img" style="background-image: url('{{asset('front/img/3.svg')}}');"></div>
                    <div class="naar_text">
                        {{__('main.Postmonitoring')}}
                        <span class="naar_link" href="#">{{__('main.More')}}</span>
                    </div>
                </div>
            </a>
            <a href="/iaar/{{\App\Models\StaticPage::where('type_id',4)->first()->slug}}/{{$lang}}" class="naar_item">
                <div class="naar_item__bg"></div>
                <div class="naar-item__text">
                    <div class="naar_img" style="background-image: url('{{asset('front/img/4.svg')}}');"></div>
                    <div class="naar_text">
                        {{__('main.Experts')}}
                        <span class="naar_link">{{__('main.More')}}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>