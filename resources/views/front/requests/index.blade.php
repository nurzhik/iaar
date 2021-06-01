@extends('layouts.front')
@section('content')
    <section class="request_section">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/{{$lang}}">{{__('main.Main')}}</a></li>
                <li><a>{{__('main.Application_Form')}}</a></li>
            </ul>
            <p class="title">{{__('main.Apply')}}</p>
            <div class="reestr_block">
                <div class="request_block">
                    <div class="req_number">1</div>
                    <div class="req_name">
                        <span>{{__('main.Download_Application_Form')}}</span>
                        <!-- <p>Выберите вид организации образования, чтобы скачать предназначенный ей форму заявки.</p> -->
                    </div>
                    <div class="sel_block">
                        <div class="sel_block__top">
                            <label class="label" for="">{{__('main.Type_Organization')}}</label>
                            <div class="help">
                                <div class="help__part">
                                    <!-- <div class="help_text">
                                        Выберите вид организации, к которому относится ваше учебное заведение
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <script>
                            $(document).ready(function(){
                                $('.sel_opt').on('click',function(){
                                   $('#download_button').attr('href',$(this).data('filelink'));
                                });
                            });
                        </script>
                        <div class="reestr_select">
                            <p data-attr="0" class="sel_title second_sel">{{__('main.Type_Organization')}}</p>
                            <ul class="options">
                                @foreach(\App\Models\Univer::availableTypeIdArray($lang) as $key=>$value)
                                    <li><a data-attr="vid_{{$value + 1}}" data-filelink="{{\App\Models\AccrRequestForm::where('type_id',$value)->first()->getLocaleNode($lang)->file}}" class="sel_opt" href="javascript:;">{{$key}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <a class="re_search_submit download_btn" download id="download_button" href="javascript:;">{{__('main.Download')}}</a>
                    </div>
                </div>
                <div class="request_block">
                    <div class="req_number">2.</div>
                    <div class="req_name">
                        <span>{{__('main.Fill_Data_and_Apply_Form')}}</span>                       
                    </div>
                    <form enctype="multipart/form-data" action="/postRequestForm" method="POST" class="sel_block">
                        {{csrf_field()}}
                        <input type="hidden" value="{{$lang}}" name="lang">
                        <label class="label" for="">{{__('main.Full_Name')}}</label>
                        <input type="text"  required="required" name="name" placeholder="{{__('main.Enter_Full_Name')}}">
                        <label class="label" for="">{{__('main.Email')}}</label>
                        <input type="email" required="required" name="email" placeholder="{{__('main.Enter_Your_Email')}}">
                        <label class="label" for="">{{__('main.Message')}}</label>
                        <textarea name="message" id="" cols="30" rows="6"></textarea>

                        <label for="file_input" class="file_label"><span>{{__('main.Attach_Application_Form')}}</span></label>
                        <input type="file" name="file_at" id="file_input" style="display: none;">
                        <button type="submit" class="re_search_submit">{{__('main.Send')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection