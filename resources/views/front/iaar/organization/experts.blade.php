@extends('layouts.front')
@section('content')
    <script type="text/javascript">

        $(document).ready(function() {
            $(".btn-success").click(function(){
                var htm='                        <div class="clone hide">\n' +
                    '                            <div class="hdtuto control-group lst input-group" style="margin-top:10px">\n' +
                    '                                <input type="file" name="documents[]" class="myfrm form-control">\n' +
                    '                                <div class="input-group-btn">\n' +
                    '                                    <button class="btn btn-danger" type="button"><i class="fldemo glyphicon glyphicon-remove"></i>{{__('main.experts_callback.delete_file')}}</button>\n' +
                    '                                </div>\n' +
                    '                            </div>\n' +
                    '                        </div>';
                $(".increment").append(htm);
            });
            $(".page").on("click",".btn-danger",function(){
                $(this).parent().parent().remove();
            });
        });
    </script>
    <div class="page">
        <div class="container">
            <div class="page_sidebar">
                <ul class="page_nav">
                    @foreach(\App\Models\StaticPage::where('type_id',2)->orderBy('sort_order')->get() as $page)
                        <li><a class="nav_item" href="/iaar/{{$page->slug}}/{{$lang}}">{{$page->getLocaleNode($lang)->title}}</a></li>
                    @endforeach
                    <li><a class="nav_item active" href="/iaar/{{\App\Models\StaticPage::where('type_id',4)->first()->slug}}/{{$lang}}">{{__('main.Experts')}}</a></li>
                    <li><a class="nav_item" href="/iaar/{{\App\Models\StaticPage::where('type_id',3)->first()->slug}}/{{$lang}}">{{__('main.Our_team')}}</a></li>
                </ul>
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
                <div class="page_news">
                    <p class="sidebar_title">{{__('main.News')}}</p>
                    <div class="page_news_slider">
                        @foreach($news as $article)
                            <div class="news_item">
                                <a href="/news/{{$article->slug}}/{{$lang}}" class="news_img" style="background: url('{{asset($article->main_image)}}') center / cover no-repeat;"></a>
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
            <div class="expert">
                <ul class="breadcrumbs">
                    <li><a href="/{{$lang}}">{{__('main.Main')}}</a></li>
                    <li><a>{{$item->getLocaleNode($lang)->title}}</a></li>
                </ul>
                <div class="page_nav_title"><p></p></div>
                <p class="page-title">{{$item->getLocaleNode($lang)->title}}</p>
                <div class="static-info">
                <!-- @if(strlen($item->main_image)>2)
                    <img class="static-info__img" src="{{$item->main_image}}">
                        @endif -->

                    @if (session('error') or count($errors))
                        <div class="alert is-relative alert-error">
                            {{ session('error') }}
                            @foreach($errors->all() as $message)
                                {{$message}}
                            @endforeach

                        </div>
                    @endif
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    {!!  $item->getLocaleNode($lang)->content !!}

                    <div class="expert-button">{{__('main.experts_callback.title')}}</div>
                    <form action="/create-experts-callback" method="post" enctype="multipart/form-data" class="zayavka-block"><span class="zayavka-block__heading"> {{__('main.experts_callback.hint')}}</span>
                        {{csrf_field()}}
                        <ul class="exzayavka-ul">
                            <input type="hidden" value="{{$lang}}" name="lang">
                            <li>
                                <div class="form-row"><label class="form-row__heading">{{__('main.experts_callback.name')}}</label> <input required="required" class="form-row__input" name="name" type="text" /></div>
                            </li>
                            <li>
                                <div class="form-row"><label class="form-row__heading">{{__('main.experts_callback.surname')}}</label> <input required="required"  class="form-row__input" name="surname" type="text" /></div>
                            </li>
                            <li>
                                <div class="form-row"><label class="form-row__heading">{{__('main.experts_callback.third_name')}}</label> <input class="form-row__input" name="third_name" type="text" /></div>
                            </li>
                            <li>
                                <div class="form-row"><label class="form-row__heading">{{__('main.experts_callback.birth_date')}}</label> <input class="form-row__input" required="required" name="birth_date" type="date" /></div>
                            </li>
                            <li>
                                <div class="form-row"><label class="form-row__heading">{{__('main.experts_callback.address')}}</label> <input class="form-row__input" name="address" type="text" /></div>
                            </li>
                            <li>
                                <div class="form-row"><label class="form-row__heading">{{__('main.experts_callback.languages')}} </label> <input class="form-row__input" name="langs" type="text" /></div>
                            </li>
                            <li>
                                <div class="form-row"><label class="form-row__heading">{{__('main.experts_callback.level_of_knowing')}}</label> <input class="form-row__input" name="level_of_knowing" type="text" /></div>
                            </li>
                            <li>
                                <div class="form-row"><label class="form-row__heading">{{__('main.experts_callback.science_degree')}}</label> <input class="form-row__input" name="science_degree" type="text" /></div>
                            </li>
                            <li>
                                <div class="form-row"><label class="form-row__heading">{{__('main.experts_callback.science_rank')}}</label> <input class="form-row__input" name="science_rank" type="text" /></div>
                            </li>
                            <li>
                                <div class="form-row"><label class="form-row__heading">{{__('main.experts_callback.phone')}}</label> <input class="form-row__input"  required="required" name="phone" type="text" /></div>
                            </li>
                            <li>
                                <div class="form-row"><label class="form-row__heading">{{__('main.experts_callback.fax')}}</label> <input class="form-row__input" name="fax" type="text" /></div>
                            </li>
                            <li>
                                <div class="form-row"><label class="form-row__heading">E-mail</label> <input class="form-row__input"  required="required" name="email" type="email" /></div>
                            </li>
                            <li>
                                <div class="form-row"><label class="form-row__heading">{{__('main.experts_callback.work_place')}}</label> <input class="form-row__input" name="work_place" type="text" /></div>
                            </li>
                            <li>
                                <div class="form-row"><label class="form-row__heading">{{__('main.experts_callback.job')}}</label> <input class="form-row__input" name="job" type="text" /></div>
                            </li>
                            <li>
                                <div class="form-row"><label class="form-row__heading">{{__('main.experts_callback.teaching_experience')}}</label> <input class="form-row__input" name="teaching_experience" type="text" /></div>
                            </li>
                            <li>
                                <div class="form-row"><label class="form-row__heading">{{__('main.experts_callback.rewards')}} </label> <input class="form-row__input" name="rewards" type="text" /></div>
                            </li>
                            <li>
                                <div class="form-row"><label class="form-row__heading">{{__('main.experts_callback.science_sphere')}}</label> <input class="form-row__input"  name="science_sphere" type="text" /></div>
                            </li>
                            <li>
                                <div class="form-row"><label class="form-row__heading">{{__('main.experts_callback.expert_spheres')}}</label> <input name="expert_spheres" class="form-row__input" type="text" /></div>
                            </li>
                        </ul>
                        <div class="input-group hdtuto control-group lst increment" >
                            <input type="file" name="documents[]" class="myfrm form-control">
                            <div class="input-group-btn">
                                <button class="btn btn-success" type="button"><i class="fldemo glyphicon glyphicon-plus"></i>{{__('main.experts_callback.add_file')}}</button>
                            </div>
                        </div>
                        <div class="clone hide">
                            <div class="hdtuto control-group lst input-group" style="margin-top:10px">
                                <input type="file" name="documents[]" class="myfrm form-control">
                                <div class="input-group-btn">
                                    <button class="btn btn-danger" type="button"><i class="fldemo glyphicon glyphicon-remove"></i>{{__('main.experts_callback.delete_file')}}</button>
                                </div>
                            </div>
                        </div>
                        <div class="zayavka-block__send">
                            <button type="submit">{{__('main.experts_callback.send_request')}}</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
@endsection
