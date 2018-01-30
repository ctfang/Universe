这是一个基于swoole扩展的php框架，可以无缝运行在swoole_server模式和nginx+fpm模式，所以可以在nginx+fpm模式下开发调试，享受php语言的便捷开发，生产环境又可以拥有swoole常住内存带来的性能；本框架大量参考了laravel、和phalcon框架的功能实现，例如框架骨架使用了DI服务，所有框架先注册进入DI树，注册完后才使用，这样可以更好的扩展框架功能，哪怕是覆盖框架核心服务都行。完整的copy了laravel的路由(route)和中间件(middleware)。因为universe是常住内存运行的，所以DI服务都是一次注册多次使用，不会频繁操作IO，以实现高性能。

<p align="">
<a href="https://packagist.org/packages/selden1992/Universe"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/selden1992/Universe"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Universe

> **Note:** Universe的目标是所有注册进di的服务都由第三方开发，让更多的人参与开发

## 已经实现的功能列表

<details>
    <summary>运行使用</summary>
    
- fpm模式   ：   配置nginx到项目/public目录
- swoole模式：进入项目目录运行 php server.php；命令行启动时，文件更改不会立即生效，需要重启服务
    
</details>

<details>
    <summary>配置载入</summary>
    
所有的配置都在config目录下，默认加载配置文件
~~~~
universe/config/app.php
~~~~
    
</details>

<details open="open">
    <summary>控制器</summary>

一个基础的控制器定义
    
~~~~php
namespace App\Http\Controllers;

class IndexController extends Controller
{
    public function getString()
    {
        return '输出字符串;获取请求参数:'.$this->request->get('id','int',0);
    }

    public function getJson()
    {
        return [
            'time'=>time(),
            'string'=>'响应json格式，自动加Json Header',
        ];
    }
}
~~~~

访问上面示范两个函数需要添加路由，路由文件在 /config/route.php
    
~~~~php
Route::get('/string', 'IndexController@getString');
Route::get('/index/json', 'IndexController@getJson');
~~~~

路由器访问   http://test.test/index/json  就可以进入  getJson

</details>

<details open="open">
    <summary>路由</summary>
    
所有接口都必须在路由文件/config/route.php注册
~~~~php
Route::get('/string', 'IndexController@getString');
Route::get('/index/json', 'IndexController@getJson');

// 注册一个分组，分组内的路由都会添加 /test 前缀
// middleware参数是所有请求都会进入login中间件，例如实现/test开头的路由都必须登录后才能访问
Route::group(['prefix' => '/test', 'middleware' => 'login'],function () {
    Route::get('/one', 'IndexController@one');
    Route::get('/two', 'IndexController@two');
});
~~~~

</details>

<details open="open">
    <summary>中间件</summary>
    
中间的使用基本和laravel一模一样，中间件在控制器前还是后执行，是有中间件本身决定的，所有中间件都在目录/app/http/middleware下

~~~~php
namespace App\Http\Middleware;


use Universe\Support\Middleware;
use Universe\Swoole\Http\Request;

class AuthMiddleware extends Middleware
{
    /**
     * @param Request $request
     * @param $next
     */
    public function handle(Request $request, $next)
    {
        // 这里的代码在控制器前运行
        
        $response = $next($request);
        
        // 这里的代码在控制器后运行
        
        return $response;
    }
}
~~~~
完全由 $next($request) 决定中间件的运行前后。

当然中间一般都用来权限校验或者重定向等。
~~~~php
class AuthMiddleware extends Middleware
{
    /**
     * @param Request $request
     * @param $next
     */
    public function handle(Request $request, $next)
    {
        if( !is_login() ){
            // 没有登录重定向到登陆页面
            $request->setUri('/login');
            // 需要重新向新地址，返回 新地址 对象即可
            return $request;
        }
        
        if( !$request->get('token') ){
            /**
             * 需要验证token的接口，没有参数
             * 返回数组，获取字符串，就可以停止执行
             */
            return [
                'error'=>'403',
                'error_msg'=>'没有权限',
            ];
        }
        // 可以进入控制器
        return $next($request);
    }
}
~~~~

    
</details>

<details>
    <summary>异常服务</summary>
    
/app/Exceptions/Kernel.php 注册异常需要经过的handler
~~~~php
class Kernel extends ExceptionKernel
{
    /**
     * 注册异常处理
     *
     * @return mixed
     * @author 明月有色 <2206582181@qq.com>
     */
    public function register()
    {
        $this->server->pushHandler(new LoggerHandler());
        $this->server->pushHandler(new ShowErrorHandler());
    }
}
~~~~
    
</details>

## TODO 准备开发

- [ ] 数据模型
- [ ] 连接池
- [ ] 视图
- [ ] 事件系统
