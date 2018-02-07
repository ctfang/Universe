<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/22
 * Time: 20:57
 */

use Universe\Support\Route;


/**
 * $route->addRoute('GET', '/users', 'get_all_users_handler');
 * {id} must be a number (\d+)
 * $route->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
 * The /{title} suffix is optional
 * $route->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
 */

// 浏览器图标请求
Route::get('/favicon.ico', 'IndexController@favicon');

/**
 * 首页
 */
Route::get('/', 'IndexController@index');
Route::get('/error', 'IndexController@error');
Route::get('/index/json', 'IndexController@getJson');


Route::group(['prefix' => '/test', 'middleware' => 'login'],function () {
    Route::get('', 'IndexController@getString');
    Route::get('/echo', 'IndexController@test_echo');
    Route::get('/one', 'IndexController@one');
    Route::get('/tow', 'IndexController@tow');
    Route::get('/get', 'IndexController@testGet');
});