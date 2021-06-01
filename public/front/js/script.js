$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function(){
     $(document).click(function(event) { 
      if(!$(event.target).closest('.message').length) { 
        if($('.alert').hasClass('alert--active')){
            $('.alert').removeClass('alert--active');
        }
      }  
  });
  $('.my-alert__close').click(function(event) {
      $('.alert').removeClass('alert--active');
  });   
    $('.top_slider').slick({
        autoplay: true,
        arrows: true,
        infinite: true,
        slidesToShow: 1,
        speed: 1000,
        prevArrow: '<button type="button" class="slick_prev"></button>',
        nextArrow: '<button type="button" class="slick_next"></button>'
    });

    $('.priz_slider').slick({
        autoplay: true,
        arrows: true,
        infinite: true,
        slidesToShow: 5,
        slidesToScroll: 2,
        speed: 1000,
        prevArrow: '<button type="button" class="slick_prev"></button>',
        nextArrow: '<button type="button" class="slick_next"></button>',
        responsive: [{
            lang_choicebreakpoint: 1200,
            settings: {
                slidesToShow: 4
            }
        },
            {
                breakpoint: 870,
                settings: {
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 670,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 460,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }]
    });

    $('.partner_slider').slick({
        autoplay: true,
        arrows: true,
        infinite: true,
        slidesToShow: 6,
        slidesToScroll: 2,
        speed: 1000,
        prevArrow: '<button type="button" class="slick_prev"></button>',
        nextArrow: '<button type="button" class="slick_next"></button>',
        responsive: [{
            breakpoint: 1200,
            settings: {
                slidesToShow: 5
            }
        },
            {
                breakpoint: 870,
                settings: {
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 670,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 460,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }]
    });

    $('.page_news_slider').slick({
        autoplay: true,
        arrows: true,
        infinite: true,
        slidesToShow: 1,
        speed: 1000,
        prevArrow: '<button type="button" class="slick_prev"></button>',
        nextArrow: '<button type="button" class="slick_next"></button>'
    });

    $('.channel_slider').slick({
        autoplay: true,
        arrows: true,
        infinite: true,
        slidesToShow: 5,
        slidesToScroll: 2,
        speed: 1000,
        prevArrow: '<button type="button" class="slick_prev slick_arrow"></button>',
        nextArrow: '<button type="button" class="slick_next slick_arrow"></button>',
        responsive: [{
          breakpoint: 1200,
          settings: {
            slidesToShow: 4
          }
        },
        {
          breakpoint: 870,
          settings: {
            slidesToShow: 3
          }
        },
        {
          breakpoint: 670,
          settings: {
            slidesToShow: 2
          }
        },
        {
          breakpoint: 460,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }]
      });

  $('.way').waypoint({
      handler: function() {
      $(this.element).addClass("way--active")
      },
      offset: '100%'
   });
   $('.expert-button').on('click', function() {
        $(this).toggleClass('expert-button--active');
        $('.zayavka-block').toggleClass('zayavka-block--active');
   });
    // my js


    // смена табов
    // createTabs();
    // function createTabs(){
    //     $('.tab-part .tab-ul a').on('click', function(e)  {
    //         var currentAttrValue = $(this).attr('href');
    //         $('.tab-part ' + currentAttrValue).fadeIn(150).show().siblings().hide();
    //         $(this).parent('li').addClass('active').siblings().removeClass('active');
    //         e.preventDefault();
    //     });
    // }

    (function($) {
$(function() {

    function createCookie(name,value,days) {
        if (days) {
            var date = new Date();
            date.setTime(date.getTime()+(days*24*60*60*1000));
            var expires = "; expires="+date.toGMTString();
        }
        else var expires = "";
        document.cookie = name+"="+value+expires+"; path=/";
    }
    function readCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    }
    function eraseCookie(name) {
        createCookie(name,"",-1);
    }

    $('.tab-ul').each(function(i) {
        var cookie = readCookie('tabCookie');
        console.log(cookie);
        if (cookie) {
            $(this).find('li').removeClass('active').eq(cookie).addClass('active')
                $('div.tab-content').find('div.tab-content__item').removeClass('active').eq(cookie).addClass('active');
        }
    });

    $('.tab-ul').on('click', 'li:not(.active)', function() {
        $(this)
            .addClass('active').siblings().removeClass('active');
            $('.tab-areas').find('.tab-content__item').removeClass('active').eq($(this).index()).addClass('active');
        var ulIndex = $('.tab-ul li.active').index();        
        eraseCookie('tabCookie');
        createCookie('tabCookie', $(this).index(), 365);
    });

});
})(jQuery);


    $('.vek-top').on('click', function(e)  {
        if($(this).parent().hasClass('active')){
            $(this).parent().removeClass('active');
        }
        else{
            $('.vek-item').removeClass('active');
            $(this).parent().addClass('active');
        }
    });
    $('.pdf-item__name').on('click', function(e)  {
        if($(this).parent().hasClass('active')){
            $(this).parent().removeClass('active');
        }
        else{
            $('.pdf-item').removeClass('active');
            $(this).parent().addClass('active');
        }
    });
    

    // Реесстр

    // проврерка аккредитации
    $('.options li a').on('click', function(e)  {
        if($(this).attr('data-attr') == "inst"){
            $('.re_search').attr("placeholder", "Названия организации образования");
            $('.inst').show();
            $('.spec').hide();
        }
        else{
            $('.re_search').attr("placeholder", "Названия специализированной программы");
            $('.spec').show();
            $('.inst').hide();
        }
    });
    $('.country-sel li a').on('click', function(e)  {
        if($(this).hasClass('active')){}                   
        else{
            var backgroundImage = $(this).css('background-image');
            $('.reestr_country .sel_title').css('background-image', backgroundImage);
            console.log(backgroundImage);
        }
    });

    // cмотреть другие вузы
    $('.btn--accred').on('click', function(){
        if($(this).hasClass('active')){
            $(this).removeClass('active');
            $(this).parent().next('.accred-infoblock').removeClass('active');
        }
        else{
            $(this).addClass('active');
            $(this).parent().next('.accred-infoblock').addClass('active');
        }
    });

    // образовательные программы данного вуза
    $('.program__title').on("click", function(){
        $(this).toggleClass('active');
        $('.program__info').toggleClass('active');
    });


    $('.choice_bottom').hide();
    $('.other_lang,  .direction').hide();

    if($(document).width() <= 870){
        if($('.page_nav_title').css('display') == 'block'){
            $('.page_nav').appendTo('.page_nav_title').hide();
        } else{
            $('.page_nav').prependTo('.page_sidebar').show();
        }
    }

    // после перезагрузки ищет выбранные варианты и ставит их значение
    var opt = $('.sel_block .options');
    for(i=0; i<opt.length; i++){
        var opt_val = $(opt[i]).children().children('.sel_opt');
        for(j=0; j<opt_val.length; j++){
            if($(opt_val[j]).hasClass('active')){
                var attr_val = $(opt_val[j]).attr('data-attr');
                var attr_text = $(opt_val[j]).text();
                var attr_flag = $(opt_val[j]).attr('style');
                $(opt_val[j]).removeClass('active');
                var attr_cls = $(opt_val[j]).attr('class').slice(8);
                $(opt_val[j]).addClass('active');
                $(opt[i]).siblings('.sel_title').text(attr_text).attr('data-attr', attr_val).attr('style', attr_flag).addClass(attr_cls);
            }
        }
    }

    if( $('.container').width() < 500 ){
        $('.choice_block').prependTo('.under_nav');
        $('.choice_block').show();
    } else{
        $('.under_nav .choice_block').appendTo('.header_top .container');
    }


});


$(window).resize(function(){
    if($('.page_nav_title').css('display') == 'block'){
        $('.page_nav').appendTo('.page_nav_title').hide();
    } else{
        $('.page_nav').prependTo('.page_sidebar').show();
    }

    if($('.under_nav .nav').css("display") == "block" && $('.container').width() >= 1140){
        $('.under_nav .nav').prependTo('.header_bottom .container');
        $('.under_nav').removeClass('active');
    }

    if( $('.container').width() < 500 ){
        $('.choice_block').prependTo('.under_nav');
        $('.choice_block').show();
    } else{
        $('.under_nav .choice_block').appendTo('.header_top .container');
    }
});


// Растущий график на странице Отчеты НААР
$(window).on("load", function(){
    var item = $('.grafik_item');
    for(i=0; i<item.length; i++){
        item[i].style.height = $(item[i]).attr('data-attr') + "px";
    }
});



// Запрет на сохранения картинки в Рейтинге
var img = $('img');
for(var i in img){
    img[i].oncontextmenu = function(){
        return false;
    }
}

var txt = $('.nav_item.active').text();
if( txt == '' ){
    txt = $('.breadcrumbs li:last-child').children('a').text();
}
$('.page_nav_title p').text(txt);







// Mobile Menu BTN click

function mobile_menu(){
    $('.nav').appendTo('.under_nav');
    $('.nav').show();
    $('.under_nav').addClass('active');
}

$('.page_nav_title').on("click", function(){
    $(this).children('.page_nav').slideToggle();
    $(this).children('p').toggleClass('active');
});


// Resultat script

var info;
var v_name;
window.onload = function (){
    v_name = $('.vyz_name');
    info = $('.vyz_info');
}

$('#res_id, #otchet_id, #akkr_tab').on('click', function(event){
    var target = event.target;
    if(!$(target).hasClass('active') && $(target).hasClass('vyz_name')){ // закрытие всех остальных вкладок
        $('.vyz_name').removeClass('active');
        $('.vyz_info').slideUp();
    }

    if (target.className == 'vyz_name'){
        for(var i=0; i<v_name.length; i++){
            if (target == v_name[i]){
                v_name[i].classList.add('active');
                showTabsContent(i);
                break;
            }
        }
    } else {for(var i=0; i<v_name.length; i++){// закрытие открытой вкладки при повторном нажатии
        if (target == v_name[i]){
            v_name[i].classList.remove('active');
            hideTabsContent(i);
            break;
        }
    }
    }
});

function hideTabsContent(a){ // изменения стилей для закрытия таба
    $('.vyz_info').eq(a).slideUp();
}

function showTabsContent(b){  // изменения стилей для открытия таба
    $('.vyz_info').eq(b).slideDown();
}

// смена языков
function lang_choice(){
    $('.other_lang').slideToggle();
}
$('.lang__heading').on("click", function(){
    $('.lang').addClass('lang--active');
});
$(document).click(function(event) {
    if(!$(event.target).closest('.lang').length) {
        if($('.lang').hasClass('lang--active')){
            $('.lang').removeClass('lang--active');
            $('.other_lang').hide();
        }
    }
});



// Select Script

$('.reestr_select .sel_title').on("click", function(){
    if($(this).siblings('.options').hasClass('active')){
        $(this).siblings('.options').slideUp().removeClass('active');
    } else{
        $('.options').slideUp().removeClass('active');
        $(this).siblings('.options').slideDown().addClass('active');
    }
});

$('.options').on("click", function(event){
    var target = event.target;
    var txt, val, cls;

    if ($(target).hasClass('sel_opt')){
        txt = $(target).text();
        $(this).children().children('.sel_opt').removeClass('active');
        cls = $(target).attr('class').slice(8); // класс флага страны (flag_kz, flag_ru)
        $(target).addClass('active');
        val = $(target).attr('data-attr');
    }

    $(this).siblings('.sel_title').removeClass('flag flag_kz flag_kr flag_uz flag_ru'); // удаление предыдущих флагов с селекта

    $(this).siblings('.sel_title').text(txt).addClass(cls);
    $(this).siblings('.sel_title').attr('data-attr', val);
    $(this).slideUp().removeClass('active');

});



// Check-Box

$('.check_box').on("click", function(){
    var chkd = $(this).children("input").attr("id");
    if($("#" + chkd).prop('checked') ){
        $(this).children('.check_img').removeClass('active');
        $("#" + chkd).removeAttr("checked");
        $("#"+chkd).trigger('change');
    } else{
        $(this).children('.check_img').addClass('active');
        $("#" + chkd).attr("checked", "checked");
        $("#"+chkd).trigger('change');
    }
});

// Filter

$('.dop_filter').on("click", function(){
    $('.choice_bottom').slideToggle();
    $('.arrow').toggleClass('active');
});




// Akkreditation and Rating choice

var submit = false; // для кнопки Подтвердить на Рейтинге
var r_name_1; // для названия страны
var r_name_2; // для названия организации
var r_name_3; // для года

$('.akkr_section, .reestr_block').on("click", function(){
    var atr_1 = $('.first_sel').attr('data-attr');
    var atr_2 = $('.second_sel').attr('data-attr');
    var akkr_check = $('.akkr_check .check_img.active'); // количество выбранных чек-боксов на Аккредитации
    var atr_3 = $('.last_sel').attr('data-attr'); // для 3-го селекта на Рейтинге

    // Условия для Аккредитации

    if(atr_1 != 0 && atr_1 != undefined){
        $('.first_sel').addClass("ready");
        $('.second_block').slideDown();
    }
    if(atr_2 != 0 && atr_2 != undefined && akkr_check.length > 0){
        $('.second_sel').addClass("ready");
        $('.last_block').slideDown();
    }

    // Дополнительные условия для Рейтинга
    if(atr_1 != 0 && atr_2 != 0 && atr_3 != 0){
        submit = true;
        r_name_1 = $('.first_sel').text();
        r_name_2 = $('.second_sel').text();
        r_name_3 = $('.last_sel').text();
    }
});

// Замена текта в результате поиска Рейтинга
function kk(){
    if(submit){
        $('.vid_name').text(r_name_2);
        $('.country_name').text(r_name_1);
        $('.year_num').text(r_name_3);
        $('.rating_result').slideDown();
    } else{
        alert("error");
    }
}

// Переход с 1 стр Аккредитации на 2 стр
function go_akkr(a){
    $(location).attr('href', a);
}

// Request Page Input type file
$('.file_label').on("mouseleave", function(){
    var input_val = $('#file_input').val();
    if(input_val != ""){
        input_val = input_val.slice(12);
        $('.file_label span').text(input_val);
    } else{
        $('.file_label span').text("Прикрепить форму заявки");
    }
});


        // Request Page Download Btn 
        
$('.request_block .reestr_select .options').on("click", function(){
    var x = $('.reestr_select .options').children();
    for(i=0; i<=x.length; i++){
        if ($(this).children().eq(i).children('.sel_opt').hasClass('active')){
            $('.sel_block .download_btn').show();
        }
    }
});


// Reestr search Script
var reestr_submit = false;

$('.reestr').on("click", function(){
    var word = $('.re_search').val();
    var sel = []; // Массив селектов
    sel[1] = sel_1 = $('.sel_1').attr('data-attr');
    sel[2] = sel_2 = $('.sel_2').attr('data-attr');
    sel[3] = sel_3 = $('.sel_3').attr('data-attr');
    sel[4] = sel_4 = $('.sel_4').attr('data-attr');
    sel[5] = sel_5 = $('.sel_5').attr('data-attr');
    var check = $('.reestr .check_img.active');
    var dop_filter = $('.dop_filter_block').css("display");
    var summ = 0; // сумма выбранных селектов

    for(i=1; i<=5; i++){ // суммирование всех селектов
        if(sel[i] != 0){
            summ++;
        }
    }

    	// Если выбрана Специализированная, то чек-бокс Первичная акк виден
    // if($('.sel_2').siblings('.options').children().eq(1).children('.sel_opt').hasClass('active')){
    // 	$('.check_block.reestr-check').children().eq(1).addClass('check_box--active');
    // 	console.log("ok");
    // } else{
    // 	// $('.check_block.reestr-check').children().eq(1).removeClass('check_box--active');
    // 	console.log("ne ok");
    // }



    if (dop_filter != 'none'){
        if(word != "" && check.length > 0 && summ == 5){
            reestr_submit = true;
        } else{
            reestr_submit = false;
        }
    } else if(dop_filter == 'none'){
        if(word != "" && sel_1 != 0 && sel_2 != 0 && sel_3 != 0){
            reestr_submit = true;
        } else{
            reestr_submit = false;
        }
    }

});

// function sub_reestr(){
//   if (reestr_submit){
//     $('.second_block').slideDown();
//   } else{
//     alert("error");
//   }
// }

// Baz_Expert

var expert_submit = false;

$('.baz_expert').on("click", function(){
    var selects = $('.baz_expert .reestr_select p');
    var filter = $('.last_choice').css("display");
    var summa = 0;
    var s_1 = $(selects[0]).attr('data-attr');
    var s_2 = $(selects[1]).attr('data-attr');
    var s_3 = $(selects[2]).attr('data-attr');

    for(i=0; i<selects.length; i++){
        if($(selects[i]).attr('data-attr') != 0){
            summa++;
        }
    }

    if(summa == 9 && filter == 'flex'){
        expert_submit = true;
    } else if(filter == 'none' && s_1 !=0 && s_2 != 0 && s_3 != 0){
        expert_submit = true;
    } else{
        expert_submit = false;
    }
});

function expert_sub(){
    if(expert_submit){
        $('.expert_search').slideDown();
    }
}

$('.next_events').hide();

// Event Tabs
$('.event_btn_block').on("click", function(event){
    var target = event.target;
    if($(target).hasClass('event_prev')){
        $('.event_prev').addClass("active");
        $('.event_next').removeClass('active');
        $('.next_events').hide();
        $('.prev_events').show();
    } else if($(target).hasClass('event_next')){
        $('.event_next').addClass("active");
        $('.event_prev').removeClass('active');
        $('.prev_events').hide();
        $('.next_events').show();
    }
});

// Expert Page btn
$('.more_info').on("click", function(){
    var dir;
    if($(this).hasClass('possibly')){
        dir = "_possibly";
    } else if($(this).hasClass('fact')){
        dir = "_fact";
    }
    if($(this).hasClass('active')){
        $(this).removeClass('active').text('Показать все направления');
        $('.direction' + dir).slideUp();
    } else{
        $(this).addClass('active').text('Скрыть');
        $('.direction' + dir).slideDown();
    }

});


// клик на zoom+/zoom- для отображения PDF файла отчетов
$('.open_report, .naar_report_list .sovet_btn').on("click", function(){
    setTimeout(function(){
        $('.report_album .df-ui-btn.df-ui-zoomin.ti-zoom-in').click();
        $('.report_album .df-ui-btn.df-ui-zoomout.ti-zoom-out').click();
    }, 1000);
});

$('.res_item').on("click", function(){
  if($(this).hasClass('active')){
    $(this).removeClass('active').children('.otchet_info').slideUp();
  } else{
    $('.res_item').removeClass('active').children('.otchet_info').slideUp();
    $(this).toggleClass('active').children('.otchet_info').slideToggle();
  }
});

$('.dop_nav_title').on("click", function(){
  $(this).toggleClass('active');
});