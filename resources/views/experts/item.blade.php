@extends('layouts.front')
@section('content')
    <section>
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/{{$lang}}">{{__('main.Main')}}</a></li>
                <li><a href="/experts_database">База экспертов</a></li>
                <li><a>{{$item->name}}</a></li>
            </ul>
            <div class="expert_info">                
                <div class="result_img">
                    <div class="result_img__photo" style="background-image: url('{{$item->photo}}');"></div>
                </div>
                <p class="expert_name">{{$item->name}}</p>
                <div class="info_block">
                    <div><p class="info_title">№ сертификата: </p><p>{{$item->certificate_number}}</p></div>
                    <div><p class="info_title">Дата выдачи сертификата: </p><p>{{date('d.m.Y',strtotime($item->certificate_date))}}</p></div>
                    <div><p class="info_title">Место работы:</p><p>{{$item->place_of_work}}</p></div>
                    <div><p class="info_title">{{__('main.Position')}}:</p><p>{{$item->position}}</p></div>
                    <div><p class="info_title">Категория, академическая степень, ученая степень, ученое звание:</p><p>{{$item->academic_degrees}}</p></div>
                    <div><p class="info_title">Контактная информация:</p>
                            {{$item->contacts}}
                    </div>
                </div>
                @if($item->possibleDirections()->count()>0)
                <div class="info_block">
                    @foreach($item->possibleDirections()->get()->take(1) as $possible_dir)
                    <div><p class="info_title title">Возможные направления:</p></div>
                    @if(!$possible_dir->direction_id == 618)
                        @if(isset($possible_dir->direction_id))
                            <div><p class="info_title">Направление:</p><p>{{$possible_dir->direction->title}}</p></div>
                        @endif
                    @endif
                    @if(!$possible_dir->direction_id == 408)
                        @if(isset($possible_dir->spec_id))
                            <div><p class="info_title">Специализация:</p><p>{{$possible_dir->spec->title}}</p></div>
                        @endif
                    @endif
                    <div><p class="info_title">{{__('main.Accred_Type')}}:</p><p>{{$possible_dir->accr_type == 0 ? 'Институциональная' : 'Специализированная (програмнная)'}}</p></div>
                    @endforeach
                    @if($item->possibleDirections()->count()>1)
                        <div><a class="more_info possibly" href="javascript:;">Показать все направления</a></div>
                    @endif
                    @foreach($item->possibleDirections()->get()->slice(1) as $possible_dir)
                    <div class="direction direction_possibly">
                        @if(isset($possible_dir->direction_id))
                            <div><p class="info_title">Направление:</p><p>{{$possible_dir->direction->title}}</p></div>
                        @endif
                        @if(isset($possible_dir->spec_id))
                            <div><p class="info_title">Специализация:</p><p>{{$possible_dir->spec->title}}</p></div>
                        @endif
                        <div><p class="info_title">{{__('main.Accred_Type')}}:</p><p>{{$possible_dir->accr_type == 0 ? 'Институциональная' : 'Специализированная (програмнная)'}}</p></div>
                    </div>
                    @endforeach
                </div>
                @endif
                <div class="info_block" style="background: #fff; padding: 0;">
                    <div><p class="info_title">Категория эксперта:</p><p>{{$item->category_number}}</p></div>
                </div>
                @if($item->existDirections()->count()>0)
                <div class="info_block">
                    @foreach($item->existDirections()->get()->take(1) as $exist_dir)
                    <div><p class="info_title title">Фактические направления</p></div>
                    @if(!$exist_dir->direction_id == 618)
                        @if(isset($exist_dir->direction_id))
                            <div><p class="info_title">Направление:</p><p>{{$exist_dir->direction->title}}</p></div>
                        @endif
                      @endif
                    @if(!$exist_dir->spec_id == 408)
                        @if(isset($exist_dir->spec_id))
                            <div><p class="info_title">Специализация:</p><p>{{$exist_dir->spec->title}}</p></div>
                        @endif
                    @endif
                    <div><p class="info_title">Вид аккредитации:</p><p>{{$exist_dir->accr_type == 0 ? 'Институциональная' : 'Специализированная (програмнная)'}}</p></div>
                    <div><p class="info_title">Вид вуза:</p><p>{{array_flip(\App\Models\Univer::availableTypeIdArray())[$exist_dir->organization_type_id]}}</p></div>
                    <div><p class="info_title">Наименование организации обр.:</p><p>{{$exist_dir->organization_title}}</p></div>
                    <div><p class="info_title">Дата визита:</p><p>{{date('d.m.Y',strtotime($exist_dir->date_start))}} - {{date('d.m.Y',strtotime($exist_dir->date_end))}} </p></div>
                    @endforeach
                    @if($item->existDirections()->count()>1)
                        <div><a class="more_info fact" href="javascript:;">Показать все направления</a></div>
                    @endif
                    @foreach($item->existDirections()->get()->slice(1) as $exist_dir)
                    <div class="direction direction_fact">
                        @if(isset($exist_dir->direction_id))
                            <div><p class="info_title">Направление:</p><p>{{$exist_dir->direction->title}}</p></div>
                        @endif
                        @if(isset($exist_dir->spec_id))
                            <div><p class="info_title">Специализация:</p><p>{{$exist_dir->spec->title}}</p></div>
                        @endif
                        <div><p class="info_title">Вид аккредитации:</p><p>{{$exist_dir->accr_type == 0 ? 'Институциональная' : 'Специализированная (програмнная)'}}</p></div>
                        <div><p class="info_title">Вид вуза:</p><p>{{array_flip(\App\Models\Univer::availableTypeIdArray())[$exist_dir->organization_type_id]}}</p></div>
                        <div><p class="info_title">Наименование организации обр.:</p><p>{{$exist_dir->organization_title}}</p></div>
                        <div><p class="info_title">Дата визита:</p><p>{{date('d.m.Y',strtotime($exist_dir->date_start))}} - {{date('d.m.Y',strtotime($exist_dir->date_end))}} </p></div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </section>

@endsection