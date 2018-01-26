<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/22
 * Time: 20:57
 */

use \Universe\Servers\RouteServer as Route;

/**
 * $route->addRoute('GET', '/users', 'get_all_users_handler');
 * {id} must be a number (\d+)
 * $route->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
 * The /{title} suffix is optional
 * $route->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
 */


/**
 * 首页
 */
Route::get('/{id:\d+}','IndexController@index');

Route::get('/test','IndexController@test');