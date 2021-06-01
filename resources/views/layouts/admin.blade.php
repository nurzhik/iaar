<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('vue_scripts')
    @include('admin.partials.head')
    @stack('additional_scripts')
    <link href="/assets/css/colorbox.css" rel="stylesheet">
    <script type="text/javascript" src="/assets/js/jquery.colorbox-min.js"></script>
</head>
<body class="cbp-spmenu-push">
<div class="main-content">
    <div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
        <aside class="sidebar-left">
            <nav class="navbar navbar-inverse">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".collapse" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <h1><a class="navbar-brand" href="/admin"><span class="fa fa-area-chart"></span> NAAR<span class="dashboard_text">ПАНЕЛЬ УПРАВЛЕНИЯ</span></a></h1>
                </div>
                <section class="sidebar">
                    <ul class="sidebar-menu {{Auth::user()->name}}-type">
                        <li  class="treeview 
                        @if(stristr(request()->path(),'admin/static') and !stristr(request()->path(),'admin/static/students') and !stristr(request()->path(),'admin/static/forum')) active  @endif">
                            <a href="#">
                                <i class="fa fa-edit"></i> <span>NAAR</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="treeview
                 @if(stristr(request()->path(),'admin/static/about_us/page')) active  @endif
                                @if(stristr(request()->path(),'admin/static/about_us/hidden-page')) active  @endif

                                @if(stristr(request()->path(),'admin/static/about_us/reorder')) active  @endif">
                                    <a href="#">
                                        <i class="fa fa-edit"></i> <span>О нас</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="/admin/static/about_us/hidden-page"><i class="fa fa-angle-right"></i>Скрытая страница</a></li>
                                        <li><a href="/admin/static/about_us/pages"><i class="fa fa-angle-right"></i> Список страниц</a></li>
                                        <li><a href="/admin/static/about_us/reorder"><i class="fa fa-angle-right"></i>Упорядочить меню</a></li>
                                    </ul>
                                </li>
                                <li class="treeview @if(stristr(request()->path(),'admin/naar/structure')) active  @endif
                                @if(stristr(request()->path(),'admin/naar/boards')) active  @endif
                                @if(stristr(request()->path(),'admin/naar/team')) active  @endif
                                @if(stristr(request()->path(),'admin/naar/experts')) active  @endif
                                @if(stristr(request()->path(),'admin/naar/reorder')) active  @endif
                                @if(stristr(request()->path(),'admin/naar/node')) active  @endif">
                                    <a href="#">
                                        <i class="fa fa-edit"></i> <span>Организационная структура</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="/admin/naar/structure"><i class="fa fa-angle-right"></i>Организационная структура</a></li>
                                        <li><a href="/admin/naar/boards"><i class="fa fa-angle-right"></i> Список советов</a></li>
                                        <li><a href="/admin/naar/team"><i class="fa fa-angle-right"></i>Наша команда</a></li>
                                        <li><a href="/admin/naar/experts"><i class="fa fa-angle-right"></i>Эксперты</a></li>
                                        <li><a href="/admin/naar/reorder"><i class="fa fa-angle-right"></i>Упорядочить меню</a></li>
                                    </ul>
                                </li>
                                <li class="treeview
                                @if(stristr(request()->path(),'admin/static/strategy/page')) active  @endif
                                @if(stristr(request()->path(),'admin/static/strategy/hidden-page')) active  @endif
                                @if(stristr(request()->path(),'admin/static/strategy/reorder')) active  @endif">
                                    <a href="#">
                                        <i class="fa fa-edit"></i> <span>Стратегия НААР</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="/admin/static/strategy/hidden-page"><i class="fa fa-angle-right"></i>Скрытая страница</a></li>
                                        <li><a href="/admin/static/strategy/pages"><i class="fa fa-angle-right"></i> Список страниц</a></li>
                                        <li><a href="/admin/static/strategy/reorder"><i class="fa fa-angle-right"></i>Упорядочить меню</a></li>
                                    </ul>
                                </li>
                                <li class="treeview
                     @if(stristr(request()->path(),'admin/static/normative/page')) active  @endif
                                @if(stristr(request()->path(),'admin/static/normative/hidden-page')) active  @endif
                                @if(stristr(request()->path(),'admin/static/normative/reorder')) active  @endif">
                                    <a href="#">
                                        <i class="fa fa-edit"></i> <span>Нормативные документы</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="/admin/static/normative/hidden-page"><i class="fa fa-angle-right"></i>Скрытая страница</a></li>
                                        <li><a href="/admin/static/normative/pages"><i class="fa fa-angle-right"></i> Список страниц</a></li>
                                        <li><a href="/admin/static/normative/reorder"><i class="fa fa-angle-right"></i>Упорядочить меню</a></li>
                                    </ul>
                                </li>
                                <li class="treeview
                 @if(stristr(request()->path(),'admin/static/inner_system/page')) active  @endif
                                @if(stristr(request()->path(),'admin/static/inner_system/hidden-page')) active  @endif
                                @if(stristr(request()->path(),'admin/static/inner_system/reorder')) active  @endif">
                                    <a href="#">
                                        <i class="fa fa-edit"></i> <span>Внутренняя система качества</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="/admin/static/inner_system/hidden-page"><i class="fa fa-angle-right"></i>Скрытая страница</a></li>
                                        <li><a href="/admin/static/inner_system/pages"><i class="fa fa-angle-right"></i> Список страниц</a></li>
                                        <li><a href="/admin/static/inner_system/reorder"><i class="fa fa-angle-right"></i>Упорядочить меню</a></li>
                                    </ul>
                                </li>
                                <li class="treeview
                 @if(stristr(request()->path(),'admin/static/outer_value/page')) active  @endif
                                @if(stristr(request()->path(),'admin/static/outer_value/hidden-page')) active  @endif
                                @if(stristr(request()->path(),'admin/static/outer_value/reorder')) active  @endif">
                                    <a href="#">
                                        <i class="fa fa-edit"></i> <span>Внешняя оценка качества</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="/admin/static/outer_value/hidden-page"><i class="fa fa-angle-right"></i>Скрытая страница</a></li>
                                        <li><a href="/admin/static/outer_value/pages"><i class="fa fa-angle-right"></i> Список страниц</a></li>
                                        <li><a href="/admin/static/outer_value/reorder"><i class="fa fa-angle-right"></i>Упорядочить меню</a></li>
                                    </ul>
                                </li>
                                <li><a href="/admin/static/national_partners/hidden-page"><i class="fa fa-angle-right"></i>Национальные партнеры</a></li>
                                <li class="treeview @if(stristr(request()->path(),'admin/naar/int')) active  @endif">
                                    <a href="#">
                                        <i class="fa fa-edit"></i> <span>Международное сотрудничество</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="/admin/naar/int/intern_cooperation_hidden"><i class="fa fa-angle-right"></i>Скрытая страница</a></li>
                                        <li><a href="/admin/naar/int/intern_networks"><i class="fa fa-angle-right"></i>Международные сети</a></li>
                                        <li><a href="/admin/naar/int/intern_partners"><i class="fa fa-angle-right"></i>Международные партнеры</a></li>
                                        <li><a href="/admin/naar/int/intern_projects"><i class="fa fa-angle-right"></i>Международные проекты</a></li>
                                        <li><a href="/admin/naar/int/intern_events"><i class="fa fa-angle-right"></i>Международные мероприятия и список мероприятий</a></li>
                                    </ul>
                                </li>
                                <li><a href="/admin/naar/experts_callbacks"><i class="fa fa-angle-right"></i>Список заявок экспертов</a></li>
                            </ul>
                        </li>
                        <li @if(stristr(request()->path(),'/experts')) class="active"  @endif >
                            <a href="/admin/experts">
                                <i class="fa fa-apple"></i> <span>База Экспертов</span>
                                <small class="label pull-right label-info"></small>
                            </a>
                        </li>
                        <li @if(stristr(request()->path(),'/univer')) class="active"  @endif >
                            <a href="/admin/univer">
                                <i class="fa fa-mobile"></i> <span>Реестр</span>
                                <small class="label pull-right label-info"></small>
                            </a>
                        </li>
                        <li @if(stristr(request()->path(),'/comps')) class="active"  @endif >
                            <a href="/admin/comps">
                                <i class="fa fa-mobile"></i> <span>Элементы</span>
                                <small class="label pull-right label-info"></small>
                            </a>
                        </li>
                        <li class="treeview
                            @if(stristr(request()->path(),'admin/accreditation')) active  @endif">
                            <a href="#">
                                <i class="fa fa-edit"></i> <span>Аккредитация</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="/admin/accreditation/0"><i class="fa fa-angle-right"></i>Организации высшего и послевузовского образования</a></li>
                                <li><a href="/admin/accreditation/1"><i class="fa fa-angle-right"></i>Медицинские организации высшего и послевузовского образования</a></li>
                                <li><a href="/admin/accreditation/2"><i class="fa fa-angle-right"></i>Организации ТиПО</a></li>
                                <li><a href="/admin/accreditation/3"><i class="fa fa-angle-right"></i>Медицинские организации ТиПО</a></li>
                                <li><a href="/admin/accreditation/4"><i class="fa fa-angle-right"></i>Организации среднего образования (международные школы)</a></li>
                                <li><a href="/admin/accreditation/5"><i class="fa fa-angle-right"></i>Организации дополнительного образования</a></li>
                                <li><a href="/admin/accreditation/6"><i class="fa fa-angle-right"></i>НИИ</a></li>
                            </ul>
                        </li>
                        <li class="treeview
                        @if(stristr(request()->path(),'admin/rating')) active  @endif">
                            <a href="#">
                                <i class="fa fa-edit"></i> <span>Рейтинг</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="/admin/rating/0"><i class="fa fa-angle-right"></i>Организации высшего и послевузовского образования</a></li>
                                <li><a href="/admin/rating/1"><i class="fa fa-angle-right"></i>Рейтинг преподавателей</a></li>
                                <li><a href="/admin/rating/2"><i class="fa fa-angle-right"></i>Организации ТиПО</a></li>
                                <!--
                                <li><a href="/admin/rating/3"><i class="fa fa-angle-right"></i>Медицинские организации ТиПО</a></li>
                                <li><a href="/admin/rating/4"><i class="fa fa-angle-right"></i>Организации среднего образования (международные школы)</a></li>
                                <li><a href="/admin/rating/5"><i class="fa fa-angle-right"></i>Организации дополнительного образования</a></li>
                                <li><a href="/admin/rating/6"><i class="fa fa-angle-right"></i>НИИ</a></li>
                                -->
                                <li><a href="/admin/rating/rating_council"><i class="fa fa-angle-right"></i>Консультационный совет</a></li>
                            </ul>
                        </li>
                        <li class="treeview
                        @if(stristr(request()->path(),'admin/postmonitorings')) active  @endif">
                            <a href="#">
                                <i class="fa fa-edit"></i> <span>Постмониторинг</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="/admin/postmonitorings/8"><i class="fa fa-angle-right"></i>О постаккредитационном мониторинге</a></li>
                                <li><a href="/admin/postmonitorings/4"><i class="fa fa-angle-right"></i>Графики постаккредитационного мониторинга</a></li>
                                <li><a href="/admin/postmonitorings/5"><i class="fa fa-angle-right"></i>Отчеты экспертов НААР по постаккредитационному мониторингу</a></li>
                                <li><a href="/admin/postmonitorings/6"><i class="fa fa-angle-right"></i>Результаты постаккредитационного мониторинга</a></li>
                                <li><a href="/admin/postmonitorings"><i class="fa fa-angle-right"></i>Статичные подразделы </a></li>
                                <li><a href="/admin/postmonitoringfiles"><i class="fa fa-angle-right"></i>Файлы на сайдбаре</a></li>


                                <!--
                                <li><a href="/admin/rating/3"><i class="fa fa-angle-right"></i>Медицинские организации ТиПО</a></li>
                                <li><a href="/admin/rating/4"><i class="fa fa-angle-right"></i>Организации среднего образования (международные школы)</a></li>
                                <li><a href="/admin/rating/5"><i class="fa fa-angle-right"></i>Организации дополнительного образования</a></li>
                                <li><a href="/admin/rating/6"><i class="fa fa-angle-right"></i>НИИ</a></li>
                                -->
                               
                            </ul>
                        </li>
                        <li class="treeview
                              @if(stristr(request()->path(),'admin/reports') and !stristr(request()->path(),'admin/reports/17/edit')) active @endif">
                            <a href="#">
                                <i class="fa fa-edit"></i> <span>Публикации и отчеты</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="/admin/reports/11/edit"><i class="fa fa-angle-right"></i>Ежегодные отчеты НААР</a></li>
                                <li><a href="/admin/reports/12/edit"><i class="fa fa-angle-right"></i>Аналитические отчеты НААР</a></li>
                                <li class="treeview @if(stristr(request()->path(),'admin/reports/journal') or stristr(request()->path(),'admin/reports/13/edit')
                                or stristr(request()->path(),'admin/reports/29/edit')) active  @endif
                                        ">
                                    <a href="#">
                                        <i class="fa fa-edit"></i> <span>Журнал Education QA</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="/admin/reports/29/edit"><i class="fa fa-angle-right"></i>О журнале</a></li>
                                        <li><a href="/admin/reports/journal/journals_council"><i class="fa fa-angle-right"></i>Редакционный совет</a></li>
                                        <li><a href="/admin/reports/journal/journals_order"><i class="fa fa-angle-right"></i>Порядок рецензирования</a></li>
                                        <li><a href="/admin/reports/journal/journals_require"><i class="fa fa-angle-right"></i>Требования к статье</a></li>
                                        <li><a href="/admin/reports/journal/journals_subscription"><i class="fa fa-angle-right"></i>Подписка</a></li>
                                        <li><a href="/admin/reports/13/edit"><i class="fa fa-angle-right"></i>Архив журналов</a></li>
                                    </ul>
                                </li>
                                <li><a href="/admin/reports/14/edit"><i class="fa fa-angle-right"></i>Публикации НААР</a></li>
                                <li><a href="/admin/reports/15/edit"><i class="fa fa-angle-right"></i>Видеоархив</a></li>
                                <li><a href="/admin/reports/16/edit"><i class="fa fa-angle-right"></i>СМИ о нас</a></li>
                            </ul>
                        </li>
                        <li class="treeview
            @if(stristr(request()->path(),'admin/requests')) active @endif">
                            <a href="#">
                                <i class="fa fa-edit"></i> <span>Заявки на аккредитацию</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="/admin/requests/forms"><i class="fa fa-angle-right"></i>Формы заявок</a></li>
                                <li><a href="/admin/requests/"><i class="fa fa-angle-right"></i>Список заявок</a></li>
                            </ul>
                        </li>
                        <li class="treeview
                        @if(stristr(request()->path(),'admin/postmonitoring')) active @endif
                        @if(stristr(request()->path(),'admin/static/students') or stristr(request()->path(),'admin/static/forum')) active  @endif">
                            <a href="#">
                                <i class="fa fa-edit"></i> <span>Другие разделы</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="treeview
                                @if(stristr(request()->path(),'admin/static/students/page')) active  @endif
                                @if(stristr(request()->path(),'admin/static/students/hidden-page')) active  @endif
                                @if(stristr(request()->path(),'admin/static/students/reorder')) active  @endif">
                                    <a href="#">
                                        <i class="fa fa-edit"></i> <span>Раздел "Студенты"</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="/admin/static/students/hidden-page"><i class="fa fa-angle-right"></i>Скрытая страница</a></li>
                                        <li><a href="/admin/static/students/pages"><i class="fa fa-angle-right"></i> Список страниц</a></li>
                                        <li><a href="/admin/static/students/reorder"><i class="fa fa-angle-right"></i>Упорядочить меню</a></li>
                                    </ul>
                                </li>
                                <li class="treeview
                                @if(stristr(request()->path(),'admin/static/forum/page')) active  @endif
                                @if(stristr(request()->path(),'admin/static/forum/hidden-page')) active  @endif
                                @if(stristr(request()->path(),'admin/static/forum/reorder')) active  @endif">
                                    <a href="#">
                                        <i class="fa fa-edit"></i> <span>Раздел "Форум"</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="/admin/static/forum/hidden-page"><i class="fa fa-angle-right"></i>Скрытая страница</a></li>
                                        <li><a href="/admin/static/forum/pages"><i class="fa fa-angle-right"></i> Список страниц</a></li>
                                        <li><a href="/admin/static/forum/reorder"><i class="fa fa-angle-right"></i>Упорядочить меню</a></li>
                                    </ul>
                                </li>
                               <!--  <li><a href="/admin/postmonitoring"><i class="fa fa-angle-right"></i>Страница постмониторинга</a></li> -->
                            </ul>
                        </li>
                        <li class="treeview
                        @if(stristr(request()->path(),'admin/articles')) active @endif">
                            <a href="#">
                                <i class="fa fa-edit"></i> <span>Новости и события</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="/admin/articles/news"><i class="fa fa-angle-right"></i>Список новостей</a></li>
                                <li><a href="/admin/articles/events"><i class="fa fa-angle-right"></i>Список событий</a></li>
                            </ul>
                        </li>
                        <li class="treeview
                        @if(stristr(request()->path(),'admin/static_text')) active @endif">
                            <a href="#">
                                <i class="fa fa-edit"></i> <span>Статичный контент</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="/admin/static_text/35"><i class="fa fa-angle-right"></i>Текст на странице рейтинга</a></li>
                                <li><a href="/admin/static_text/36"><i class="fa fa-angle-right"></i>Текст на главной странице "О нас"</a></li>
                                <li><a href="/admin/static_text/37"><i class="fa fa-angle-right"></i>Список на странице аккредитаций</a></li>
                            </ul>
                        </li>
                        <li class="treeview
                        @if(stristr(request()->path(),'admin/other') or stristr(request()->path(),'admin/countries')) active @endif">
                            <a href="#">
                                <i class="fa fa-edit"></i> <span>Остальное</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="/admin/countries"><i class="fa fa-angle-right"></i>Список стран</a></li>
                                <li><a href="/admin/other/sliders"><i class="fa fa-angle-right"></i>Слайдер на главной странице</a></li>
                                <li><a href="/admin/other/main_partners"><i class="fa fa-angle-right"></i>Список партнеров</a></li>
                                <li><a href="/admin/other/acceptance_partners"><i class="fa fa-angle-right"></i>Список элементов "Признание"</a></li>
                                <li><a href="/admin/other/contacts"><i class="fa fa-angle-right"></i>Контакты</a></li>
                            </ul>
                        </li>
                    </ul>
                </section>
            </nav>
        </aside>
    </div>
    <div class="sticky-header header-section ">
        <div id="headerMenu" class="header-left">
            <button id="showLeftPush"><i class="fa fa-bars"></i></button>
            <div class="profile_details_left">
                <ul class="nofitications-dropdown">
                    <li class="dropdown head-dpdn">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-usd"></i><span class="badge blue">
                            </span></a>

                    </li>

                </ul>
                <div class="clearfix"> </div>
            </div>
            <div class="clearfix"> </div>
        </div>
        <div class="header-right">
            <div class="profile_details">
                <ul>
                    <li class="dropdown profile_details_drop">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <div class="profile_img">
                                <div class="user-name">
                                    <p>Admin Name</p>
                                    <span>Администратор</span>
                                </div>
                                <i class="fa fa-angle-down lnr"></i>
                                <i class="fa fa-angle-up lnr"></i>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                        <ul class="dropdown-menu drp-mnu">
                            <li> <a href="#"  onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" ><i class="fa fa-sign-out"></i> Выйти</a> </li>
                        </ul>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
            <div class="clearfix"> </div>
        </div>
        <div class="clearfix"> </div>
    </div>
    <div id="page-wrapper">
        @yield('content')
    </div>
</div>
@include('admin.partials.scripts')
<script type="text/javascript" src="/packages/barryvdh/elfinder/js/standalonepopup.js"></script>
<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
<!-- <script>
    $(document).ready(function(){   
        var popin_height = '416'; 
        $('.popup_selector').colorbox({
            inline: true,
            height: popin_height,
            opacity: 0.8,
            overlayClose: true
        });
    });  

</script> -->
</body>
</html>