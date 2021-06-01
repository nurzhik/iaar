@extends('layouts.front')
@section('content')
<section class="rating">
    <div class="container">
        <ul class="breadcrumbs">
            <li><a href="index.html">Главная</a></li>
            <li><a>Рейтинг</a></li>
        </ul>
        <p class="title">Рейтинг</p>
        <div class="top_rating">
            <div class="rating_img"></div>
            <p class="rating_text">Независимое Агентство аккредитации и рейтинга сообщает о том, что опубликован Национальный рейтинг востребованности вузов РК по направлениям и уровням подготовки специалистов 2019 года. Результаты ранжирования представлены в газете "Казахстанская правда" № 90 (28967) от 15.05.2019года.</p>
        </div>
        <div class="reestr_block">
            <div class="re_line"></div>
            <div class="rating_select">
                <div class="sel_block">
                    <label class="label" for="">Страна <a href="javascript:;" class="help">
                            <div class="help_text">
                                Выберите страну, в которой находится ваше учебное заведение
                            </div>
                        </a></label>
                    <div class="reestr_select">
                        <p data-attr="0" class="sel_title first_sel">Выберите страну</p>
                        <ul class="options">
                            <li><a data-attr="kz" class="sel_opt" href="javascript:;">Казахстан</a></li>
                            <li><a data-attr="ru" class="sel_opt" href="javascript:;">Россия</a></li>
                            <li><a data-attr="kr" class="sel_opt" href="javascript:;">Кыргызстан</a></li>
                            <li><a data-attr="uz" class="sel_opt" href="javascript:;">Узбекистан</a></li>
                        </ul>
                    </div>
                </div>
                <div class="sel_block">
                    <label class="label" for="">Вид организации образования <a href="javascript:;" class="help">
                            <div class="help_text">
                                Выберите вид организации, к которому относится ваше учебное заведение
                            </div>
                        </a></label>
                    <div class="reestr_select">
                        <p data-attr="0" class="sel_title second_sel">Вид организации образования</p>
                        <ul class="options">
                            <li><a data-attr="vid_1" class="sel_opt" href="javascript:;">Организации высшего и послевузовского образования</a></li>
                            <li><a data-attr="vid_2" class="sel_opt" href="javascript:;">Медицинские организации высшего и послевузовского образования</a></li>
                            <li><a data-attr="vid_3" class="sel_opt" href="javascript:;">Организации ТиПО</a></li>
                            <li><a data-attr="vid_4" class="sel_opt" href="javascript:;">Медицинские организации ТиПО</a></li>
                            <li><a data-attr="vid_5" class="sel_opt" href="javascript:;">Организации среднего образования (международные школы)</a></li>
                            <li><a data-attr="vid_6" class="sel_opt" href="javascript:;">Организации дополнительного образования</a></li>
                            <li><a data-attr="vid_7" class="sel_opt" href="javascript:;">НИИ</a></li>
                        </ul>
                    </div>
                </div>
                <div class="sel_block">
                    <label class="label" for="">Год <a href="javascript:;" class="help">
                            <div class="help_text">
                                Выберите год аккредитации
                            </div>
                        </a></label>
                    <div class="reestr_select">
                        <p data-attr="0" class="sel_title last_sel">Год</p>
                        <ul class="options">
                            <li><a data-attr="2012" class="sel_opt" href="javascript:;">2012</a></li>
                            <li><a data-attr="2013" class="sel_opt" href="javascript:;">2013</a></li>
                            <li><a data-attr="2014" class="sel_opt" href="javascript:;">2014</a></li>
                            <li><a data-attr="2015" class="sel_opt" href="javascript:;">2015</a></li>
                            <li><a data-attr="2016" class="sel_opt" href="javascript:;">2016</a></li>
                            <li><a data-attr="2017" class="sel_opt" href="javascript:;">2017</a></li>
                            <li><a data-attr="2018" class="sel_opt" href="javascript:;">2018</a></li>
                            <li><a data-attr="2019" class="sel_opt" href="javascript:;">2019</a></li>
                        </ul>
                    </div>
                </div>
                <a href="javascript:;" onclick="sub_rating()" class="re_search_submit">Подтвердить</a>
            </div>
        </div>
    </div>
</section>
<div class="rating_result">
    <div class="container">
        <p class="search_title">Рейтинг <span class="vid_name"></span> за <span class="year_num"></span> год, страна <span class="country_name"></span></p>
        <div class="documents_block rating_docs">
            <ul class="docs_list">
                <li><a href="javascript:;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et </a></li>
                <li><a href="javascript:;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et </a></li>
            </ul>
            <ul class="docs_list">
                <li><a href="javascript:;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et </a></li>
                <li><a href="javascript:;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et </a></li>
            </ul>
        </div>
        <div class="rating_res_block">
            <div class="rating_item" style="background: url('img/rating_item.png') center / cover no-repeat;">
                <div class="bg">
                    <a class="open_report" data-fancybox data-src="#report_1" href="javascript:;">Открыть отчет</a>
                </div>
            </div>
            <div class="rating_item" style="background: url('img/rating_item.png') center / cover no-repeat;">
                <div class="bg">
                    <a class="open_report" data-fancybox data-src="#report_1" href="javascript:;">Открыть отчет</a>
                </div>
            </div>
            <div class="rating_item" style="background: url('img/rating_item.png') center / cover no-repeat;">
                <div class="bg">
                    <a class="open_report" data-fancybox data-src="#report_1" href="javascript:;">Открыть отчет</a>
                </div>
            </div>
            <div class="rating_item" style="background: url('img/rating_item.png') center / cover no-repeat;">
                <div class="bg">
                    <a class="open_report" data-fancybox data-src="#report_1" href="javascript:;">Открыть отчет</a>
                </div>
            </div>
            <div class="rating_item" style="background: url('img/rating_item.png') center / cover no-repeat;">
                <div class="bg">
                    <a class="open_report" data-fancybox data-src="#report_1" href="javascript:;">Открыть отчет</a>
                </div>
            </div>
            <div class="rating_item" style="background: url('img/rating_item.png') center / cover no-repeat;">
                <div class="bg">
                    <a class="open_report" data-fancybox data-src="#report_1" href="javascript:;">Открыть отчет</a>
                </div>
            </div>
            <div class="rating_item" style="background: url('img/rating_item.png') center / cover no-repeat;">
                <div class="bg">
                    <a class="open_report" data-fancybox data-src="#report_1" href="javascript:;">Открыть отчет</a>
                </div>
            </div>
            <div class="rating_item" style="background: url('img/rating_item.png') center / cover no-repeat;">
                <div class="bg">
                    <a class="open_report" data-fancybox data-src="#report_1" href="javascript:;">Открыть отчет</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="report_1" class="report_album">
    <div class="book_page"><img src="img/news_1.png" alt=""></div>
    <div class="book_page"><img src="img/news_2.png" alt=""></div>
    <div class="book_page"><img src="img/news_3.png" alt=""></div>
    <div class="book_page"><img src="img/news_1.png" alt=""></div>
    <div class="book_page"><img src="img/news_3.png" alt=""></div>
</div>
<?php
require "elements/links.html";
require "elements/partners.html";
require "elements/footer.html"
?>
@endsection
<script src="js/jquery-3.0.0.min.js"></script>
<script src="js/slick.min.js"></script>
<script src="js/jquery.fancybox.min.js"></script>
<script src="js/jquery-ui-1.10.4.min.js"></script>
<script src="js/jquery.easing.1.3.js"></script>
<script src="js/jquery.booklet.latest.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>