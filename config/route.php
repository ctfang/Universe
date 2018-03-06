<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/22
 * Time: 20:57
 */

use Universe\Support\Route;


/**
 * Route::get('/users', 'get_all_users_handler');
 * {id} must be a number (\d+)
 * Route::get('/user/{id:\d+}', 'get_user_handler');
 * The /{title} suffix is optional
 * Route::get('/articles/{id:\d+}[/{title}]', 'get_article_handler');
 */

/**
 * 首页
 */
Route::get('/', 'IndexController@index');
Route::get('/error', 'IndexController@error');
Route::get('/index/json', 'IndexController@getJson');


/**
 * 注解路由
 */
Route::annotation(\App\Http\Controllers\TestController::class);