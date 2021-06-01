<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

Route::get('/config-cache',function()
{
    $exitCode = Artisan::call('clear-compiled');
    //$exitCode = symlink('/var/www/vhosts/v-4333.webspace/iaar.agency/storage/app/public', '/var/www/vhosts/v-4333.webspace/iaar.agency/public/storage');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    //Artisan::call('dump-autoload');
    Artisan::call('optimize');

//	Artisan::call('storage:link');
    return $exitCode;
});

Route::group(["namespace" => "Admin","prefix" => "admin","middleware" => "admin"], function () {

    Route::get('/',function(){
        return redirect()->to('/admin/naar/structure');
    });
    Route::get('/migrate',function()
    {
        $exitCode = Artisan::call('migrate');
        return $exitCode;
    });
    Route::get('/composer-update',function(){
        shell_exec('composer update');
        return 1;
    });
    Route::get('test-rename','Registry\Deqar\RenameFilesController@testRenameProgram');

    Route::group(["namespace" => "StaticText","prefix" => "static_text"], function () {
        Route::get('/{type}','StaticTextController@getPage')->name('edit_static_text');
        Route::post('/{type}','StaticTextController@postPage');

        Route::group(["prefix" => "nodes"], function () {
            Route::get('/{type}/{lang}','StaticTextNodesController@getPage')->name('edit_static_text_node');
            Route::post('/{type}/{lang}','StaticTextNodesController@postPage');
        });
    });

    Route::group(["namespace" => "Log","prefix" => "log"], function () {
        Route::get('/registry-update','RegistryUpdateLogController@index')->name('edit_registry_log');
        Route::post('/registry-update','RegistryUpdateLogController@update');
    });


    Route::group(["namespace" => "Naar","prefix" => "naar"], function () {

        Route::get('/reorder','NaarController@getReorder');
        Route::post('/reorder','NaarController@postReorder');
        Route::get('/structure','NaarController@getStructurePage')->name('edit_structure_page');
        Route::post('/structure','NaarController@postStructurePage');
        Route::get('/experts','NaarController@getExpertsPage')->name('edit_experts_page');
        Route::post('/experts','NaarController@postExpertsPage');
        Route::get('/experts_callbacks','ExpertsCallbacksController@index');
        Route::post('/experts_callbacks/delete/{item}','ExpertsCallbacksController@delete');
        Route::get('/experts_callbacks/{item}','ExpertsCallbacksController@view')->name('view_experts_callback');

        Route::group(["prefix" => "nodes"], function () {
            Route::get('/structure/{lang}','NaarNodesController@getStructurePage')->name('edit_structure_page_node');
            Route::post('/structure/{lang}','NaarNodesController@postStructurePage');
            Route::get('/experts/{lang}','NaarNodesController@getExpertsPage')->name('edit_experts_page_node');
            Route::post('/experts/{lang}','NaarNodesController@postExpertsPage');
        });

        Route::group(["namespace"=>"InternationalCoop","prefix" => 'int'],function(){

            Route::group(["prefix" => 'events'],function() {
                Route::get('/create','InternationalEventsController@create')->name('create_int_event');
                Route::post('/create','InternationalEventsController@store');
                Route::get('/edit/{item}','InternationalEventsController@edit')->name('edit_int_event');
                Route::post('/edit/{item}','InternationalEventsController@update');
                Route::post('/delete/{item}','InternationalEventsController@delete');

                Route::group(["namespace"=>"Nodes","prefix" => 'nodes'],function(){
                    Route::get('/{parent}/{lang}/create','InternationalEventsNodesController@create')->name('create_int_event_node');
                    Route::post('/{parent}/{lang}/create','InternationalEventsNodesController@store');
                    Route::post('/delete/{item}','InternationalEventsNodesController@delete');
                    Route::get('/{item}','InternationalEventsNodesController@edit')->name('edit_int_event_node');
                    Route::post('/{item}','InternationalEventsNodesController@update');
                });
            });

            Route::get('/{slug}','InternationalCoopController@indexPage')->name('edit_int_page');
            Route::post('/{slug}','InternationalCoopController@updatePage');

            Route::group(["namespace"=>"Nodes","prefix" => 'nodes'],function(){
                Route::get('/{slug}/{lang}','InternationalCoopNodesController@editNode')->name('edit_int_node');
                Route::post('/{slug}/{lang}','InternationalCoopNodesController@updateNode');
            });


        });

        Route::get('/boards','BoardsController@index');
        Route::get('/board/create','BoardsController@create')->name('create_board');
        Route::post('/board/create','BoardsController@store');
        Route::post('/board/delete/{item}','BoardsController@delete');
        Route::get('/board/{item}','BoardsController@edit')->name('edit_board');
        Route::post('/board/{item}','BoardsController@update');




        /*Tabs*/
       Route::group(["prefix" => 'commisiontabs/nodes'],function(){
            Route::get('/{parent}/{lang}/create','CommisionTabsNodesController@create')->name('create_commisiontab_node');
            Route::post('/{parent}/{lang}/create','CommisionTabsNodesController@store');
            Route::post('/delete/{item}','CommisionTabsNodesController@delete');
            Route::get('/{item}','CommisionTabsNodesController@edit')->name('edit_commisiontab_node');
            Route::post('/{item}','CommisionTabsNodesController@update');
        });




        Route::get('/commisiontabs/create/{parent}','CommisionTabsController@create')->name('create_commisiontab');
        Route::post('/commisiontabs/create/{parent}','CommisionTabsController@store');
        Route::get('/commisiontabs/{item}/{parent}','CommisionTabsController@edit')->name('edit_commisiontab');;
        Route::post('/commisiontabs/{item}','CommisionTabsController@update');
        Route::post('/commisiontabs/delete/{item}','CommisionTabsController@delete');

        /*Tabs end */
        /*files */
        Route::group(["prefix" => 'files/nodes'],function(){
            Route::get('/{parent}/{lang}/create','CommisionFilesNodesController@create')->name('create_commisionfile_node');
            Route::post('/create/{parent}/{lang}','CommisionFilesNodesController@store');
            Route::post('/delete/{item}','CommisionFilesNodesController@delete');
            Route::get('/{item}','CommisionFilesNodesController@edit')->name('edit_commisionfile_node');
            Route::post('/{item}','CommisionFilesNodesController@update');
        });


        Route::post('/files/delete/{item}','CommisionFilesController@delete');
        Route::get('/files/create/{parent}','CommisionFilesController@create')->name('create_commisionfile_postmonitoring');
        Route::post('/files/create/{parent}','CommisionFilesController@store');
        Route::get('/files/{item}/{parent}','CommisionFilesController@edit')->name('edit_commisionfile_postmonitoring');;
        Route::post('/files/{parent}/{item}','CommisionFilesController@update');

        /*files end*/
        Route::get('/board-member/{parent}/create','BoardsController@createMember')->name('create_board_member');
        Route::post('/board-member/{parent}/create','BoardsController@storeMember');
        Route::post('/board-member/delete/{item}','BoardsController@deleteMember');
        Route::get('/board-member/{parent}/{item}','BoardsController@editMember')->name('edit_board_member');
        Route::post('/board-member/{parent}/{item}','BoardsController@updateMember');

        Route::group(["prefix" => "board/nodes"], function () {
            Route::get('/board-member/{parent}/{lang}/create','BoardsNodesController@createMember')->name('create_board_member_node');
            Route::post('/board-member/{parent}/{lang}/create','BoardsNodesController@storeMember');
            Route::post('/board-member/delete/{item}','BoardsNodesController@deleteMember');
            Route::get('/board-member/{item}','BoardsNodesController@editMember')->name('edit_board_member_node');
            Route::post('/board-member/{item}','BoardsNodesController@updateMember');

            Route::get('/{parent}/{lang}/create','BoardsNodesController@create')->name('create_board_node');
            Route::post('/{parent}/{lang}/create','BoardsNodesController@store');
            Route::post('/delete/{item}','BoardsNodesController@delete');
            Route::get('/{item}','BoardsNodesController@edit')->name('edit_board_node');
            Route::post('/{item}','BoardsNodesController@update');
        });

        Route::get('/team','TeamController@index')->name('edit_team_page');
        Route::post('/team','TeamController@update');
        Route::get('/team-member/create','TeamController@createMember')->name('create_team_member');
        Route::post('team-member/create','TeamController@storeMember');
        Route::post('/team-member/delete/{item}','TeamController@deleteMember');
        Route::get('/team-member/{item}','TeamController@editMember')->name('edit_team_member');
        Route::post('/team-member/{item}','TeamController@updateMember');

        Route::group(["prefix" => "nodes/team"], function () {

            Route::get('/{lang}','TeamNodesController@index')->name('edit_team_page_node');
            Route::post('/{lang}','TeamNodesController@update');
            Route::get('/team-member/{parent}/{lang}/create','TeamNodesController@createMember')->name('create_team_member_node');
            Route::post('/team-member/{parent}/{lang}/create','TeamNodesController@storeMember');
            Route::post('/team-member/delete/{item}','TeamNodesController@deleteMember');
            Route::get('/team-member/{item}','TeamNodesController@editMember')->name('edit_team_member_node');
            Route::post('/team-member/{item}','TeamNodesController@updateMember');

        });

    });


    Route::group(["namespace" => "StaticP","prefix" => "static/{category}","middleware" => "static_page_category"],function(){
        Route::get('/hidden-page','PagesController@getHiddenPage');
        Route::post('/hidden-page','PagesController@postHiddenPage');
        Route::get('/pages','PagesController@indexPages');
        Route::get('/page/create','PagesController@createPage')->name('create_static_page');
        Route::post('/page/create','PagesController@storePage');
        Route::post('/page/delete/{item}','PagesController@deletePage');
        Route::get('/page/{item}','PagesController@editPage')->name('edit_static_page');
        Route::post('/page/{item}','PagesController@updatePage');
        Route::get('/reorder','PagesController@getReorder');
        Route::post('/reorder','PagesController@postReorder');
        Route::group(["prefix" => "nodes"], function () {

            Route::get('/hidden-page/{lang}','PagesNodesController@getHiddenPageNode')->name('edit_static_hidden_page_node');
            Route::post('/hidden-page/{lang}','PagesNodesController@postHiddenPageNode');
            Route::post('/page/delete/{item}','PagesNodesController@deletePageNode');
            Route::get('/page/{parent}/{lang}','PagesNodesController@editPageNode')->name('edit_static_page_node');
            Route::post('/page/{parent}/{lang}','PagesNodesController@updatePageNode');

        });

    });

    Route::group(["namespace" => "Experts","prefix" => "experts"],function(){
        Route::get('/directions','DirectionsController@index');
        Route::post('/get_directions','DirectionsController@getDirections');
        Route::post('/get_specs','DirectionsController@getSpecs');
        Route::post('/create_direction','DirectionsController@createDirection');
        Route::post('/create_spec','DirectionsController@createSpec');
        Route::post('/update_direction','DirectionsController@updateDirection');
        Route::post('/update_spec','DirectionsController@updateSpec');
        Route::post('/delete_spec','DirectionsController@deleteSpec');
        Route::post('/delete_direction','DirectionsController@deleteDirection');



        Route::post('/exist-dir/delete/{item}','ExistingDirsController@delete');
        Route::get('/exist-dir/{parent}/create','ExistingDirsController@create')->name('create_exist_direction');
        Route::post('/exist-dir/{parent}/create','ExistingDirsController@store');
        Route::get('/exist-dir/{parent}/{item}','ExistingDirsController@edit')->name('edit_exist_direction');
        Route::post('/exist-dir/{parent}/{item}','ExistingDirsController@update');

        Route::post('/possible-dir/delete/{item}','PossibleDirsController@delete');
        Route::get('/possible-dir/{parent}/create','PossibleDirsController@create')->name('create_possible_direction');
        Route::post('/possible-dir/{parent}/create','PossibleDirsController@store');
        Route::get('/possible-dir/{parent}/{item}','PossibleDirsController@edit')->name('edit_possible_direction');
        Route::post('/possible-dir/{parent}/{item}','PossibleDirsController@update');

        Route::get('/','ExpertsController@index')->name('admin_list_experts');
        Route::get('/create','ExpertsController@create')->name('create_expert');
        Route::post('/create','ExpertsController@store');
        Route::post('/delete/{item}','ExpertsController@delete');
        Route::get('/{item}','ExpertsController@edit')->name('edit_expert');
        Route::post('/{item}','ExpertsController@update');
    });
    Route::group(["namespace" => "Registry","prefix" => "univer"    ],function(){
        Route::group(['namespace' => 'Deqar','prefix' => 'deqar'],function(){
            Route::get('main_accr_report/{item}','DeqarApiTestController@sendMainAccrReport')->name('send_deqar_main');
            Route::get('prog_accr_report/{item}','DeqarApiTestController@sendProgramAccrReport')->name('send_deqar_prog');
            Route::get('send-all-reports','DeqarApiTestController@sendAllNonSentReports')->name('deqar_send_all');
             Route::get('send-all-reports-instituition','DeqarApiTestController@sendAllNonSentInstituitionReports')->name('deqar_send_all_instituition');
             Route::get('send-all-reports-programm','DeqarApiTestController@sendAllNonSentProgrammReports')->name('deqar_send_all_programm');
        });

        Route::group(["prefix" => "nodes"], function () {

            Route::get('/main_accr/{parent}/{lang}/create','MainAccrNodesController@create')->name('create_main_accr_node');
            Route::post('/main_accr/{parent}/{lang}/create','MainAccrNodesController@store');
            Route::post('/main_accr/delete/{item}','MainAccrNodesController@delete');
            Route::get('/main_accr/{item}','MainAccrNodesController@edit')->name('edit_main_accr_node');
            Route::post('/main_accr/{item}','MainAccrNodesController@update');

            Route::post('/program_accr/delete/{item}','ProgramAccrNodesController@delete');
            Route::get('/program_accr/{parent}/{lang}/create','ProgramAccrNodesController@create')->name('create_program_accr_node');
            Route::post('/program_accr/{parent}/{lang}/create','ProgramAccrNodesController@store');
            Route::get('/program_accr/{item}','ProgramAccrNodesController@edit')->name('edit_program_accr_node');
            Route::post('/program_accr/{item}','ProgramAccrNodesController@update');

            Route::get('/univer/{parent}/{lang}/create','UniverNodesController@create')->name('create_univer_node');
            Route::post('/univer/{parent}/{lang}/create','UniverNodesController@store');
            Route::post('/univer/delete/{item}','UniverNodesController@delete');
            Route::get('/univer/{item}','UniverNodesController@edit')->name('edit_univer_node');
            Route::post('/univer/{item}','UniverNodesController@update');

            Route::get('/ext_report/{parent}/{lang}/create','ExtReportsNodesController@create')->name('create_vek_report_node');
            Route::post('/ext_report/{parent}/{lang}/create','ExtReportsNodesController@store');
            Route::post('/ext_report/delete/{item}','ExtReportsNodesController@delete');
            Route::get('/ext_report/{item}','ExtReportsNodesController@edit')->name('edit_vek_report_node');
            Route::post('/ext_report/{item}','ExtReportsNodesController@update');

        });
        Route::post('/main_accr/delete/{item}','MainAccrController@delete');
        Route::get('/main_accr/{parent}/create','MainAccrController@create')->name('create_main_accr');
        Route::post('/main_accr/{parent}/create','MainAccrController@store');
        Route::get('/main_accr/{parent}/{item}','MainAccrController@edit')->name('edit_main_accr');
        Route::post('/main_accr/{parent}/{item}','MainAccrController@update');

        Route::get('/program_accr/replicate/{item}','ProgramAccrController@replicate')->name('replicate_program_accr');
        Route::post('/program_accr/delete/{item}','ProgramAccrController@delete');
        Route::get('/program_accr/{parent}/create','ProgramAccrController@create')->name('create_program_accr');
        Route::post('/program_accr/{parent}/create','ProgramAccrController@store');
        Route::get('/program_accr/{parent}/{item}','ProgramAccrController@edit')->name('edit_program_accr');
        Route::post('/program_accr/{parent}/{item}','ProgramAccrController@update');

        Route::post('/ext_report/delete/{item}','ExtReportsController@delete');
        Route::get('/ext_report/{parent}/create','ExtReportsController@create')->name('create_vek_report');
        Route::post('/ext_report/{parent}/create','ExtReportsController@store');
        Route::get('/ext_report/{item}','ExtReportsController@edit')->name('edit_vek_report');
        Route::post('/ext_report/{item}','ExtReportsController@update');

        Route::get('/','UniverController@index');
        Route::get('/create','UniverController@create')->name('create_univer');
        Route::post('/create','UniverController@store');
        Route::post('/delete/{item}','UniverController@delete');
        Route::get('/{item}','UniverController@edit')->name('edit_univer');
        Route::post('/{item}','UniverController@update');
    });
    Route::group(["namespace" => "Accreditation","prefix" => "accreditation/{type}"],function(){

        Route::group(["prefix" => "nodes"], function () {
            Route::get('/{parent}/{lang}','AccreditationNodesController@editNode')->name('edit_accr_page_node');
            Route::post('/{parent}/{lang}','AccreditationNodesController@updateNode');
        });

        Route::get('/','AccreditationPagesController@index')->name('accr_pages_index');
        Route::post('/delete/{item}','AccreditationPagesController@delete');
        Route::get('/create','AccreditationPagesController@create')->name('create_accr_page');
        Route::post('/create','AccreditationPagesController@store');
        Route::get('/{item}','AccreditationPagesController@edit')->name('edit_accr_page');
        Route::post('/{item}','AccreditationPagesController@update');


    });
    Route::group(["namespace" => "Postmonitorings","prefix" => "postmonitorings"],function(){


        Route::group(["prefix" => 'nodes'],function(){
            Route::get('/{parent}/{lang}/create','PostmonitoringsNodesController@create')->name('create_postmonitoring_node');
            Route::post('/{parent}/{lang}/create','PostmonitoringsNodesController@store');
            Route::post('/delete/{item}','PostmonitoringsNodesController@delete');
            Route::get('/{item}','PostmonitoringsNodesController@edit')->name('edit_postmonitorings_node');
            Route::post('/{item}','PostmonitoringsNodesController@update');
        });
        Route::get('/','PostmonitoringsController@index');
        Route::post('/delete/{item}','PostmonitoringsController@delete');
        Route::get('/create','PostmonitoringsController@create')->name('create_postmonitoring');
        Route::post('/create','PostmonitoringsController@store');
        Route::get('/{item}','PostmonitoringsController@edit')->name('postmonitoring_edit_page');
        Route::post('/{item}','PostmonitoringsController@update');




    });
    Route::group(["namespace" => "Comp","prefix" => "comps"],function(){


        Route::group(["prefix" => 'nodes'],function(){
            Route::get('/{parent}/{lang}/create','CompsNodesController@create')->name('create_comp_node');
            Route::post('/{parent}/{lang}/create','CompsNodesController@store');
            Route::post('/delete/{item}','CompsNodesController@delete');
            Route::get('/{item}','CompsNodesController@edit')->name('edit_comp_node');
            Route::post('/{item}','CompsNodesController@update');
        });
        Route::get('/','CompsController@index');
        Route::post('/delete/{item}','CompsController@delete');
        Route::get('/create','CompsController@create')->name('create_comp');
        Route::post('/create','CompsController@store');
        Route::get('/{item}','CompsController@edit')->name('comp_edit');
        Route::post('/{item}','CompsController@update');




    });
   Route::group(["namespace" => "Postmonitorings","prefix" => 'tabs'],function(){
            Route::group(["prefix" => 'nodes'],function(){
                Route::get('/{parent}/{lang}/create','TabsNodesController@create')->name('create_tabs_node');
                Route::post('/{parent}/{lang}/create','TabsNodesController@store');
                Route::post('/delete/{item}','TabsNodesController@delete');
                Route::get('/{item}','TabsNodesController@edit')->name('edit_tabs_node');
                Route::post('/{item}','TabsNodesController@update');
            });
            Route::post('/delete/{item}','TabsController@delete');
            Route::get('/create/{parent}','TabsController@create')->name('create_tab');
            Route::post('/create/{parent}','TabsController@store');
            Route::get('/{item}/{parent}','TabsController@edit')->name('edit_tab');;
            Route::post('/{item}','TabsController@update');
        });
    Route::group(["namespace" => "Postmonitorings","prefix" => 'files'],function(){
        Route::group(["prefix" => 'nodes'],function(){
            Route::get('/{parent}/{lang}/create','FilesNodesController@create')->name('create_file_node');
            Route::post('/create/{parent}/{lang}','FilesNodesController@store');
            Route::post('/delete/{item}','FilesNodesController@delete');
            Route::get('/{item}','FilesNodesController@edit')->name('edit_file_node');
            Route::post('/{item}','FilesNodesController@update');
        });
        Route::post('/delete/{item}','FilesController@delete');
        Route::get('/create/{parent}','FilesController@create')->name('create_file_postmonitoring');
        Route::post('/create/{parent}','FilesController@store');
        Route::get('/{item}/{parent}','FilesController@edit')->name('edit_file_postmonitoring');;
        Route::post('/{parent}/{item}','FilesController@update');
    });
    Route::group(["namespace" => "Postmonitorings","prefix" => 'postmonitoringfiles'],function(){
        Route::group(["prefix" => 'nodes'],function(){
            Route::get('/{parent}/{lang}/create','PostmonitoringFilesNodesController@create')->name('create_postmonitoring_file_node');
            Route::post('/create/{parent}/{lang}','PostmonitoringFilesNodesController@store');
            Route::post('/delete/{item}','PostmonitoringFilesNodesController@delete');
            Route::get('/{item}','PostmonitoringFilesNodesController@edit')->name('edit_postmonitoring_file_node');
            Route::post('/{item}','PostmonitoringFilesNodesController@update');
        });
        Route::get('/','PostmonitoringFilesController@index');
        Route::post('/delete/{item}','PostmonitoringFilesController@delete');
        Route::get('/create','PostmonitoringFilesController@create')->name('create_postmonitoring_file');
        Route::post('/create','PostmonitoringFilesController@store');
        Route::get('/{item}','PostmonitoringFilesController@edit')->name('edit_postmonitoring_file');;
        Route::post('/{item}','PostmonitoringFilesController@update');
    });
    Route::group(["namespace" => "Rating","prefix" => "rating"],function(){

        Route::get('/rating_council','RatingCouncilPageController@editPage')->name('edit_rating_council');
        Route::post('/rating_council','RatingCouncilPageController@updatePage');

        Route::get('/board-member/create','RatingCouncilPageController@createMember')->name('create_board_member_rating');
        Route::post('/board-member/create','RatingCouncilPageController@storeMember');
        Route::post('/board-member/delete/{item}','RatingCouncilPageController@deleteMember');
        Route::get('/board-member/{item}','RatingCouncilPageController@editMember')->name('edit_board_member_rating');
        Route::post('/board-member/{item}','RatingCouncilPageController@updateMember');


        Route::group(["prefix" => "nodes"], function () {
            Route::get('/rating_council/{lang}','RatingPagesNodesController@editCouncilPageNode')->name('edit_rating_council_node');
            Route::post('/rating_council/{lang}','RatingPagesNodesController@updateCouncilPageNode');
            Route::get('/{parent}/{lang}/create','RatingPagesNodesController@create')->name('create_rating_page_node');
            Route::post('/{parent}/{lang}/create','RatingPagesNodesController@store');
            Route::post('/delete/{item}','RatingPagesNodesController@delete');
            Route::get('/{item}','RatingPagesNodesController@edit')->name('edit_rating_page_node');
            Route::post('/{item}','RatingPagesNodesController@update');
        });


        Route::get('/{type}','RatingPagesController@index')->name('rating_page_index');
        Route::post('/{type}/delete/{item}','RatingPagesController@delete');
        Route::get('/{type}/create','RatingPagesController@create')->name('create_rating_page');
        Route::post('/{type}/create','RatingPagesController@store');
        Route::get('/{type}/{item}','RatingPagesController@edit')->name('edit_rating_page');
        Route::post('/{type}/{item}','RatingPagesController@update');

    });

    Route::group(["namespace" => "Reports","prefix" => "reports"],function(){


        Route::group(["prefix" => 'events'],function() {
            Route::get('/create','SmiEventsController@create')->name('create_smi_event');
            Route::post('/create','SmiEventsController@store');
            Route::get('/edit/{item}','SmiEventsController@edit')->name('edit_smi_event');
            Route::post('/edit/{item}','SmiEventsController@update');
            Route::post('/delete/{item}','SmiEventsController@delete');

            Route::group(["prefix" => 'nodes'],function(){
                Route::get('/{parent}/{lang}/create','SmiEventsNodesController@create')->name('create_smi_event_node');
                Route::post('/{parent}/{lang}/create','SmiEventsNodesController@store');
                Route::post('/delete/{item}','SmiEventsNodesController@delete');
                Route::get('/{item}','SmiEventsNodesController@edit')->name('edit_smi_event_node');
                Route::post('/{item}','SmiEventsNodesController@update');
            });
        });

        Route::group(["prefix" => 'journal'],function(){

            Route::get('/{slug}','JournalsController@editPage')->name('edit_journals_page');
            Route::post('/{slug}','JournalsController@updatePage');


            Route::get('/board-member/create','JournalsController@createMember')->name('create_board_member_journal');
            Route::post('/board-member/create','JournalsController@storeMember');
            Route::post('/board-member/delete/{item}','JournalsController@deleteMember');
            Route::get('/board-member/{item}','JournalsController@editMember')->name('edit_board_member_journal');
            Route::post('/board-member/{item}','JournalsController@updateMember');

            Route::group(["prefix" => 'nodes'],function(){
                Route::get('/{slug}/{lang}','JournalsNodesController@editNode')->name('edit_journals_node');
                Route::post('/{slug}/{lang}','JournalsNodesController@updateNode');
                Route::post('/board-member/delete/{item}','JournalsNodesController@deleteMember');
                Route::get('/board-member/{parent}','JournalsNodesController@editMemberNode')->name('edit_board_member_journal_node');
                Route::post('/board-member/{parent}/{lang}','JournalsNodesController@updateMemberNode');
            });

        });
        Route::group(["prefix" => 'nodes'],function(){

            Route::group(["prefix" => 'attachment'],function(){
                Route::get('/create/{parent}/{lang}','AttachmentsNodesController@create')->name('create_attachment_reports_node');
                Route::post('/create/{parent}/{lang}','AttachmentsNodesController@store');
                Route::post('/delete/{item}','AttachmentsNodesController@delete');
                Route::get('/{item}/{lang}','AttachmentsNodesController@edit')->name('edit_attachment_reports_node');
                Route::post('/{item}/{lang}','AttachmentsNodesController@update');
            });

            Route::get('/{type}/{lang}/edit','ReportsPagesNodesController@editNode')->name('edit_reports_page_node');
            Route::post('/{type}/{lang}/edit','ReportsPagesNodesController@updateNode');


        });
        Route::get('/{type}/edit','ReportsPagesController@edit')->name('edit_reports_page');
        Route::post('/{type}/edit','ReportsPagesController@update');
        Route::post('/{type}/attachment/{parent}/delete/{item}','AttachmentsController@delete');
        Route::get('/{type}/attachment/{parent}/create','AttachmentsController@create')->name('create_attachment');
        Route::post('/{type}/attachment/{parent}/create','AttachmentsController@store');
        Route::get('/{type}/attachment/{parent}/{item}','AttachmentsController@edit')->name('edit_attachment');
        Route::post('/{type}/attachment/{parent}/{item}','AttachmentsController@update');
    });
    Route::group(["namespace" => "AccrRequests","prefix" => "requests"],function(){
        Route::get('/forms','AccrRequestFormsController@index')->name('edit_request_form');
        Route::post('/forms','AccrRequestFormsController@update');

        Route::get('/forms/node/{lang}/create','AccrRequestFormsNodesController@create')->name('create_request_form_node');
        Route::post('/forms/node/{lang}/create','AccrRequestFormsNodesController@store');
        Route::get('/forms/node/{lang}','AccrRequestFormsNodesController@edit')->name('edit_request_form_node');
        Route::post('/forms/node/{lang}','AccrRequestFormsNodesController@update');
        //Route::post('/forms/node/delete/{item}','AccrRequestFormsNodesController@delete');

        Route::get('/','AccrRequestController@index');
        Route::post('/delete/{item}','AccrRequestController@delete');
        Route::get('/{item}','AccrRequestController@edit')->name('edit_request');
        Route::post('/{item}','AccrRequestController@update');
    });
    Route::group(["namespace" => "Articles","prefix" => "articles"],function(){
        Route::group(["prefix" => 'events'],function(){
            Route::get('/','EventsController@index');
            Route::get('/create','EventsController@create')->name('create_event');
            Route::post('/create','EventsController@store');
            Route::post('/delete/{item}','EventsController@delete');
            Route::get('/{item}','EventsController@edit')->name('edit_event');
            Route::post('/{item}','EventsController@update');
        });
        Route::group(["prefix" => 'news'],function(){
            Route::get('/','NewsController@index');
            Route::get('/create','NewsController@create')->name('create_news');
            Route::post('/create','NewsController@store');
            Route::post('/delete/{item}','NewsController@delete');
            Route::get('/{item}','NewsController@edit')->name('edit_news');
            Route::post('/{item}','NewsController@update');
        });
        Route::group(["prefix" => 'nodes'],function(){
            Route::get('/{parent}/{lang}/create','ArticleNodesController@create')->name('create_article_node');
            Route::post('/{parent}/{lang}/create','ArticleNodesController@store');
            Route::post('/delete/{item}','ArticleNodesController@delete');
            Route::get('/{item}','ArticleNodesController@edit')->name('edit_article_node');
            Route::post('/{item}','ArticleNodesController@update');

            Route::post('/attachment/delete/{item}','AttachmentsNodesController@delete');
            Route::get('/attachment/{parent}/{lang}/create','AttachmentsNodesController@create')->name('create_article_attachment_node');
            Route::post('/attachment/{parent}/{lang}/create','AttachmentsNodesController@store');
            Route::get('/attachment/{item}/{lang}','AttachmentsNodesController@edit')->name('edit_article_attachment_node');
            Route::post('/attachment/{item}/{lang}','AttachmentsNodesController@update');
        });
        Route::post('/attachment/delete/{item}','AttachmentsController@delete');
        Route::get('/attachment/{parent}/create','AttachmentsController@create')->name('create_article_attachment');
        Route::post('/attachment/{parent}/create','AttachmentsController@store');
        Route::get('/attachment/{parent}/{item}','AttachmentsController@edit')->name('edit_article_attachment');
        Route::post('/attachment/{parent}/{item}','AttachmentsController@update');

    });
    Route::group(["namespace" => "Countries","prefix" => "countries"],function(){

        Route::get('/','CountriesController@index');
        Route::get('/create','CountriesController@create')->name('create_country');
        Route::post('/create','CountriesController@store');
        Route::post('/delete/{item}','CountriesController@delete');
        Route::get('/{item}','CountriesController@edit')->name('edit_country');
        Route::post('/{item}','CountriesController@update');
        Route::group(["prefix" => "nodes"],function(){
            Route::get('/{parent}/{lang}/create','CountriesNodesController@create')->name('create_country_node');
            Route::post('/{parent}/{lang}/create','CountriesNodesController@store');
            Route::post('/delete/{item}','CountriesNodesController@delete');
            Route::get('/{item}','CountriesNodesController@edit')->name('edit_country_node');
            Route::post('/{item}','CountriesNodesController@update');
        });
    });

    Route::group(["namespace" => "Registry\Deqar","prefix" => "deqar_accr_types"],function(){

        Route::get('/','DeqarAccrTypesController@index')->name('deqar_accr_types');
        Route::get('/create','DeqarAccrTypesController@create')->name('create_deqar_accr_type');
        Route::post('/create','DeqarAccrTypesController@store');
        Route::post('/delete/{item}','DeqarAccrTypesController@delete');
        Route::get('/{item}','DeqarAccrTypesController@edit')->name('edit_deqar_accr_type');
        Route::post('/{item}','DeqarAccrTypesController@update');
    });
    Route::group(["namespace" => "Other","prefix" => "other"],function(){
        Route::group(["prefix" => "nodes"],function(){

            Route::get('/contacts/{lang}','ContactsNodesController@edit')->name('edit_contacts_node');
            Route::post('/contacts/{lang}','ContactsNodesController@update');

            Route::get('/sliders/{parent}/{lang}/create','MainSliderNodesController@create')->name('create_slider_node');
            Route::post('/sliders/{parent}/{lang}/create','MainSliderNodesController@store');
            Route::post('/sliders/delete/{item}','MainSliderNodesController@delete');
            Route::get('/sliders/{item}','MainSliderNodesController@edit')->name('edit_slider_node');
            Route::post('/sliders/{item}','MainSliderNodesController@update');

            Route::get('/partners/{parent}/{lang}/create','PartnersNodesController@create')->name('create_partners_node');
            Route::post('/partners/{parent}/{lang}/create','PartnersNodesController@store');
            Route::post('/partners/delete/{item}','PartnersNodesController@delete');
            Route::get('/partners/{item}','PartnersNodesController@edit')->name('edit_partners_node');
            Route::post('/partners/{item}','PartnersNodesController@update');

        });
        Route::get('/contacts','ContactsController@edit')->name('edit_contacts');
        Route::post('/contacts','ContactsController@update');

        Route::get('/main_partners','MainPartnersController@index');
        Route::get('/main_partners/create','MainPartnersController@create')->name('create_main_partner');
        Route::post('/main_partners/create','MainPartnersController@store');
        Route::post('/main_partners/delete/{item}','MainPartnersController@delete');
        Route::get('/main_partners/{item}','MainPartnersController@edit')->name('edit_main_partner');
        Route::post('/main_partners/{item}','MainPartnersController@update');

        Route::get('/acceptance_partners','AcceptancePartnersController@index');
        Route::get('/acceptance_partners/create','AcceptancePartnersController@create')->name('create_acceptance_partner');
        Route::post('/acceptance_partners/create','AcceptancePartnersController@store');
        Route::post('/acceptance_partners/delete/{item}','AcceptancePartnersController@delete');
        Route::get('/acceptance_partners/{item}','AcceptancePartnersController@edit')->name('edit_acceptance_partner');
        Route::post('/acceptance_partners/{item}','AcceptancePartnersController@update');

        Route::get('/sliders','MainSliderController@index');
        Route::get('/sliders/create','MainSliderController@create')->name('create_slider');
        Route::post('/sliders/create','MainSliderController@store');
        Route::post('/sliders/delete/{item}','MainSliderController@delete');
        Route::get('/sliders/{item}','MainSliderController@edit')->name('edit_slider');
        Route::post('/sliders/{item}','MainSliderController@update');
    });

    Route::group(["namespace" => "Postmonitoring","prefix" => "postmonitoring"],function(){

        Route::get('/','PostmonitoringController@edit')->name('edit_postmonitoring');
        Route::post('/','PostmonitoringController@update');
        Route::group(["prefix" => "nodes"],function(){

            Route::get('/{lang}','PostmonitoringNodesController@edit')->name('edit_postmonitoring_node');
            Route::post('/{lang}','PostmonitoringNodesController@update');

        });
    });
});

Route::post('/postRequestForm','Front\RequestController@postRequestForm');
Route::post('/postRequestCallback','Front\RequestController@postRequestCallback');
Route::group(['middleware'=> 'auth','middleware'=> 'lang_postfix'],function(){
    Route::get('/experts_database/{lang?}','ExpertBaseController@getSearch');
    Route::get('/experts_database/expert/{item}/{lang?}','ExpertBaseController@getExpert');
    Route::post('/get_expert_directions','ExpertBaseController@getAjaxDirs');
    Route::post('/get_expert_specs','ExpertBaseController@getAjaxSpecs');
});

Route::group(['middleware'=> 'lang_postfix','namespace' => 'Front'],function(){


    Route::get('/iaar/international_events/{slug}/{lang?}','IaarController@getIntEvent');
    Route::get('/iaar/{slug}/{lang?}','IaarController@getPage');




    Route::get('/reports/smi_events/{slug}/{lang?}','ReportsController@getSmiEvent');
    Route::get('/reports/vek-reports/{lang?}','ReportsController@getVekPage');
    Route::get('/reports/{slug}/{lang?}','ReportsController@getPage');

    Route::get('/registry/{lang?}','RegistryController1@getIndex');
    Route::get('/registry/univer/{item}/{lang?}','RegistryController1@getUniverPage')->name('view_univer_page');

    Route::get('/registry/program/{item}/{lang?}', 'RegistryController1@getProgramPage')->name('view_program_page');


    Route::get('/accreditations/{slug}/{lang?}','AccreditationController@getAccrPage')->name('get_accr_page');
    Route::get('/accreditation/redirect/{country_id}/{univer_type_id}/{accr_type}/{lang?}','AccreditationController@redirectAccrPage')->name('redirect_accr_page');
    Route::get('/accreditation/{lang?}','AccreditationController@getIndex')->name('get_accr_seacrh');
    Route::post('/accreditation/{lang?}','AccreditationController@postIndex')->name('post_accr_search');


    Route::get('/rating/{lang?}','RatingController@getIndex')->name('get_rating_index');
    Route::get('/rating/{country_id}/{univer_type_id}/{year}/{lang?}','RatingController@getPage')->name('get_rating_page');


    Route::get('/rating_council/{lang?}','RatingController@getCouncil');


    Route::get('/news/{slug}/{lang?}','ArticleController@getNews');
    Route::get('/news-all/{lang?}','ArticleController@getNewsList');
    Route::get('/events/{type}/{lang?}','ArticleController@getEvents');
    Route::get('/event/{slug}/{lang?}','ArticleController@getEvent');

    Route::get('/partner/{slug}/{lang?}','ArticleController@getPartner');

    Route::get('/search/{lang?}','SearchController@getSearch');

    Route::get('/request/{lang?}','RequestController@getRequestPage');
    Route::post('/request-ajax/get_document','RequestController@ajaxGetDocument');
    Route::post('/request/{lang?}','RequestController@postRequest');


    Route::get('/students/{lang?}','OtherController@getStudentsHiddenPage');
    Route::get('/students-page/{slug}/{lang?}','OtherController@getStudentsPage');




    Route::get('/forum/{lang?}','OtherController@getForumHiddenPage');
    Route::get('/forum-page/{slug}/{lang?}','OtherController@getForumPage');



    Route::get('/contacts/{lang?}','OtherController@getContactsPage');

    // Route::get('/postmonitoring/{lang?}','OtherController@getPostmonitoringPage');

    Route::get('/postmonitorings/{slug}/{lang?}','PostmonitoringsController@getPage');
    Route::get('/404/',function(){
        return view('errors.404',[
            'lang' => app()->getLocale() == 'ru' ? '' : app()->getLocale()
        ]);
    });
    Route::get('/{lang?}','IndexController@getIndex');

});
Route::post('/create-experts-callback','Front\ExpertsCallbackController@create');



Route::get('setlocale/{lang}', function ($lang) {

    $referer = Redirect::back()->getTargetUrl(); //URL предыдущей страницы
    $parse_url = parse_url($referer, PHP_URL_PATH); //URI предыдущей страницы

    //разбиваем на массив по разделителю
    $segments = explode('/', $parse_url);

    //Если URL (где нажали на переключение языка) содержал корректную метку языка
    if (in_array($segments[count($segments)-1], ['en','kz','ru'])) {
        unset($segments[count($segments)-1]); //удаляем метку
    }
   // return dump($segments);

    if($segments[0] == '' and  isset($segments[1]) and $segments[1]=='')
        unset($segments[1]);
    //Добавляем метку языка в URL (если выбран не язык по-умолчанию)
    //array_splice($segments, count($segments)-1, 0, $lang);
    if($lang !== 'ru')
        $segments[] = $lang;

    //формируем полный URL
    $url = Request::root().implode("/", $segments);

    //если были еще GET-параметры - добавляем их
    if(parse_url($referer, PHP_URL_QUERY)){
        $url = $url.'?'. parse_url($referer, PHP_URL_QUERY);
    }
    \App::setlocale($lang);
    return redirect($url); //Перенаправляем назад на ту же страницу

})->name('setlocale');

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home',function(){
    return redirect()->to('/admin/naar/structure');
});
