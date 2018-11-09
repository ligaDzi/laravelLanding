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

Route::group([], function(){

    Route::match(['get', 'post'], '/', 'IndexController@execute')->name('home');
    Route::get('/page/{alias}', 'PageController@execute')->name('page');

    Route::auth();
});

Route::group(['prefix'=>'admin', 'middleware'=>'auth'], function(){

    //admin
    Route::get('/', function(){

        if(view()->exists('admin.index')){

            $data = ['title'=> 'Панель администратора'];

            return view('admin.index', $data);
        }
    });

    //admin/pages
    Route::group(['prefix'=>'pages'], function(){

        //admin/pages
        Route::get('/', 'PagesController@execute')->name('pages');

        //admin/pages/add
        //  get- выдать форму для добавления информации в БД   
        //  post- сохранить информацию в БД          
        Route::match(['get', 'post'], '/add', 'PagesAddController@execute')->name('pagesAdd');
        
        //admin/pages/edit/2
        //  get- выдать форму со статьёй для редактирования   
        //  post- сохранить отредактированную статью в БД  
        //  delete- удалить статью из БД  
        Route::match(['get', 'post', 'delete'], '/edit/{page}', 'PagesEditController@execute')->name('pagesEdit');
    });

    //admin/portfolios
    Route::group(['prefix'=>'portfolios'], function(){

        //admin/portfolios
        Route::get('/', 'PortfolioController@execute')->name('portfolio');

        //admin/portfolios/add
        //  get- выдать форму для добавления информации в БД   
        //  post- сохранить информацию в БД          
        Route::match(['get', 'post'], '/add', 'PortfolioAddController@execute')->name('portfolioAdd');
        
        //admin/portfolios/edit/2
        //  get- выдать форму со статьёй для редактирования   
        //  post- сохранить отредактированную статью в БД  
        //  delete- удалить статью из БД  
        Route::match(['get', 'post', 'delete'], '/edit/{portfolio}', 'PortfolioEditController@execute')->name('portfolioEdit');
    });

    //admin/services
    Route::group(['prefix'=>'services'], function(){

        //admin/services
        Route::get('/', 'ServiceController@execute')->name('service');

        //admin/services/add
        //  get- выдать форму для добавления информации в БД   
        //  post- сохранить информацию в БД          
        Route::match(['get', 'post'], '/add', 'ServiceAddController@execute')->name('serviceAdd');
        
        //admin/services/edit/2
        //  get- выдать форму со статьёй для редактирования   
        //  post- сохранить отредактированную статью в БД  
        //  delete- удалить статью из БД  
        Route::match(['get', 'post', 'delete'], '/edit/{service}', 'ServiceEditController@execute')->name('serviceEdit');
    });

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('homeAuth');
