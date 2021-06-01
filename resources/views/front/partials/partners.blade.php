<section class="partners">
    <div class="container">
        <p class="section-title">{{ __('main.Partners')}}</p>
        <div class="partner_slider">
            @foreach(\App\Models\Partner::where('type_id',0)->orderBy('sort_order')->get() as $partner)
                <div>
                    <a href="/partner/{{$partner->slug}}/{{app()->getLocale() == 'ru' ? '': app()->getLocale()}}" class="partner" style="background: url('{{$partner->logo}}') center / contain no-repeat;"></a>
                </div>
            @endforeach
        </div>
    </div>
</section>